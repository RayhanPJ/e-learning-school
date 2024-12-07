<?php
require_once __DIR__ . '/../config/database.php';

class StatusModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mengambil semua status
    public function getAllStatus() {
        $query = "SELECT * FROM status"; // Mengambil semua data dari tabel 'status'
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua status sebagai array asosiatif
    }

    // Method untuk mendapatkan status berdasarkan ID
    public function getStatusById($id) {
        $query = "SELECT * FROM status WHERE id = :id"; // Kuery untuk mengambil status berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan status sebagai array asosiatif
    }

    // Method untuk membuat status baru
    public function createStatus($name, $price) {
        $query = "INSERT INTO status (name, price) VALUES (:name, :price)"; // Kuery untuk menyimpan status baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':name', $name); // Mengikat nilai nama
        $stmt->bindValue(':price', $price); // Mengikat nilai harga
        $stmt->execute(); // Menjalankan kueri

        // Mengembalikan status yang baru dibuat
        return $this->getStatusById($this->db->lastInsertId()); // Mengambil status berdasarkan ID terakhir yang dimasukkan
    }

    // Method untuk memperbarui status
    public function updateStatus($id, $name, $price) {
        $query = "UPDATE status SET name = :name, price = :price WHERE id = :id"; // Kuery untuk memperbarui status
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':name', $name); // Mengikat nilai nama
        $stmt->bindValue(':price', $price); // Mengikat nilai harga
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk menghapus status
    public function deleteStatus($id) {
        $query = "DELETE FROM status WHERE id = :id"; // Kuery untuk menghapus status berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
}
?>
