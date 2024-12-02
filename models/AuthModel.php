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
    // Check in the teachers table
    $query = "SELECT * FROM teachers WHERE username = :username AND password = :password";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password); // Password stored in plaintext
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user from teachers

    // If not found in teachers, check in the students table
    if (!$user) {
        $query = "SELECT * FROM students WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password); // Password stored in plaintext
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user from students
    }

    return $user; // Return user or null if not found in both tables
}

}
