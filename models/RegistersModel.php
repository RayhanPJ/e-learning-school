<?php
require_once __DIR__ . '/../config/database.php';

class RegistersModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mengambil semua pendaftaran
    public function getAllRegisters() {
        $query = "SELECT * FROM registers"; // Mengambil semua data dari tabel 'registers'
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua pendaftaran sebagai array asosiatif
    }

    // Method untuk mengambil semua pendaftaran dengan jurusan
    public function getAllRegistersWithMajor() {
        $query = "
            SELECT r.*, m.name AS major_name, m.price AS major_price
            FROM registers r
            JOIN major m ON r.major_id = m.id
        "; // Mengambil pendaftaran dan informasi jurusan terkait
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua pendaftaran dengan jurusan
    }

    // Method untuk menghitung jumlah pendaftaran berdasarkan ID jurusan
    public function countRegisterByMajorId($major_id) {
        $query = "SELECT COUNT(*) as count FROM registers WHERE major_id = :major_id"; // Menghitung jumlah pendaftaran untuk jurusan tertentu
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':major_id', $major_id, PDO::PARAM_INT); // Mengikat nilai major_id
        $stmt->execute(); // Menjalankan kueri
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil hasil
        return $result['count']; // Mengembalikan jumlah pendaftaran
    }

    // Method untuk mendapatkan ID pendaftaran berdasarkan nomor urut dan ID kelas
    public function getRegisterIdByRollNumberAndClassId($class_id) {
        $query = "SELECT id FROM registers WHERE class_id = :class_id"; // Mengambil ID pendaftaran berdasarkan ID kelas
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT); // Mengikat nilai class_id
        $stmt->execute(); // Menjalankan kueri
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil hasil
        return $result; // Mengembalikan ID pendaftaran
    }

    // Method untuk membuat pendaftaran baru
    public function createRegister($name, $date_of_birth, $phone, $major_id) {
        $query = "INSERT INTO registers (name, date_of_birth, phone, major_id, status_payment) 
                  VALUES (:name, :date_of_birth, :phone, :major_id, :status_payment)"; // Kuery untuk menyimpan pendaftaran baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':name', $name); // Mengikat nilai nama
        $stmt->bindValue(':date_of_birth', $date_of_birth); // Mengikat nilai tanggal lahir
        $stmt->bindValue(':phone', $phone); // Mengikat nilai telepon
        $stmt->bindValue(':major_id', $major_id); // Mengikat nilai major_id
        $stmt->bindValue(':status_payment', false); // Mengatur status pembayaran ke false
        $stmt->execute(); // Menjalankan kueri

        // Mengembalikan pendaftaran yang baru dibuat
        return $this->getRegisterById($this->db->lastInsertId()); // Mengambil pendaftaran berdasarkan ID terakhir yang dimasukkan
    }

    // Method untuk mendapatkan pendaftaran berdasarkan ID
    public function getRegisterById($id) {
        $query = "SELECT * FROM registers WHERE id = :id"; // Kuery untuk mengambil pendaftaran berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan pendaftaran sebagai array asosiatif
    }

    // Method untuk mendapatkan pendaftaran dengan jurusan berdasarkan ID
    public function getRegisterWithMajorById($id) {
        $query = "
            SELECT r.*, m.name AS major_name, m.price AS major_price
            FROM registers r
            JOIN major m ON r.major_id = m.id
            WHERE r.id = :id
        "; // Mengambil pendaftaran dan informasi jurusan terkait berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan pendaftaran dengan jurusan
    }

    // Method untuk memperbarui pendaftaran
    public function updateRegister($id, $name, $date_of_birth, $phone, $major_id) {
        $query = "UPDATE registers SET name = :name, date_of_birth = :date_of_birth, phone = :phone, major_id = :major_id WHERE id = :id"; // Kuery untuk memperbarui pendaftaran
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':name', $name); // Mengikat nilai nama
        $stmt->bindValue(':date_of_birth', $date_of_birth); // Mengikat nilai tanggal lahir
        $stmt->bindValue(':phone', $phone); // Mengikat nilai telepon
        $stmt->bindValue(':major_id', $major_id); // Mengikat nilai major_id
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk menghapus pendaftaran
    public function deleteRegister($id) {
        // Hapus data dari tabel student_data yang memiliki registers_id yang sama
        $deleteStudentDataQuery = "DELETE FROM student_data WHERE registers_id = :registers_id"; // Kuery untuk menghapus data siswa terkait
        $stmt = $this->db->prepare($deleteStudentDataQuery); // Menyiapkan pernyataan
        $stmt->bindValue(':registers_id', $id); // Mengikat nilai registers_id
        $stmt->execute(); // Eksekusi penghapusan dari student_data
    
        // Hapus data dari tabel registers
        $deleteRegisterQuery = "DELETE FROM registers WHERE id = :id"; // Kuery untuk menghapus pendaftaran berdasarkan ID
        $stmt = $this->db->prepare($deleteRegisterQuery); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        
        return $stmt->execute(); // Mengembalikan hasil eksekusi penghapusan dari registers
    }
}
?>
