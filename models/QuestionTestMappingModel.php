<?php
require_once __DIR__ . '/../config/database.php';

class QuestionTestMappingModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Retrieve all mappings
    public function getAllMappings() {
        $query = "SELECT * FROM question_test_mapping"; // Assuming the table name is 'question_test_mapping'
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new mapping
    public function createMapping($question_id, $test_id) {
        $query = "INSERT INTO question_test_mapping (question_id, test_id) VALUES (:question_id, :test_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':question_id', $question_id);
        $stmt->bindValue(':test_id', $test_id);
        return $stmt->execute(); // Returns true on success
    }

    // Retrieve a mapping by question ID and test ID
    public function getMapping($question_id, $test_id) {
        $query = "SELECT * FROM question_test_mapping WHERE question_id = :question_id AND test_id = :test_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':question_id', $question_id);
        $stmt->bindValue(':test_id', $test_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns the mapping or null if not found
    }

    public function getQuestionsByTestId($test_id) {
        $query = "
            SELECT q.id, q.title, q.optionA, q.optionB, q.optionC, q.optionD, q.correctAns, q.score
            FROM questions q
            JOIN question_test_mapping qtm ON q.id = qtm.question_id
            WHERE qtm.test_id = :test_id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':test_id', $test_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all questions for the test
    }

    // Delete a mapping
    public function deleteMapping($question_id, $test_id) {
        $query = "DELETE FROM question_test_mapping WHERE question_id = :question_id AND test_id = :test_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':question_id', $question_id);
        $stmt->bindValue(':test_id', $test_id);
        return $stmt->execute(); // Returns true on success
    }
}
?>
