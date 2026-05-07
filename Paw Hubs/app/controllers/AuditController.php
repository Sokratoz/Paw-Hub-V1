<?php

class AuditController extends Controller {
    public function index() {
        $this->requireAuth('admin');
        header("Location: index.php?url=admin/privacyAudit");
        exit;
    }

    private function fetchAuditLogs($db) {
        $stmt = $db->prepare("
            SELECT
                al.*,
                COALESCE(u.username, admin_user.username, 'System') AS actor_name,
                COALESCE(u.email, admin_user.email, '') AS actor_email
            FROM audit_logs al
            LEFT JOIN users u ON u.id = al.user_id
            LEFT JOIN admins a ON a.id = al.admin_id
            LEFT JOIN users admin_user ON admin_user.id = a.user_id
            ORDER BY al.created_at DESC, al.id DESC
            LIMIT 100
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    private function fetchUser($db, $userId) {
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function countToday($db) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM audit_logs WHERE DATE(created_at) = CURDATE()");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    private function countDistinctUsers($db) {
        $stmt = $db->prepare("SELECT COUNT(DISTINCT COALESCE(user_id, admin_id)) FROM audit_logs");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
