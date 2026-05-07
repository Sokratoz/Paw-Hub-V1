<?php

class NotificationsController extends Controller {
    public function markRead() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0");
            $stmt->execute([$_SESSION['user_id']]);

            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Could not mark notifications as read.']);
        }
        exit;
    }
}
