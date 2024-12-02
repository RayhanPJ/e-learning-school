<?php
require_once __DIR__ . '/../config/database.php';

class ScoreModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Create a new score entry
    public function createScore($test_id, $question_id) {
        $query = "INSERT INTO score (test_id, question_id, correct_count, wrong_count) VALUES (:test_id, :question_id, 0, 0)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':test_id', $test_id);
        $stmt->bindValue(':question_id', $question_id);
        return $stmt->execute(); // Returns true on success
    }

    // Update correct count for a question
    public function updateCorrectCount($question_id) {
        $sql = "UPDATE score SET correct_count = correct_count + 1 WHERE question_id = :question_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':question_id', $question_id);
        return $stmt->execute(); // Returns true on success
    }

    // Update student's total score
    public function updateStudentScore($student_id, $score_earned) {
        $update_student_score = "UPDATE students SET score = score + :score_earned WHERE id = :student_id";
        $stmt = $this->db->prepare($update_student_score);
        $stmt->bindValue(':score_earned', $score_earned);
        $stmt->bindValue(':student_id', $student_id);
        return $stmt->execute(); // Returns true on success
    }
}
?>
