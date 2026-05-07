<?php

class AppointmentsController extends Controller {
    public function index() {
        $user = parent::requireAuth(['pet_owner','vet','admin']);
        $role = $user['role'] ?? 'pet_owner';
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();

        $ownerPets = $role === 'pet_owner' ? $this->ownerPets($db, $userId) : [];
        $petIds = array_column($ownerPets, 'id');
        $doctorOptions = $this->doctorOptions($db);

        $labReports = $role === 'pet_owner' ? $this->labReports($db, $userId) : [];
        $referrals = $role === 'pet_owner' ? $this->referrals($db, $userId) : [];
        $appointments = $this->appointments($db, $userId, $role);

        $stats = [
            'upcomingAppointments' => count(array_filter($appointments, function ($appointment) {
                $status = strtolower((string) ($appointment['status'] ?? ''));
                return in_array($status, ['upcoming', 'scheduled', 'rescheduled', 'confirmed'], true);
            })),
            'pendingReferrals' => count(array_filter($referrals, fn($referral) => strtolower((string) ($referral['owner_response_status'] ?? 'pending')) === 'pending')),
            'availableLabReports' => count(array_filter($labReports, function ($report) {
                return strtolower((string) ($report['status'] ?? '')) !== 'archived';
            })),
        ];

        $this->view('appointments/index', [
            'role' => $role,
            'pets' => $ownerPets,
            'doctors' => $doctorOptions,
            'labReports' => $labReports,
            'referrals' => $referrals,
            'appointments' => $appointments,
            'stats' => $stats,
        ]);
    }

    public function createLabReport() {
        $user = parent::requirePostAuth('pet_owner');
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();
        $petId = (int) ($_POST['pet_id'] ?? 0);

        if (!$this->ownerOwnsPet($db, $userId, $petId)) {
            return $this->jsonError('Choose one of your pets.');
        }

        $reportTitle = trim($_POST['report_title'] ?? '');
        $reportType = trim($_POST['report_type'] ?? '');
        $doctorName = trim($_POST['doctor_name'] ?? '');
        $status = $this->normalizeStatus($_POST['status'] ?? 'pending review', ['available', 'pending review', 'reviewed', 'archived'], 'pending review');
        $notes = trim($_POST['notes'] ?? '');

        if ($reportTitle === '' || $reportType === '') {
            return $this->jsonError('Report title and type are required.');
        }

        $fileName = $this->storeReportFile('report_file');
        if (is_array($fileName) && isset($fileName['error'])) {
            return $this->jsonError($fileName['error']);
        }

        if (!$fileName) {
            return $this->jsonError('Please upload a PDF or image report file.');
        }

        $stmt = $db->prepare("
            INSERT INTO lab_reports
                (pet_id, owner_id, report_title, report_type, doctor_name, report_file, notes, status, test_name, result_summary, interpretation, file_path, report_date)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())
        ");
        $stmt->execute([
            $petId,
            $userId,
            $reportTitle,
            $reportType,
            $doctorName ?: 'Care Team',
            $fileName,
            $notes,
            $status,
            $reportTitle,
            $reportType,
            $notes,
            'reports/' . $fileName,
        ]);

        $this->notify($userId, 'Lab report uploaded', $reportTitle . ' was added to your medical hub.', 'lab_report');
        $this->jsonSuccess('Lab report uploaded successfully.');
    }

