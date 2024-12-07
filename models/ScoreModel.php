<?php
require_once __DIR__ . '/../config/database.php';

class ScoreModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk membuat entri skor baru
    public function createScore($test_id, $question_id, $student_id) {
        $query = "INSERT INTO score (test_id, question_id, student_id, correct_count, wrong_count) VALUES (:test_id, :question_id, :student_id, 0, 0)";
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        $stmt->bindValue(':question_id', $question_id); // Mengikat nilai question_id
        $stmt->bindValue(':student_id', $student_id); // Mengikat nilai student_id
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk memperbarui jumlah jawaban salah untuk pertanyaan
    public function updateWrongCount($question_id, $student_id) {
        $sql = "UPDATE score SET wrong_count = wrong_count + 1 WHERE question_id = :question_id AND student_id = :student_id";
        $stmt = $this->db->prepare($sql); // Menyiapkan pernyataan
        $stmt->bindValue(':question_id', $question_id); // Mengikat nilai question_id
        $stmt->bindValue(':student_id', $student_id); // Mengikat nilai student_id
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk memperbarui jumlah jawaban benar untuk pertanyaan
    public function updateCorrectCount($question_id, $student_id) {
        $sql = "UPDATE score SET correct_count = correct_count + 1 WHERE question_id = :question_id AND student_id = :student_id";
        $stmt = $this->db->prepare($sql); // Menyiapkan pernyataan
        $stmt->bindValue(':question_id', $question_id); // Mengikat nilai question_id
        $stmt->bindValue(':student_id', $student_id); // Mengikat nilai student_id
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk memperbarui total skor siswa
    public function updateStudentScore($student_id, $score) {
        $update_student_score = "UPDATE students SET score = score + :score, status = :status WHERE id = :student_id";
        $stmt = $this->db->prepare($update_student_score); // Menyiapkan pernyataan
        $stmt->bindValue(':score', $score); // Mengikat nilai skor
        $stmt->bindValue(':status', 1); // Mengatur status siswa
        $stmt->bindValue(':student_id', $student_id); // Mengikat nilai student_id
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk mendapatkan skor dari pertanyaan tertentu
    public function getQuestionScore($question_id) {
        $query = "SELECT score FROM questions WHERE id = :question_id";
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':question_id', $question_id); // Mengikat nilai question_id
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchColumn(); // Mengembalikan skor untuk pertanyaan
    }
}
?>
