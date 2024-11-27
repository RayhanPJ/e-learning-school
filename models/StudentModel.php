<?php
require_once __DIR__ . '/../config/database.php';

class StudentModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllStudents() {
        $query = "SELECT * FROM students";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createStudent($test_id, $rollno, $password, int $score = 0, int $status = 0) {
        $query = "INSERT INTO students (test_id, rollno, password, score, status) 
                  VALUES (:test_id, :rollno, :password, :score, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':test_id', $test_id);
        $stmt->bindValue(':rollno', $rollno);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':score', $score);
        $stmt->bindValue(':status', $status);
        $stmt->execute();

        return $this->getStudentById($this->db->lastInsertId());
    }

    public function getStudentById($id) {
        $query = "SELECT * FROM students WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStudent($id, $score, $status) {
        $query = "UPDATE students SET score = :score, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':score', $score);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function deleteStudent($id) {
        $query = "DELETE FROM students WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>
