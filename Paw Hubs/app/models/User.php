<?php

class User {
    public $id;
    public $username;
    public $email;
    public $phone;
    public $password;
    public $image;
    public $role;

    private $db;
    private $columns = [];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExistsForAnotherUser($email, $id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $password) {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$password, $id]);
    }

    public function updateProfile($id, $data) {
        $fields = [
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ];

        if (!empty($data['image'])) {
            $fields['image'] = $data['image'];
        }

        if (!empty($data['password'])) {
            $fields['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $setParts = [];
        foreach ($fields as $field => $value) {
            $setParts[] = "`$field` = :$field";
        }

        $fields['id'] = $id;
        $stmt = $this->db->prepare("UPDATE users SET " . implode(', ', $setParts) . " WHERE id = :id");
        return $stmt->execute($fields);
    }

    public function create($data) {
        $fields = [
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'image' => $data['image'],
            'role' => $data['role']
        ];

        if ($this->columnExists('name')) {
            $fields['name'] = $data['username'];
        }

        if ($this->columnExists('status')) {
            $fields['status'] = $data['status'] ?? 'active';
        }

        $columns = array_keys($fields);
        $placeholders = array_map(fn($column) => ':' . $column, $columns);

        $stmt = $this->db->prepare("
            INSERT INTO users (`" . implode('`, `', $columns) . "`)
            VALUES (" . implode(', ', $placeholders) . ")
        ");
        $stmt->execute($fields);
        return $this->db->lastInsertId();
    }

    private function columnExists($column) {
        if (array_key_exists($column, $this->columns)) {
            return $this->columns[$column];
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'users'
              AND COLUMN_NAME = ?
        ");
        $stmt->execute([$column]);
        $this->columns[$column] = (int) $stmt->fetchColumn() > 0;

        return $this->columns[$column];
    }
}
