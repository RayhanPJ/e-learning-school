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

    public function getAllTestsWithStatus() {
        $query = "
            SELECT 
                t.*,
                m.name AS major_name,
                s.name AS status_name,
                te.username AS teacher_username
            FROM 
                tests t  -- Updated table name
            JOIN 
                major m ON t.major_id = m.id 
            JOIN 
                status s ON t.status_id = s.id
            JOIN 
                teachers te ON t.teacher_id = te.id
        ";
        
        $stmt = $this->db->prepare($query); // Prepare the statement
        $stmt->execute(); // Execute the query
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array
    }
    

    public function createTest($teacher_id, $name, $date, $status_id, $subject, $total_questions, $major_id) {
        $query = "INSERT INTO tests (teacher_id, name, date, status_id, subject, total_questions, major_id) 
                  VALUES (:teacher_id, :name, :date, :status_id, :subject, :total_questions, :major_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':teacher_id', $teacher_id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':status_id', $status_id);
        $stmt->bindValue(':subject', $subject);
        $stmt->bindValue(':total_questions', $total_questions);
        $stmt->bindValue(':major_id', $major_id);
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
