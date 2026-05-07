<?php

class AboutController extends Controller {
    public function index() {
        $db = Database::getInstance()->getConnection();

        $stats = [
            'orders_total' => $this->countRows($db, 'orders'),
            'orders_success' => $this->countOrdersSuccess($db),
            'doctor_rating' => $this->averageDoctorRating($db) ?? 0,
            'service_rating' => $this->averageServiceRating($db) ?? 0,
            'active_users' => $this->countRows($db, 'users'),
            'reviews' => $this->getTopReviews($db, 6)
        ];

        $this->view('about', ['stats' => $stats]);
    }

    private function tableExists($db, $table) {
        $stmt = $db->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?"
        );
        $stmt->execute([$table]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function columnExists($db, $table, $column) {
        if (!$this->tableExists($db, $table)) {
            return false;
        }
        $stmt = $db->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?"
        );
        $stmt->execute([$table, $column]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function countRows($db, $table) {
        if (!$this->tableExists($db, $table)) {
            return 0;
        }
        $stmt = $db->prepare("SELECT COUNT(*) FROM `$table`");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    private function countOrdersSuccess($db) {
        if (!$this->tableExists($db, 'orders')) {
            return 0;
        }

        if ($this->columnExists($db, 'orders', 'status')) {
            $stmt = $db->prepare(
                "SELECT COUNT(*) FROM orders WHERE LOWER(status) IN ('completed', 'delivered', 'paid', 'success')"
            );
            $stmt->execute();
            $count = (int) $stmt->fetchColumn();
            if ($count > 0) {
                return $count;
            }
        }

        if ($this->columnExists($db, 'orders', 'is_paid')) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM orders WHERE is_paid IN (1, '1', 't', 'true')");
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        }

        return $this->countRows($db, 'orders');
    }

    private function averageDoctorRating($db) {
        if (!$this->tableExists($db, 'reviews') || !$this->columnExists($db, 'reviews', 'rating')) {
            return null;
        }

        $byVet = $this->columnExists($db, 'reviews', 'vet_id');
        $byDoctor = $this->columnExists($db, 'reviews', 'doctor_id');

        if ($byVet || $byDoctor) {
            $column = $byVet ? 'vet_id' : 'doctor_id';
            $stmt = $db->prepare("SELECT AVG(rating) FROM reviews WHERE $column IS NOT NULL AND rating IS NOT NULL");
            $stmt->execute();
            return $this->formatRating($stmt->fetchColumn());
        }

        return null;
    }

    private function averageServiceRating($db) {
        if (!$this->tableExists($db, 'reviews') || !$this->columnExists($db, 'reviews', 'rating')) {
            return null;
        }

        $stmt = $db->prepare("SELECT AVG(rating) FROM reviews WHERE rating IS NOT NULL");
        $stmt->execute();
        return $this->formatRating($stmt->fetchColumn());
    }

    private function getTopReviews($db, $limit = 6) {
        if (!$this->tableExists($db, 'reviews')) {
            return [];
        }

        $limit = (int) $limit;
        if ($limit <= 0) {
            $limit = 6;
        }

        try {
            $query = "SELECT 
                        r.id, 
                        r.owner_id, 
                        r.service_id, 
                        r.rating, 
                        r.comment, 
                        r.created_at,
                        COALESCE(u.username, u.name, CONCAT('User #', r.owner_id)) as owner_name,
                        COALESCE(s.name, CONCAT('Service #', r.service_id)) as service_name
                      FROM reviews r
                      LEFT JOIN pet_owners po ON po.id = r.owner_id
                      LEFT JOIN users u ON u.id = po.user_id
                      LEFT JOIN services s ON r.service_id = s.id
                      WHERE r.rating IS NOT NULL 
                      ORDER BY r.rating DESC, r.created_at DESC 
                      LIMIT $limit";
            $stmt = $db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    private function formatRating($value) {
        if ($value === false || $value === null) {
            return null;
        }
        return round((float) $value, 1);
    }
}
