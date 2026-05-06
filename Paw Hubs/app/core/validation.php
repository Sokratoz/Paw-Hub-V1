<?php

function validate_input($data) {
    return htmlspecialchars(trim((string) $data), ENT_QUOTES, 'UTF-8');
}

function check_unique(PDO $connect, $col, $tab, $value) {
    $allowedTables = ['users'];
    $allowedColumns = ['email', 'username', 'phone'];

    if (!in_array($tab, $allowedTables, true) || !in_array($col, $allowedColumns, true)) {
        throw new InvalidArgumentException('Invalid unique check target.');
    }

    $sql = "SELECT COUNT(*) FROM `$tab` WHERE `$col` = :value";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':value' => $value]);

    return (int) $stmt->fetchColumn() > 0;
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    return preg_match('/^(010|011|012|015)\d{8}$/', $phone);
}

function validate_password($password) {
    return preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,20}$/', $password);
}

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}
