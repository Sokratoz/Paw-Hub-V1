<?php

class Controller {
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            extract($data);
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View does not exist.");
        }
    }

    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    protected function db() {
        return Database::getInstance()->getConnection();
    }

    protected function currentUser() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $stmt = $this->db()->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([(int) $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        if ($user) {
            $_SESSION['role'] = $user['role'] ?? 'pet_owner';
            $_SESSION['username'] = $user['username'] ?? ($_SESSION['username'] ?? 'User');
            $_SESSION['profile_pic'] = $user['image'] ?? ($_SESSION['profile_pic'] ?? 'default.png');
        }
        return $user;
    }

    protected function requireAuth($allowedRoles = null) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?url=auth/login");
            exit;
        }

        $user = $this->currentUser();
        if (!$user) {
            session_unset();
            session_destroy();
            header("Location: index.php?url=auth/login");
            exit;
        }

        if ($allowedRoles !== null) {
            $allowedRoles = is_array($allowedRoles) ? $allowedRoles : [$allowedRoles];
            if (!in_array($user['role'] ?? 'pet_owner', $allowedRoles, true)) {
                $this->denyAccess($user['role'] ?? 'pet_owner');
            }
        }

        return $user;
    }

    protected function requirePostAuth($allowedRoles = null) {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            exit;
        }

        return $this->requireAuth($allowedRoles);
    }

    protected function denyAccess($role = null) {
        $routes = [
            'admin' => 'admin/index',
            'vet' => 'clinical/index',
            'pet_owner' => 'home/index',
            'service_provider' => 'home/index',
        ];
        $target = $routes[$role ?? ($_SESSION['role'] ?? 'pet_owner')] ?? 'home/index';
        $_SESSION['flash_error'] = 'You are not authorized to access that page.';
        header("Location: index.php?url=" . $target);
        exit;
    }

    protected function notify($userId, $title, $message, $type = 'info') {
        if (!$userId) {
            return;
        }

        try {
            $stmt = $this->db()->prepare(
                "INSERT INTO notifications (user_id, title, message, type, is_read) VALUES (?, ?, ?, ?, 0)"
            );
            $stmt->execute([(int) $userId, $title, $message, $type]);
        } catch (PDOException $e) {
        }
    }

    protected function flash($type, $message) {
        $_SESSION['flash_' . $type] = $message;
    }
}
