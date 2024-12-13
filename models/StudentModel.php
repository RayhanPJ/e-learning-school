<?php
require_once __DIR__ . '/../config/database.php';

class StudentModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mengambil semua siswa
    public function getAllStudents() {
        $query = "SELECT * FROM students"; // Mengambil semua data dari tabel 'students'
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua siswa sebagai array asosiatif
    }

    // Method untuk membuat siswa baru
    public function createStudent($test_id, $rollno, $username, $password, int $score = 0, int $status = 0, string $role = 'student') {
        $query = "INSERT INTO students (test_id, rollno, username, password, score, status, role) 
                  VALUES (:test_id, :rollno, :username, :password, :score, :status, :role)"; // Kuery untuk menyimpan siswa baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':test_id', $test_id); // Mengikat nilai test_id
        $stmt->bindValue(':rollno', $rollno); // Mengikat nilai rollno
        $stmt->bindValue(':username', strtolower($username)); // Mengikat nilai username (dalam huruf kecil)
        $stmt->bindValue(':password', $password); // Mengikat nilai password
        $stmt->bindValue(':score', $score); // Mengikat nilai score
        $stmt->bindValue(':status', $status); // Mengikat nilai status
        $stmt->bindValue(':role', $role); // Mengikat nilai role
        $stmt->execute(); // Menjalankan kueri

        return $this->getStudentById($this->db->lastInsertId()); // Mengembalikan siswa yang baru dibuat
    }

    // Method untuk mendapatkan siswa berdasarkan ID
    public function getStudentById($id) {
        $query = "SELECT * FROM students WHERE id = :id"; // Kuery untuk mengambil siswa berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan siswa sebagai array asosiatif
    }

    // Method untuk memperbarui data siswa
    public function updateStudent($id, $score, $status) {
        $query = "UPDATE students SET score = :score, status = :status WHERE id = :id"; // Kuery untuk memperbarui data siswa
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':score', $score); // Mengikat nilai score
        $stmt->bindValue(':status', $status); // Mengikat nilai status
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
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

    // Method untuk menghapus siswa berdasarkan ID
    public function deleteStudent($id) {
        $query = "DELETE FROM students WHERE id = :id"; // Kuery untuk menghapus siswa berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
}
?>
