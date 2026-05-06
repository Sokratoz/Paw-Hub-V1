<?php

class MedicalRecord {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByPet($petId) {
        $stmt = $this->db->prepare("SELECT * FROM medical_records WHERE pet_id = ?");
        $stmt->execute([$petId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($recordId) {
        $stmt = $this->db->prepare("SELECT * FROM medical_records WHERE id = ?");
        $stmt->execute([(int) $recordId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
