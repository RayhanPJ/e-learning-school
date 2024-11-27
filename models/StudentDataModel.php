<?php
require_once __DIR__ . '/../config/database.php';

class StudentDataModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Fetch all student data
    public function getAllStudentData() {
        $query = "SELECT * FROM student_data";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert multiple roll numbers for a class
    public function createStudentData($starting_roll_number, $ending_roll_number, $class_id) {
        $this->db->beginTransaction();
        try {
            for ($x = $starting_roll_number; $x <= $ending_roll_number; $x++) {
                $query = "INSERT INTO student_data (rollno, class_id) VALUES (:rollno, :class_id)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':rollno', $x, PDO::PARAM_INT);
                $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Fetch student data by ID
    public function getStudentDataById($id) {
        $query = "SELECT * FROM student_data WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentsByClassId($class_id) {
        $query = "SELECT id FROM student_data WHERE class_id = :class_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':class_id', $class_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update student data
    public function updateStudentData($id, $rollno, $class_id) {
        $query = "UPDATE student_data SET rollno = :rollno, class_id = :class_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':rollno', $rollno, PDO::PARAM_INT);
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete student data by ID
    public function deleteStudentData($id) {
        $query = "DELETE FROM student_data WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
