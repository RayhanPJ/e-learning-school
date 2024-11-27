<?php
require_once __DIR__ . '/../config/database.php';

class TestModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllTests() {
        $query = "SELECT * FROM tests";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTest($teacher_id, $name, $date, $status_id, $subject, $total_questions, $class_id) {
        $query = "INSERT INTO tests (teacher_id, name, date, status_id, subject, total_questions, class_id) 
                  VALUES (:teacher_id, :name, :date, :status_id, :subject, :total_questions, :class_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':teacher_id', $teacher_id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':status_id', $status_id);
        $stmt->bindValue(':subject', $subject);
        $stmt->bindValue(':total_questions', $total_questions);
        $stmt->bindValue(':class_id', $class_id);
        $stmt->execute();

        return $this->getTestById($this->db->lastInsertId());
    }

    public function getTestById($id) {
        $query = "SELECT * FROM tests WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTest($id, $status_id) {
        $query = "UPDATE tests SET status_id = :status_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':status_id', $status_id);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function deleteTest($id) {
        $query = "DELETE FROM tests WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>
