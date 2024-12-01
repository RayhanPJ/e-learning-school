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

    public function getAllRegistersWithMajor() {
        $query = "
            SELECT r.*, m.name AS major_name, m.price AS major_price
            FROM registers r
            JOIN major m ON r.major_id = m.id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to count registers by class ID
    public function countRegisterByMajorId($major_id) {
        $query = "SELECT COUNT(*) as count FROM registers WHERE major_id = :major_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':major_id', $major_id, PDO::PARAM_INT);
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
        $query = "INSERT INTO registers (name, date_of_birth, phone, major_id, status_payment) 
                  VALUES (:name, :date_of_birth, :phone, :major_id, :status_payment)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':date_of_birth', $date_of_birth);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':major_id', $major_id);
        $stmt->bindValue(':status_payment', false);
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

    public function getRegisterWithMajorById($id) {
        $query = "
            SELECT r.*, m.name AS major_name, m.price AS major_price
            FROM registers r
            JOIN major m ON r.major_id = m.id
            WHERE r.id = :id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update a register
    public function confirmRegister($id, $status_payment) {
        $query = "UPDATE registers SET status_payment = :status_payment WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':status_payment', $status_payment);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function updateRegister($id, $name, $date_of_birth, $phone, $major_id) {
        $query = "UPDATE registers SET name = :name, date_of_birth = :date_of_birth, phone = :phone, major_id = :major_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':date_of_birth', $date_of_birth);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':major_id', $major_id);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Method to delete a register
    public function deleteRegister($id) {
        // Hapus data dari tabel student_data yang memiliki registers_id yang sama
        $deleteStudentDataQuery = "DELETE FROM student_data WHERE registers_id = :registers_id";
        $stmt = $this->db->prepare($deleteStudentDataQuery);
        $stmt->bindValue(':registers_id', $id);
        $stmt->execute(); // Eksekusi penghapusan dari student_data
    
        // Hapus data dari tabel registers
        $deleteRegisterQuery = "DELETE FROM registers WHERE id = :id";
        $stmt = $this->db->prepare($deleteRegisterQuery);
        $stmt->bindValue(':id', $id);
        
        return $stmt->execute(); // Mengembalikan hasil eksekusi penghapusan dari registers
    }
    
}
?>
