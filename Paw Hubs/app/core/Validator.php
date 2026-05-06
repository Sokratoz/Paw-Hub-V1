<?php

class Validator {
    public static function email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function phone($phone) {
        // Regex for Egyptian numbers as in your original code
        return preg_match('/^(010|011|012|015)\d{8}$/', $phone);
    }

    public static function password($password) {
        // 8-20 chars, letters and numbers
        return preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,20}$/', $password);
    }

    public static function required($data) {
        return !empty(trim($data));
    }
}
