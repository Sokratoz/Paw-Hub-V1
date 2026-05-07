<?php

class AdminController extends Controller {
    public function index() {
        $this->render('dashboard');
    }

    public function users() {
        $this->render('users');
    }

    public function rooms() {
        $this->render('clinical');
    }

    public function equipment() {
        $this->render('clinical');
    }

    public function approvals() {
        $user = $this->requireAuth('admin');
        $db = Database::getInstance()->getConnection();

        $message = null;
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$message, $errors] = $this->handlePost($db, 'approvals');
        }

        $this->view('admin/approvals', [
            'adminUser' => $user,
            'message' => $message,
            'errors' => $errors,
            'bookings' => $this->procedureBookings($db),
            'workflowRequests' => $this->clinicalWorkflowRequests($db),
            'vetPermissions' => $this->vetActionPermissions($db)
        ]);
    }

    public function staff() {
        $this->render('staff');
    }

    public function reports() {
        $this->render('reports');
    }

    public function referrals() {
        $user = $this->requireAuth('admin');
        $db = Database::getInstance()->getConnection();

        $message = null;
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$message, $errors] = $this->handlePost($db, 'referrals');
        }

        $this->view('admin/referrals', [
            'adminUser' => $user,
            'message' => $message,
            'errors' => $errors,
            'referralData' => $this->referralData($db)
        ]);
    }

    public function clinical() {
        $this->render('clinical');
    }

    public function surgery() {
        $this->render('clinical_surgery');
    }

    public function labHub() {
        header("Location: index.php?url=clinical/labHub");
        exit;
    }

    public function privacyAudit() {
        $this->render('clinical_audit');
    }

    private function render($page) {
        $user = $this->requireAuth('admin');
        $db = Database::getInstance()->getConnection();

        $message = null;
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$message, $errors] = $this->handlePost($db, $page);
        }

        $this->view('admin/index', [
            'page' => $page,
            'adminUser' => $user,
            'stats' => $this->dashboardStats($db),
            'users' => $this->usersByRole($db),
            'rooms' => $this->fetchAll($db, "SELECT * FROM operating_rooms ORDER BY name ASC"),
            'equipment' => $this->fetchAll($db, "SELECT * FROM surgical_equipment ORDER BY name ASC"),
            'bookings' => $this->procedureBookings($db),
            'staff' => $this->staffMembers($db),
            'reports' => $this->analyticsData($db),
            'referralData' => $this->referralData($db),
            'clinicalData' => $this->clinicalData($db),
            'auditData' => $this->auditData($db),
            'message' => $message,
            'errors' => $errors
        ]);
    }

    private function handlePost($db, $page) {
        $action = $_POST['action'] ?? '';

        if ($action === 'add_room') {
            $name = trim($_POST['name'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $capacity = max(1, (int) ($_POST['capacity'] ?? 1));
            $status = trim($_POST['status'] ?? 'available');
            if ($name === '') {
                return [null, ['Room name is required.']];
            }
            $stmt = $db->prepare("INSERT INTO operating_rooms (name, location, capacity, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $location, $capacity, $status]);
            $this->audit($db, 'create_room', 'operating_rooms', (int) $db->lastInsertId(), "Added operating room $name");
            return ['Operating room added successfully.', []];
        }

        if ($action === 'add_equipment') {
            $name = trim($_POST['name'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $status = trim($_POST['status'] ?? 'available');
            $notes = trim($_POST['notes'] ?? '');
            if ($name === '') {
                return [null, ['Equipment name is required.']];
            }
            $stmt = $db->prepare("INSERT INTO surgical_equipment (name, type, status, notes) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $type, $status, $notes]);
            $this->audit($db, 'create_equipment', 'surgical_equipment', (int) $db->lastInsertId(), "Added surgical equipment $name");
            return ['Equipment added successfully.', []];
        }

        if (in_array($action, ['approve', 'reject', 'reschedule'], true)) {
            $bookingId = (int) ($_POST['booking_id'] ?? 0);
            if (!$bookingId) {
                return [null, ['Choose a surgery request first.']];
            }

            if ($action === 'reschedule') {
                $date = trim($_POST['procedure_date'] ?? '');
                $startTime = trim($_POST['start_time'] ?? '');
                $endTime = trim($_POST['end_time'] ?? '');
                $start = strtotime("$date $startTime");
                $end = strtotime("$date $endTime");
                if (!$date || !$startTime || !$endTime || $start === false || $end === false || $start >= $end) {
                    return [null, ['Enter a valid reschedule date and time window.']];
                }
                $stmt = $db->prepare("UPDATE procedure_bookings SET start_time = ?, end_time = ?, status = 'scheduled' WHERE id = ?");
                $stmt->execute([date('Y-m-d H:i:s', $start), date('Y-m-d H:i:s', $end), $bookingId]);
                $this->audit($db, 'reschedule_surgery', 'procedure_bookings', $bookingId, 'Rescheduled surgery request.');
                return ['Surgery request rescheduled.', []];
            }

            $status = $action === 'approve' ? 'approved' : 'rejected';
            $stmt = $db->prepare("UPDATE procedure_bookings SET status = ? WHERE id = ?");
            $stmt->execute([$status, $bookingId]);
            $this->audit($db, $action . '_surgery', 'procedure_bookings', $bookingId, ucfirst($status) . ' surgery request.');
            return ['Surgery request ' . $status . '.', []];
        }

        if ($action === 'update_referral') {
            return $this->updateReferral($db);
        }

        if ($action === 'review_clinical_request') {
            return $this->reviewClinicalRequest($db);
        }

        if ($action === 'update_vet_permission') {
            return $this->updateVetPermission($db);
        }

        if ($action === 'update_room') {
            return $this->updateRoom($db);
        }

        if ($action === 'update_equipment') {
            return $this->updateEquipment($db);
        }

        if ($action === 'update_procedure') {
            return $this->updateProcedure($db);
        }

        if ($action === 'update_lab_report') {
            return $this->updateLabReport($db);
        }

        return [null, []];
    }

    private function updateRoom($db) {
        $roomId = (int) ($_POST['room_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $capacity = max(1, (int) ($_POST['capacity'] ?? 1));
        $status = trim($_POST['status'] ?? 'available');

        if (!$roomId || $name === '') {
            return [null, ['Choose a valid room and enter its name.']];
        }

        $stmt = $db->prepare("UPDATE operating_rooms SET name = ?, location = ?, capacity = ?, status = ? WHERE id = ?");
        $stmt->execute([$name, $location, $capacity, $status, $roomId]);
        $this->audit($db, 'update_room', 'operating_rooms', $roomId, "Updated operating room $name.");

        return ['Operating room updated successfully.', []];
    }

    private function updateEquipment($db) {
        $equipmentId = (int) ($_POST['equipment_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $type = trim($_POST['type'] ?? '');
        $status = trim($_POST['status'] ?? 'available');
        $notes = trim($_POST['notes'] ?? '');

        if (!$equipmentId || $name === '') {
            return [null, ['Choose valid equipment and enter its name.']];
        }

        $stmt = $db->prepare("UPDATE surgical_equipment SET name = ?, type = ?, status = ?, notes = ? WHERE id = ?");
        $stmt->execute([$name, $type, $status, $notes, $equipmentId]);
        $this->audit($db, 'update_equipment', 'surgical_equipment', $equipmentId, "Updated surgical equipment $name.");

        return ['Equipment updated successfully.', []];
    }

    private function updateProcedure($db) {
        $procedureId = (int) ($_POST['procedure_id'] ?? 0);
        $name = trim($_POST['procedure_name'] ?? '');
        $type = trim($_POST['procedure_type'] ?? '');
        $status = trim($_POST['status'] ?? 'scheduled');
        $date = trim($_POST['procedure_date'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        if (!$procedureId || $name === '') {
            return [null, ['Choose a valid procedure and enter its name.']];
        }

        $stmt = $db->prepare(
            "UPDATE medical_procedures
             SET procedure_name = ?, procedure_type = ?, status = ?, procedure_date = NULLIF(?, ''), notes = ?
             WHERE id = ?"
        );
        $stmt->execute([$name, $type, $status, $date, $notes, $procedureId]);
        $this->audit($db, 'procedure_updated', 'medical_procedures', $procedureId, "Updated medical procedure $name.");

        return ['Medical procedure updated successfully.', []];
    }

    private function updateLabReport($db) {
        $reportId = (int) ($_POST['report_id'] ?? 0);
        $testName = trim($_POST['test_name'] ?? '');
        $summary = trim($_POST['result_summary'] ?? '');
        $interpretation = trim($_POST['interpretation'] ?? '');
        $status = trim($_POST['status'] ?? 'pending');
        $date = trim($_POST['report_date'] ?? '');

        if (!$reportId || $testName === '') {
            return [null, ['Choose a valid lab report and enter test name.']];
        }

        $stmt = $db->prepare(
            "UPDATE lab_reports
             SET test_name = ?, result_summary = ?, interpretation = ?, status = ?, report_date = NULLIF(?, '')
             WHERE id = ?"
        );
        $stmt->execute([$testName, $summary, $interpretation, $status, $date, $reportId]);
        $this->audit($db, 'lab_report_updated', 'lab_reports', $reportId, "Updated lab report $testName.");

        return ['Lab report updated successfully.', []];
    }

    private function updateReferral($db) {
        $referralId = (int) ($_POST['referral_id'] ?? 0);
        $specialty = trim($_POST['specialty'] ?? '');
        $priority = trim($_POST['priority'] ?? 'normal');
        $status = trim($_POST['status'] ?? 'pending');
        $reason = trim($_POST['reason'] ?? '');
        $notes = trim($_POST['notes'] ?? '');

        if (!$referralId || $specialty === '') {
            return [null, ['Choose a valid referral and enter specialty.']];
        }

        $stmt = $db->prepare(
            "UPDATE referrals
             SET specialty = ?, priority = ?, status = ?, reason = ?, notes = ?
             WHERE id = ?"
        );
        $stmt->execute([$specialty, $priority, $status, $reason, $notes, $referralId]);
        $this->audit($db, 'referral_updated', 'referrals', $referralId, "Updated referral status to $status.");

        return ['Referral updated successfully.', []];
    }

    private function reviewClinicalRequest($db) {
        $requestId = (int) ($_POST['request_id'] ?? 0);
        $decision = trim($_POST['decision'] ?? '');
        if (!$requestId || !in_array($decision, ['approve', 'reject'], true)) {
            return [null, ['Choose a valid workflow request and decision.']];
        }

        $status = $decision === 'approve' ? 'approved' : 'rejected';
        $stmt = $db->prepare(
            "UPDATE clinical_action_requests
             SET admin_status = ?, request_status = ?, decided_by = ?
             WHERE id = ?"
        );
        $stmt->execute([$status, $status, $_SESSION['user_id'] ?? null, $requestId]);
        $this->audit($db, 'clinical_request_' . $status, 'clinical_action_requests', $requestId, ucfirst($status) . ' clinical workflow request.');
        return ['Clinical workflow request ' . $status . '.', []];
    }

    private function updateVetPermission($db) {
        $permissionId = (int) ($_POST['permission_id'] ?? 0);
        $accessMode = trim($_POST['access_mode'] ?? 'request_admin');
        if (!$permissionId || !in_array($accessMode, ['request_user', 'request_admin', 'approve_user'], true)) {
            return [null, ['Choose a valid vet permission and access mode.']];
        }

        $stmt = $db->prepare(
            "UPDATE vet_action_permissions
             SET access_mode = ?, updated_by = ?
             WHERE id = ?"
        );
        $stmt->execute([$accessMode, $_SESSION['user_id'] ?? null, $permissionId]);
        $this->audit($db, 'vet_permission_updated', 'vet_action_permissions', $permissionId, "Updated vet access mode to $accessMode.");
        return ['Vet action permission updated successfully.', []];
    }

    private function dashboardStats($db) {
        return [
            'users' => $this->countRows($db, 'users'),
            'vets' => $this->countRows($db, 'veterinarians'),
            'procedures' => $this->countRows($db, 'procedure_bookings'),
            'available_rooms' => $this->countRows($db, 'operating_rooms', "LOWER(status) = 'available'"),
            'revenue' => $this->sumColumn($db, 'orders', 'total_price')
        ];
    }

    private function usersByRole($db) {
        return [
            'owners' => $this->fetchAll($db, "SELECT u.*, po.address FROM users u INNER JOIN pet_owners po ON po.user_id = u.id ORDER BY u.created_at DESC"),
            'vets' => $this->fetchAll($db, "SELECT u.*, v.license_number, v.specialization FROM users u INNER JOIN veterinarians v ON v.user_id = u.id ORDER BY u.created_at DESC"),
            'staff' => $this->fetchAll($db, "SELECT * FROM users WHERE role IN ('admin', 'service_provider') ORDER BY created_at DESC")
        ];
    }

    private function procedureBookings($db) {
        $bookings = $this->fetchAll(
            $db,
            "SELECT pb.*, p.name AS pet_name, r.name AS room_name, e.name AS equipment_name, u.username AS specialist_name
             FROM procedure_bookings pb
             LEFT JOIN pets p ON p.id = pb.pet_id
             LEFT JOIN operating_rooms r ON r.id = pb.room_id
             LEFT JOIN surgical_equipment e ON e.id = pb.equipment_id
             LEFT JOIN veterinarians v ON v.id = pb.specialist_id
             LEFT JOIN users u ON u.id = v.user_id
             ORDER BY pb.start_time DESC, pb.id DESC"
        );

        foreach ($bookings as &$booking) {
            $booking['conflict_summary'] = $this->bookingConflictSummary($db, $booking);
            $booking['room_suggestion'] = $this->availableRoomForWindow($db, $booking['start_time'], $booking['end_time'], (int) $booking['room_id']);
        }
        unset($booking);

        return $bookings;
    }

    private function bookingConflictSummary($db, $booking) {
        $checks = [
            ['field' => 'room_id', 'label' => 'Room'],
            ['field' => 'equipment_id', 'label' => 'Equipment'],
            ['field' => 'specialist_id', 'label' => 'Specialist']
        ];
        $conflicts = [];

        foreach ($checks as $check) {
            $stmt = $db->prepare(
                "SELECT COUNT(*)
                 FROM procedure_bookings
                 WHERE id != ?
                   AND status NOT IN ('cancelled', 'rejected')
                   AND {$check['field']} = ?
                   AND NOT (end_time <= ? OR start_time >= ?)"
            );
            $stmt->execute([
                (int) $booking['id'],
                (int) $booking[$check['field']],
                $booking['start_time'],
                $booking['end_time']
            ]);
            if ((int) $stmt->fetchColumn() > 0) {
                $conflicts[] = $check['label'];
            }
        }

        return empty($conflicts) ? 'No conflicts' : implode(', ', $conflicts);
    }

    private function availableRoomForWindow($db, $start, $end, $currentRoomId = 0) {
        $stmt = $db->prepare(
            "SELECT r.name
             FROM operating_rooms r
             WHERE r.id != ?
               AND LOWER(COALESCE(r.status, 'available')) = 'available'
               AND NOT EXISTS (
                   SELECT 1
                   FROM procedure_bookings pb
                   WHERE pb.room_id = r.id
                     AND pb.status NOT IN ('cancelled', 'rejected')
                     AND NOT (pb.end_time <= ? OR pb.start_time >= ?)
               )
             ORDER BY r.name ASC
             LIMIT 1"
        );
        $stmt->execute([$currentRoomId, $start, $end]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        return $room['name'] ?? null;
    }

    private function staffMembers($db) {
        return $this->fetchAll(
            $db,
            "SELECT v.id, u.username, u.email, v.specialization, COUNT(pb.id) AS assigned_surgeries
             FROM veterinarians v
             LEFT JOIN users u ON u.id = v.user_id
             LEFT JOIN procedure_bookings pb ON pb.specialist_id = v.id AND pb.status != 'cancelled'
             GROUP BY v.id, u.username, u.email, v.specialization
             ORDER BY assigned_surgeries DESC, u.username ASC"
        );
    }

    private function analyticsData($db) {
        return [
            'monthly' => $this->fetchAll($db, "SELECT DATE_FORMAT(start_time, '%Y-%m') AS month, COUNT(*) AS total FROM procedure_bookings GROUP BY DATE_FORMAT(start_time, '%Y-%m') ORDER BY month DESC LIMIT 8"),
            'top_vets' => $this->fetchAll($db, "SELECT u.username, COUNT(pb.id) AS total FROM procedure_bookings pb LEFT JOIN veterinarians v ON v.id = pb.specialist_id LEFT JOIN users u ON u.id = v.user_id GROUP BY u.username ORDER BY total DESC LIMIT 5"),
            'room_usage' => $this->fetchAll($db, "SELECT r.name, COUNT(pb.id) AS total FROM operating_rooms r LEFT JOIN procedure_bookings pb ON pb.room_id = r.id GROUP BY r.id, r.name ORDER BY total DESC LIMIT 5"),
            'equipment_usage' => $this->fetchAll($db, "SELECT e.name, COUNT(pb.id) AS total FROM surgical_equipment e LEFT JOIN procedure_bookings pb ON pb.equipment_id = e.id GROUP BY e.id, e.name ORDER BY total DESC LIMIT 5")
        ];
    }

    private function referralData($db) {
        return [
            'referrals' => $this->fetchAll(
                $db,
                "SELECT r.*, p.name AS pet_name, from_user.username AS sender_name, to_user.username AS receiver_name
                 FROM referrals r
                 LEFT JOIN pets p ON p.id = r.pet_id
                 LEFT JOIN veterinarians from_v ON from_v.id = r.from_vet_id
                 LEFT JOIN users from_user ON from_user.id = from_v.user_id
                 LEFT JOIN veterinarians to_v ON to_v.id = r.to_vet_id
                 LEFT JOIN users to_user ON to_user.id = to_v.user_id
                 ORDER BY r.requested_at DESC, r.id DESC"
            )
        ];
    }

    private function clinicalData($db) {
        return [
            'procedures' => $this->fetchAll(
                $db,
                "SELECT mp.*, p.name AS pet_name, vu.username AS vet_name
                 FROM medical_procedures mp
                 LEFT JOIN pets p ON p.id = mp.pet_id
                 LEFT JOIN veterinarians v ON v.id = mp.vet_id
                 LEFT JOIN users vu ON vu.id = v.user_id
                 ORDER BY COALESCE(mp.procedure_date, DATE(mp.created_at)) DESC, mp.id DESC"
            ),
            'labReports' => $this->fetchAll(
                $db,
                "SELECT lr.*, p.name AS pet_name, vu.username AS vet_name
                 FROM lab_reports lr
                 LEFT JOIN pets p ON p.id = lr.pet_id
                 LEFT JOIN veterinarians v ON v.id = lr.vet_id
                 LEFT JOIN users vu ON vu.id = v.user_id
                 ORDER BY COALESCE(lr.report_date, DATE(lr.created_at)) DESC, lr.id DESC"
            ),
            'referrals' => $this->referralData($db)['referrals'],
            'auditLogs' => $this->fetchAll(
                $db,
                "SELECT al.*, COALESCE(u.username, 'System') AS username
                 FROM audit_logs al
                 LEFT JOIN users u ON u.id = al.user_id
                 WHERE LOWER(COALESCE(al.entity_type, '')) IN ('medical_procedures', 'lab_reports', 'referrals', 'medical_records')
                    OR LOWER(al.action) LIKE '%procedure%'
                    OR LOWER(al.action) LIKE '%lab%'
                    OR LOWER(al.action) LIKE '%referral%'
                 ORDER BY al.created_at DESC, al.id DESC
                 LIMIT 100"
            )
        ];
    }

    private function clinicalWorkflowRequests($db) {
        return $this->fetchAll(
            $db,
            "SELECT car.*, p.name AS pet_name, requester.username AS requester_name, owner_user.username AS owner_name, vet_user.username AS vet_name
             FROM clinical_action_requests car
             LEFT JOIN pets p ON p.id = car.pet_id
             LEFT JOIN users requester ON requester.id = car.requester_user_id
             LEFT JOIN users owner_user ON owner_user.id = car.owner_user_id
             LEFT JOIN veterinarians vv ON vv.id = car.target_vet_id
             LEFT JOIN users vet_user ON vet_user.id = vv.user_id
             ORDER BY car.updated_at DESC, car.id DESC"
        );
    }

    private function vetActionPermissions($db) {
        return $this->fetchAll(
            $db,
            "SELECT vap.*, vet_user.username AS vet_name, vv.specialization, updater.username AS updated_by_name
             FROM vet_action_permissions vap
             LEFT JOIN veterinarians vv ON vv.id = vap.vet_id
             LEFT JOIN users vet_user ON vet_user.id = vv.user_id
             LEFT JOIN users updater ON updater.id = vap.updated_by
             ORDER BY vet_user.username ASC, FIELD(vap.action_key, 'lab_reports', 'referrals', 'surgery_booking', 'medical_records')"
        );
    }

    private function auditData($db) {
        $logs = $this->fetchAll(
            $db,
            "SELECT
                al.*,
                COALESCE(u.username, admin_user.username, 'System') AS actor_name,
                COALESCE(u.email, admin_user.email, '') AS actor_email
             FROM audit_logs al
             LEFT JOIN users u ON u.id = al.user_id
             LEFT JOIN admins a ON a.id = al.admin_id
             LEFT JOIN users admin_user ON admin_user.id = a.user_id
             ORDER BY al.created_at DESC, al.id DESC
             LIMIT 100"
        );

        return [
            'logs' => $logs,
            'recentLogs' => array_slice($logs, 0, 6),
            'stats' => [
                'total' => count($logs),
                'today' => $this->countRows($db, 'audit_logs', 'DATE(created_at) = CURDATE()'),
                'users' => $this->countDistinctAuditActors($db),
                'latest' => $logs[0]['created_at'] ?? null
            ]
        ];
    }

    private function countDistinctAuditActors($db) {
        $stmt = $db->prepare("SELECT COUNT(DISTINCT COALESCE(user_id, admin_id)) FROM audit_logs");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    private function audit($db, $action, $entityType, $entityId, $details) {
        $stmt = $db->prepare("INSERT INTO audit_logs (user_id, entity_type, entity_id, action, details, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'] ?? null, $entityType, $entityId, $action, $details, $_SERVER['REMOTE_ADDR'] ?? null]);
    }

    private function countRows($db, $table, $where = null) {
        $sql = "SELECT COUNT(*) FROM `$table`";
        if ($where) {
            $sql .= " WHERE $where";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    private function sumColumn($db, $table, $column) {
        $stmt = $db->prepare("SELECT COALESCE(SUM(`$column`), 0) FROM `$table`");
        $stmt->execute();
        return (float) $stmt->fetchColumn();
    }

    private function fetchOne($db, $sql, $params = []) {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function fetchAll($db, $sql, $params = []) {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
