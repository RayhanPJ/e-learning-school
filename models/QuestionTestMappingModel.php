<?php
require_once __DIR__ . '/../config/database.php';

class QuestionTestMappingModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mengambil semua pemetaan
    public function getAllMappings() {
        $query = "SELECT * FROM question_test_mapping"; // Mengambil semua data dari tabel 'question_test_mapping'
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua pemetaan sebagai array asosiatif
    }

    // Method untuk membuat pemetaan baru
    public function createMapping($question_id, $test_id) {
        $query = "INSERT INTO question_test_mapping (question_id, test_id) VALUES (:question_id, :test_id)"; // Kuery untuk menyimpan pemetaan baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':question_id', $question_id); // Mengikat nilai question_id
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk mengambil pemetaan berdasarkan ID pertanyaan dan ID ujian
    public function getMapping($question_id, $test_id) {
        $query = "SELECT * FROM question_test_mapping WHERE question_id = :question_id AND test_id = :test_id"; // Kuery untuk mengambil pemetaan berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':question_id', $question_id); // Mengikat nilai question_id
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan pemetaan atau null jika tidak ditemukan
    }

    // Method untuk mengambil semua pertanyaan berdasarkan ID ujian
    public function getQuestionsByTestId($test_id) {
        $query = "
            SELECT q.id, q.title, q.optionA, q.optionB, q.optionC, q.optionD, q.correctAns, q.score
            FROM questions q
            JOIN question_test_mapping qtm ON q.id = qtm.question_id
            WHERE qtm.test_id = :test_id
        "; // Kuery untuk mengambil semua pertanyaan yang terkait dengan ujian tertentu
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua pertanyaan untuk ujian
    }

    // Method untuk menghapus pemetaan
    public function deleteMapping($question_id, $test_id) {
        $query = "DELETE FROM question_test_mapping WHERE question_id = :question_id AND test_id = :test_id"; // Kuery untuk menghapus pemetaan berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':question_id', $question_id); // Mengikat nilai question_id
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
}
?>
