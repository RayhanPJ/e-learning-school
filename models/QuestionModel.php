<?php
require_once __DIR__ . '/../config/database.php';

class QuestionModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mengambil semua pertanyaan
    public function getAllQuestions($test_id) {
        // Query to get all questions associated with the given test_id
        $query = "
            SELECT q.*
            FROM questions q
            JOIN question_test_mapping qtm ON q.id = qtm.question_id
            WHERE qtm.test_id = :test_id
        ";
    
        $stmt = $this->db->prepare($query); // Prepare the statement
        $stmt->bindValue(':test_id', $test_id); // Bind the test_id value
        $stmt->execute(); // Execute the query
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all questions as an associative array
    }

    // Method untuk membuat pertanyaan baru
    public function createQuestion($title, $optionA, $optionB, $optionC, $optionD, $correctAns, $score) {
        $query = "INSERT INTO questions (title, optionA, optionB, optionC, optionD, correctAns, score) 
                  VALUES (:title, :optionA, :optionB, :optionC, :optionD, :correctAns, :score)"; // Kuery untuk menyimpan pertanyaan baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':title', $title); // Mengikat nilai judul
        $stmt->bindValue(':optionA', $optionA); // Mengikat nilai opsi A
        $stmt->bindValue(':optionB', $optionB); // Mengikat nilai opsi B
        $stmt->bindValue(':optionC', $optionC); // Mengikat nilai opsi C
        $stmt->bindValue(':optionD', $optionD); // Mengikat nilai opsi D
        $stmt->bindValue(':correctAns', $correctAns); // Mengikat nilai jawaban benar
        $stmt->bindValue(':score', $score); // Mengikat nilai skor
        $stmt->execute(); // Menjalankan kueri

        return $this->getQuestionById($this->db->lastInsertId()); // Mengembalikan pertanyaan yang baru dibuat
    }

    // Method untuk mengambil pertanyaan berdasarkan ID
    public function getQuestionById($id) {
        $query = "SELECT * FROM questions WHERE id = :id"; // Kuery untuk mengambil pertanyaan berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan pertanyaan sebagai array asosiatif
    }

    // Method untuk memperbarui pertanyaan
    public function updateQuestion($id, $title, $optionA, $optionB, $optionC, $optionD, $correctAns, $score) {
        $query = "UPDATE questions SET title = :title, optionA = :optionA, optionB = :optionB, 
                  optionC = :optionC, optionD = :optionD, correctAns = :correctAns, score = :score 
                  WHERE id = :id"; // Kuery untuk memperbarui pertanyaan
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':title', $title); // Mengikat nilai judul
        $stmt->bindValue(':optionA', $optionA); // Mengikat nilai opsi A
        $stmt->bindValue(':optionB', $optionB); // Mengikat nilai opsi B
        $stmt->bindValue(':optionC', $optionC); // Mengikat nilai opsi C
        $stmt->bindValue(':optionD', $optionD); // Mengikat nilai opsi D
        $stmt->bindValue(':correctAns', $correctAns); // Mengikat nilai jawaban benar
        $stmt->bindValue(':score', $score); // Mengikat nilai skor
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk menghapus pertanyaan
    public function deleteQuestion($id) {
        $query = "DELETE FROM questions WHERE id = :id"; // Kuery untuk menghapus pertanyaan berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
}
?>