    public function updateLabReport() {
        $user = parent::requirePostAuth('pet_owner');
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();
        $report = $this->ownedRow($db, 'lab_reports', (int) ($_POST['id'] ?? 0), $userId);

        if (!$report) {
            return $this->jsonError('Lab report not found.');
        }

        $petId = (int) ($_POST['pet_id'] ?? 0);
        if (!$this->ownerOwnsPet($db, $userId, $petId)) {
            return $this->jsonError('Choose one of your pets.');
        }

        $reportTitle = trim($_POST['report_title'] ?? '');
        $reportType = trim($_POST['report_type'] ?? '');
        $doctorName = trim($_POST['doctor_name'] ?? '');
        $status = $this->normalizeStatus($_POST['status'] ?? 'available', ['available', 'pending review', 'reviewed', 'archived'], 'available');
        $notes = trim($_POST['notes'] ?? '');

        if ($reportTitle === '' || $reportType === '') {
            return $this->jsonError('Report title and type are required.');
        }

        $fileName = $report['report_file'] ?? null;
        $uploaded = $this->storeReportFile('report_file', false);
        if (is_array($uploaded) && isset($uploaded['error'])) {
            return $this->jsonError($uploaded['error']);
        }
        if ($uploaded) {
            $this->deleteReportFile($fileName);
            $fileName = $uploaded;
        }

        $stmt = $db->prepare("
            UPDATE lab_reports
            SET pet_id = ?, report_title = ?, report_type = ?, doctor_name = ?, report_file = ?, notes = ?, status = ?,
                test_name = ?, result_summary = ?, interpretation = ?, file_path = ?
            WHERE id = ? AND owner_id = ?
        ");
        $stmt->execute([
            $petId,
            $reportTitle,
            $reportType,
            $doctorName ?: 'Care Team',
            $fileName,
            $notes,
            $status,
            $reportTitle,
            $reportType,
            $notes,
            $fileName ? 'reports/' . $fileName : null,
            $report['id'],
            $userId,
        ]);

        $this->notify($userId, 'Lab report updated', $reportTitle . ' was updated successfully.', 'lab_report');
        $this->jsonSuccess('Lab report updated successfully.');
    }

    public function deleteLabReport() {
        $user = parent::requirePostAuth('pet_owner');
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();
        $report = $this->ownedRow($db, 'lab_reports', (int) ($_POST['id'] ?? 0), $userId);

        if (!$report) {
            return $this->jsonError('Lab report not found.');
        }

        $stmt = $db->prepare("DELETE FROM lab_reports WHERE id = ? AND owner_id = ?");
        $stmt->execute([$report['id'], $userId]);
        $this->deleteReportFile($report['report_file'] ?? '');
        $this->notify($userId, 'Lab report removed', ($report['report_title'] ?? 'A report') . ' was removed from your hub.', 'lab_report');
        $this->jsonSuccess('Lab report deleted successfully.');
    }

    public function respondReferral() {
        $user = parent::requirePostAuth('pet_owner');
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();
        $referral = $this->ownedRow($db, 'referrals', (int) ($_POST['id'] ?? 0), $userId);

        if (!$referral) {
            return $this->jsonError('Referral not found.');
        }

        $response = $this->normalizeStatus($_POST['response'] ?? 'pending', ['pending', 'accepted', 'rejected'], 'pending');
        if (!in_array($response, ['accepted', 'rejected'], true)) {
            return $this->jsonError('Choose to accept or reject the referral.');
        }

        $stmt = $db->prepare("
            UPDATE referrals
            SET owner_response_status = ?
            WHERE id = ? AND owner_id = ?
        ");
        $stmt->execute([$response, $referral['id'], $userId]);
        $this->notify($userId, 'Referral ' . $response, 'You ' . $response . ' a referral for ' . ($referral['referred_to'] ?? 'specialist care') . '.', 'referral');
        $this->jsonSuccess('Referral ' . $response . ' successfully.');
    }

    public function createAppointment() {
        $user = parent::requirePostAuth('pet_owner');
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();
        $petId = (int) ($_POST['pet_id'] ?? 0);
        $doctorId = (int) ($_POST['doctor_id'] ?? 0);
        $appointmentType = trim($_POST['appointment_type'] ?? '');
        $appointmentDate = trim($_POST['appointment_date'] ?? '');
        $appointmentTime = trim($_POST['appointment_time'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $status = $this->normalizeStatus($_POST['status'] ?? 'upcoming', ['upcoming', 'confirmed', 'completed', 'cancelled', 'rescheduled'], 'upcoming');

        if (!$this->ownerOwnsPet($db, $userId, $petId)) {
            return $this->jsonError('Choose one of your pets.');
        }
        if (!$this->doctorExists($db, $doctorId)) {
            return $this->jsonError('Choose a valid doctor.');
        }
        if ($appointmentType === '' || $appointmentDate === '' || $appointmentTime === '') {
            return $this->jsonError('Appointment type, date, and time are required.');
        }

        $stmt = $db->prepare("
            INSERT INTO appointments
                (owner_id, user_id, pet_id, doctor_id, appointment_type, appointment_date, appointment_time, notes, status)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $userId, $petId, $doctorId, $appointmentType, $appointmentDate, $appointmentTime, $notes, $status]);
        $this->notify($userId, 'Appointment booked', 'Your consultation was booked successfully.', 'appointment');
        $this->jsonSuccess('Appointment booked successfully.');
    }

    public function updateAppointment() {
        $user = parent::requirePostAuth('pet_owner');
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();
        $appointment = $this->ownedRow($db, 'appointments', (int) ($_POST['id'] ?? 0), $userId);

        if (!$appointment) {
            return $this->jsonError('Appointment not found.');
        }

        $petId = (int) ($_POST['pet_id'] ?? 0);
        $doctorId = (int) ($_POST['doctor_id'] ?? 0);
        $appointmentType = trim($_POST['appointment_type'] ?? '');
        $appointmentDate = trim($_POST['appointment_date'] ?? '');
        $appointmentTime = trim($_POST['appointment_time'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $status = $this->normalizeStatus($_POST['status'] ?? 'upcoming', ['upcoming', 'confirmed', 'completed', 'cancelled', 'rescheduled'], 'upcoming');

        if (!$this->ownerOwnsPet($db, $userId, $petId)) {
            return $this->jsonError('Choose one of your pets.');
        }
        if (!$this->doctorExists($db, $doctorId)) {
            return $this->jsonError('Choose a valid doctor.');
        }
        if ($appointmentType === '' || $appointmentDate === '' || $appointmentTime === '') {
            return $this->jsonError('Appointment type, date, and time are required.');
        }

        $stmt = $db->prepare("
            UPDATE appointments
            SET pet_id = ?, doctor_id = ?, appointment_type = ?, appointment_date = ?, appointment_time = ?, notes = ?, status = ?
            WHERE id = ? AND owner_id = ?
        ");
        $stmt->execute([$petId, $doctorId, $appointmentType, $appointmentDate, $appointmentTime, $notes, $status, $appointment['id'], $userId]);
        $this->notify($userId, $status === 'cancelled' ? 'Appointment cancelled' : 'Appointment updated', 'Your appointment status is now ' . $status . '.', 'appointment');
        $this->jsonSuccess($status === 'cancelled' ? 'Appointment cancelled successfully.' : 'Appointment updated successfully.');
    }

    public function deleteAppointment() {
        $user = parent::requirePostAuth('pet_owner');
        $userId = (int) $user['id'];
        $db = Database::getInstance()->getConnection();
        $appointment = $this->ownedRow($db, 'appointments', (int) ($_POST['id'] ?? 0), $userId);

        if (!$appointment) {
            return $this->jsonError('Appointment not found.');
        }

        $stmt = $db->prepare("DELETE FROM appointments WHERE id = ? AND owner_id = ?");
        $stmt->execute([$appointment['id'], $userId]);
        $this->notify($userId, 'Appointment deleted', 'An appointment was removed from your schedule.', 'appointment');
        $this->jsonSuccess('Appointment deleted successfully.');
    }

    private function ownerPets($db, $userId) {
        $stmt = $db->prepare("
            SELECT p.*, po.user_id
            FROM pets p
            INNER JOIN pet_owners po ON po.id = p.owner_id
            WHERE po.user_id = ?
            ORDER BY p.name ASC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function doctorOptions($db) {
        $stmt = $db->prepare("
            SELECT u.id, u.username, u.email, COALESCE(v.specialization, 'General Veterinary Care') AS specialization
            FROM users u
            LEFT JOIN veterinarians v ON v.user_id = u.id
            WHERE u.role = 'vet'
            ORDER BY u.username ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function labReports($db, $userId) {
        $stmt = $db->prepare("
            SELECT lr.*, p.name AS pet_name, p.species
            FROM lab_reports lr
            INNER JOIN pets p ON p.id = lr.pet_id
            WHERE lr.owner_id = ?
            ORDER BY lr.created_at DESC, lr.id DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function referrals($db, $userId) {
        $stmt = $db->prepare("
            SELECT r.*, p.name AS pet_name, p.species, from_user.username AS referred_by_name, to_user.username AS referred_to_user
            FROM referrals r
            INNER JOIN pets p ON p.id = r.pet_id
            LEFT JOIN users from_user ON from_user.id = r.referred_by
            LEFT JOIN users to_user ON to_user.id = r.to_vet_id
            WHERE r.owner_id = ?
            ORDER BY COALESCE(r.appointment_date, DATE(r.created_at)) DESC, r.id DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function appointments($db, $userId, $role) {
        $stmt = null;
        $sql = "
            SELECT a.*, p.name AS pet_name, p.species,
                   u.username AS doctor_name,
                   COALESCE(v.specialization, 'General Veterinary Care') AS specialization,
                   ou.username AS owner_name
            FROM appointments a
            INNER JOIN pets p ON p.id = a.pet_id
            LEFT JOIN users u ON u.id = a.doctor_id
            LEFT JOIN veterinarians v ON v.user_id = u.id
            LEFT JOIN pet_owners po ON po.id = p.owner_id
            LEFT JOIN users ou ON ou.id = po.user_id
        ";

        if ($role === 'pet_owner') {
            $sql .= " WHERE a.owner_id = ?";
            $stmt = $db->prepare($sql . " ORDER BY a.appointment_date ASC, a.appointment_time ASC, a.id DESC");
            $stmt->execute([$userId]);
        } elseif ($role === 'vet') {
            $sql .= " WHERE a.doctor_id = ?";
            $stmt = $db->prepare($sql . " ORDER BY a.appointment_date ASC, a.appointment_time ASC, a.id DESC");
            $stmt->execute([$userId]);
        } else {
            $stmt = $db->prepare($sql . " ORDER BY a.appointment_date ASC, a.appointment_time ASC, a.id DESC");
            $stmt->execute([]);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function ownerOwnsPet($db, $userId, $petId) {
        if ($petId <= 0) {
            return false;
        }

        $stmt = $db->prepare("
            SELECT COUNT(*)
            FROM pets p
            INNER JOIN pet_owners po ON po.id = p.owner_id
            WHERE p.id = ? AND po.user_id = ?
        ");
        $stmt->execute([$petId, $userId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function doctorExists($db, $doctorId) {
        if ($doctorId <= 0) {
            return false;
        }

        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE id = ? AND role = 'vet'");
        $stmt->execute([$doctorId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function ownedRow($db, $table, $id, $userId) {
        if ($id <= 0) {
            return null;
        }

        $stmt = $db->prepare("SELECT * FROM `$table` WHERE id = ? AND owner_id = ? LIMIT 1");
        $stmt->execute([$id, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function normalizeStatus($status, $allowed, $default) {
        $status = strtolower(trim((string) $status));
        return in_array($status, $allowed, true) ? $status : $default;
    }

    private function storeReportFile($field, $required = true) {
        if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return $required ? ['error' => 'A report file is required.'] : null;
        }

        $file = $_FILES[$field];
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) <= 0) {
            return ['error' => 'The selected file could not be uploaded.'];
        }

        if (($file['size'] ?? 0) > 8 * 1024 * 1024) {
            return ['error' => 'Report files must be 8 MB or smaller.'];
        }

        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedExtensions, true)) {
            return ['error' => 'Upload PDF, JPG, JPEG, PNG, or WEBP files only.'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = $finfo ? finfo_file($finfo, $file['tmp_name']) : '';
        if ($finfo) {
            finfo_close($finfo);
        }
        $allowedMimeTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/webp'];
        if ($mimeType && !in_array($mimeType, $allowedMimeTypes, true)) {
            return ['error' => 'The uploaded file type is not allowed.'];
        }

        $fileName = 'report_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
        $uploadDirectory = dirname(__DIR__, 2) . '/public/uploads/reports/';
        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
            return ['error' => 'The report upload directory is not available.'];
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . $fileName)) {
            return ['error' => 'The uploaded report could not be saved.'];
        }

        return $fileName;
    }

    private function deleteReportFile($fileName) {
        $fileName = trim((string) $fileName);
        if ($fileName === '') {
            return;
        }

        $path = dirname(__DIR__, 2) . '/public/uploads/reports/' . basename($fileName);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    private function jsonSuccess($message) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => $message]);
        exit;
    }

    private function jsonError($message, $statusCode = 400) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
        exit;
    }
}
