<?php

class HomeController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=auth/login");
            exit;
        }

        $db = Database::getInstance()->getConnection();
        $userId = $_SESSION['user_id'];

        $user = $this->fetchOne($db, "SELECT * FROM users WHERE id = ?", [$userId]);
        $role = $user['role'] ?? ($_SESSION['role'] ?? 'pet_owner');
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: index.php?url=admin/index");
            exit;
        }

        if ($role === 'vet') {
            header("Location: index.php?url=clinical/index");
            exit;
        }

        $owner = $this->fetchOne($db, "SELECT id FROM pet_owners WHERE user_id = ?", [$userId]);
        $ownerId = $owner['id'] ?? null;

        $pets = [];
        $petIds = [];
        if ($ownerId) {
            $pets = $this->fetchAll($db, "SELECT * FROM pets WHERE owner_id = ? ORDER BY id DESC", [$ownerId]);
            $petIds = array_column($pets, 'id');
        }

        $upcomingAppointment = null;
        if ($this->tableExists($db, 'appointments')) {
            $upcomingAppointment = $this->fetchOne(
                $db,
                "SELECT a.*, p.name AS pet_name
                 FROM appointments a
                 LEFT JOIN pets p ON p.id = a.pet_id
                 WHERE a.user_id = ? AND a.appointment_date >= CURDATE()
                 ORDER BY a.appointment_date ASC
                 LIMIT 1",
                [$userId]
            );
        }

        $stats = [
            'appointment_date' => $upcomingAppointment
                ? date('M j, Y', strtotime($upcomingAppointment['appointment_date']))
                : 'No upcoming',
            'appointment_type' => $upcomingAppointment['appointment_type'] ?? 'Book your first visit',
            'vaccines_due' => $this->countForPets($db, 'vaccines', 'status', 'due', $petIds),
            'health_records' => $this->countHealthRecords($db, $petIds),
            'wellness_score' => $this->wellnessScore($db, $petIds),
            'loyalty_points' => $this->loyaltyPoints($db, $userId)
        ];

        $recommendedProducts = [
            [
                'name' => 'Premium Dog Food',
                'meta' => 'High-protein blend for active dogs',
                'price' => 'EGP 350',
                'image' => 'bag.png',
                'tone' => 'teal',
                'rating' => '4.9'
            ],
            [
                'name' => 'Squeaky Plush Toy',
                'meta' => 'Soft chew-friendly playtime favorite',
                'price' => 'EGP 180',
                'image' => 'heart.png',
                'tone' => 'green',
                'rating' => '4.8'
            ],
            [
                'name' => 'Adjustable Pet Collar',
                'meta' => 'Comfort fit with premium buckle',
                'price' => 'EGP 120',
                'image' => 'paw.png',
                'tone' => 'blue',
                'rating' => '4.7'
            ],
            [
                'name' => 'Soft Cozy Pet Bed',
                'meta' => 'Cloud-soft rest spot for naps',
                'price' => 'EGP 420',
                'image' => 'Welcome.png',
                'tone' => 'olive',
                'rating' => '4.9'
            ],
            [
                'name' => 'Durable Rope Toy',
                'meta' => 'Strong braided rope for tug play',
                'price' => 'EGP 120',
                'image' => 'paw.png',
                'tone' => 'teal',
                'rating' => '4.6'
            ]
        ];

        $this->view('home', [
            'user' => $user,
            'pets' => $pets,
            'username' => $user['username'] ?? ($_SESSION['username'] ?? 'Guest'),
            'stats' => $stats,
            'recommendedProducts' => $recommendedProducts
        ]);
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

    private function tableExists($db, $table) {
        $stmt = $db->prepare("
            SELECT COUNT(*)
            FROM INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
        ");
        $stmt->execute([$table]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function countForPets($db, $table, $statusColumn, $status, $petIds) {
        if (empty($petIds) || !$this->tableExists($db, $table)) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($petIds), '?'));
        $params = array_merge($petIds, [$status]);
        $stmt = $db->prepare("SELECT COUNT(*) FROM `$table` WHERE pet_id IN ($placeholders) AND LOWER(`$statusColumn`) = ?");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    private function countHealthRecords($db, $petIds) {
        if (empty($petIds)) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($petIds), '?'));
        $healthCount = 0;
        $medicalCount = 0;

        if ($this->tableExists($db, 'health_records')) {
            $healthStmt = $db->prepare("SELECT COUNT(*) FROM health_records WHERE pet_id IN ($placeholders)");
            $healthStmt->execute($petIds);
            $healthCount = (int) $healthStmt->fetchColumn();
        }

        if ($this->tableExists($db, 'medical_records')) {
            $medicalStmt = $db->prepare("SELECT COUNT(*) FROM medical_records WHERE pet_id IN ($placeholders)");
            $medicalStmt->execute($petIds);
            $medicalCount = (int) $medicalStmt->fetchColumn();
        }

        return $healthCount + $medicalCount;
    }

    private function wellnessScore($db, $petIds) {
        if (empty($petIds) || !$this->tableExists($db, 'wellness')) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($petIds), '?'));
        $stmt = $db->prepare("SELECT ROUND(AVG(score)) FROM wellness WHERE pet_id IN ($placeholders)");
        $stmt->execute($petIds);
        return (int) ($stmt->fetchColumn() ?: 0);
    }

    private function loyaltyPoints($db, $userId) {
        if (!$this->tableExists($db, 'loyalty_points')) {
            return 0;
        }

        $stmt = $db->prepare("SELECT COALESCE(SUM(points), 0) FROM loyalty_points WHERE user_id = ?");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }
}
