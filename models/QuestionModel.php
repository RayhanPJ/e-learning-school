<?php
require_once __DIR__ . '/../config/database.php';

class QuestionModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Retrieve all questions
    public function getAllQuestions() {
        $query = "SELECT * FROM questions"; // Assuming the table name is 'questions'
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new question
    public function createQuestion($title, $optionA, $optionB, $optionC, $optionD, $correctAns, $score) {
        $query = "INSERT INTO questions (title, optionA, optionB, optionC, optionD, correctAns, score) 
                  VALUES (:title, :optionA, :optionB, :optionC, :optionD, :correctAns, :score)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':optionA', $optionA);
        $stmt->bindValue(':optionB', $optionB);
        $stmt->bindValue(':optionC', $optionC);
        $stmt->bindValue(':optionD', $optionD);
        $stmt->bindValue(':correctAns', $correctAns);
        $stmt->bindValue(':score', $score);
        $stmt->execute();

        return $this->getQuestionById($this->db->lastInsertId());
    }

    // Retrieve a question by ID
    public function getQuestionById($id) {
        $query = "SELECT * FROM questions WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a question
    public function updateQuestion($id, $title, $optionA, $optionB, $optionC, $optionD, $correctAns, $score) {
        $query = "UPDATE questions SET title = :title, optionA = :optionA, optionB = :optionB, 
                  optionC = :optionC, optionD = :optionD, correctAns = :correctAns, score = :score 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':optionA', $optionA);
        $stmt->bindValue(':optionB', $optionB);
        $stmt->bindValue(':optionC', $optionC);
        $stmt->bindValue(':optionD', $optionD);
        $stmt->bindValue(':correctAns', $correctAns);
        $stmt->bindValue(':score', $score);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Delete a question
    public function deleteQuestion($id) {
        $query = "DELETE FROM questions WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>
