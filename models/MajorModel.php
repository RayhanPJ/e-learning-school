<?php
require_once __DIR__ . '/../config/database.php';

class MajorModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mendapatkan semua jurusan
    public function getAllMajors() {
        $query = "SELECT * FROM major"; // Kuery untuk mengambil semua jurusan
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua jurusan sebagai array asosiatif
    }

    // Method untuk mendapatkan jurusan berdasarkan ID
    public function getMajorById($id) {
        $query = "SELECT * FROM major WHERE id = :id"; // Kuery untuk mengambil jurusan berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan jurusan sebagai array asosiatif
    }

    // Method untuk membuat jurusan baru
    public function createMajor($name, $price) {
        $query = "INSERT INTO major (name, price) VALUES (:name, :price)"; // Kuery untuk menyimpan jurusan baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':name', $name); // Mengikat nilai nama
        $stmt->bindValue(':price', $price); // Mengikat nilai harga
        $stmt->execute(); // Menjalankan kueri

        // Mengembalikan jurusan yang baru dibuat
        return $this->getMajorById($this->db->lastInsertId()); // Mengambil jurusan berdasarkan ID terakhir yang dimasukkan
    }

    // Method untuk memperbarui jurusan
    public function updateMajor($id, $name, $price) {
        $query = "UPDATE major SET name = :name, price = :price WHERE id = :id"; // Kuery untuk memperbarui jurusan
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':name', $name); // Mengikat nilai nama
        $stmt->bindValue(':price', $price); // Mengikat nilai harga
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk menghapus jurusan
    public function deleteMajor($id) {
        $query = "DELETE FROM major WHERE id = :id"; // Kuery untuk menghapus jurusan berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
}
?>
