<?php
require_once __DIR__ . '/../config/database.php';

class ScoreCalculationModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mendapatkan total skor untuk ujian tertentu
    public function getTotalScoreForTest($test_id) {
        $query = "
            SELECT SUM(q.score) AS total_score
            FROM questions q
            JOIN question_test_mapping qtm ON q.id = qtm.question_id
            WHERE qtm.test_id = :test_id
        ";

        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        $stmt->execute(); // Menjalankan kueri

        return $stmt->fetchColumn(); // Mengembalikan total skor
    }

    // Method untuk menghitung rata-rata skor untuk siswa berdasarkan ujian
    public function calculateAverageScore($student_id, $test_id) {
        // Mendapatkan total skor untuk ujian
        $totalScore = $this->getTotalScoreForTest($test_id);

        // Mendapatkan jumlah pertanyaan untuk ujian
        $query = "
            SELECT COUNT(q.id) AS total_questions
            FROM questions q
            JOIN question_test_mapping qtm ON q.id = qtm.question_id
            WHERE qtm.test_id = :test_id
        ";

        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        $stmt->execute(); // Menjalankan kueri
        $totalQuestions = $stmt->fetchColumn(); // Mendapatkan total jumlah pertanyaan

        // Mendapatkan skor siswa untuk ujian
        $query = "
            SELECT score
            FROM students
            WHERE id = :student_id
        ";

        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':student_id', $student_id); // Mengikat nilai student_id
        $stmt->execute(); // Menjalankan kueri
        $studentScore = $stmt->fetchColumn(); // Mendapatkan skor siswa

        // Menghitung rata-rata skor
        if ($totalQuestions > 0) {
            $averageScore = ($studentScore) / ($totalScore) * 100; // Menghitung rata-rata skor
        } else {
            $averageScore = 0; // Menghindari pembagian dengan nol
        }

        return $averageScore; // Mengembalikan rata-rata skor
    }

    // Method untuk menentukan grade berdasarkan rata-rata skor
    public function getGrade($averageScore) {
        if ($averageScore < 50) {
            return 'C'; // Grade C untuk rata-rata skor di bawah 50
        } elseif ($averageScore >= 51 && $averageScore <= 80) {
            return 'B'; // Grade B untuk rata-rata skor antara 51 dan 80
        } elseif ($averageScore >= 81 && $averageScore <= 100) {
            return 'A'; // Grade A untuk rata-rata skor antara 81 dan 100
        } else {
            return 'Invalid Score'; // Menangani skor yang tidak terduga
        }
    }
}
?>
