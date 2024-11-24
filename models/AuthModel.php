<?php
require_once __DIR__ . '/../config/database.php';

class AuthModel
{
    private $db;

    public function __construct()
    {
        // Membuat koneksi database menggunakan Database class
        $this->db = (new Database())->connect();
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
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password); // Password disimpan dalam bentuk plaintext
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan array user atau null jika tidak ditemukan
    }
}
