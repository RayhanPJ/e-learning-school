<?php
require_once __DIR__ . '/../config/database.php';

class RegistersModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Method to get all registers
    public function getAllRegisters() {
        $query = "SELECT * FROM registers";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to count registers by class ID
    public function countRegistersByClassId($class_id) {
        $query = "SELECT COUNT(*) as count FROM registers WHERE class_id = :class_id and status = true";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    // Method to get register ID by roll number and class ID
    public function getRegisterIdByRollNumberAndClassId($class_id) {
        $query = "SELECT id FROM registers WHERE class_id = :class_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Method to create a new register
    public function createRegister($name, $date_of_birth, $phone, $major_id) {
        $query = "INSERT INTO registers (name, date_of_birth, phone, major_id, status) 
                  VALUES (:name, :date_of_birth, :phone, :major_id, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':date_of_birth', $date_of_birth);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':major_id', $major_id);
        $stmt->bindValue(':status', false,PDO::PARAM_BOOL);
        $stmt->execute();

        // Return the newly created register
        return $this->getRegisterById($this->db->lastInsertId());
    }

    // Method to get a register by ID
    public function getRegisterById($id) {
        $query = "SELECT * FROM registers WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update a register
    public function updateRegister($id) {
        $query = "UPDATE registers SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':status', true,PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Method to delete a register
    public function deleteRegister($id) {
        $query = "DELETE FROM registers WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>
