<?php
require_once __DIR__ . '/../config/database.php';

class AuthModel
{
    private $db;

    public function __construct()
    {
        // Membuat koneksi database menggunakan kelas Database
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    /**
     * Mencari pengguna berdasarkan username dan password.
     *
     * @param string $username
     * @param string $password
     * @return array|null
     */
    public function login($username, $password)
    {
        // Memeriksa di tabel teachers
        $query = "SELECT * FROM teachers WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':username', $username); // Mengikat nilai username
        $stmt->bindValue(':password', $password); // Mengikat nilai password (disimpan dalam plaintext)
        $stmt->execute(); // Menjalankan kueri
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil pengguna dari tabel teachers

        // Jika tidak ditemukan di tabel teachers, periksa di tabel students
        if (!$user) {
            $query = "SELECT * FROM students WHERE username = :username AND password = :password";
            $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
            $stmt->bindValue(':username', $username); // Mengikat nilai username
            $stmt->bindValue(':password', $password); // Mengikat nilai password (disimpan dalam plaintext)
            $stmt->execute(); // Menjalankan kueri
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil pengguna dari tabel students
        }

        return $user; // Mengembalikan pengguna atau null jika tidak ditemukan di kedua tabel
    }
}
?>
