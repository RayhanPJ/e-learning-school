<?php
require_once __DIR__ . '/../config/database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        // Membuat koneksi database menggunakan Database class
        $this->db = (new Database())->connect();
    }

    /**
     * Mengambil semua data pengguna.
     *
     * @return array
     */
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Menyimpan data pengguna baru.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @return bool
     */
    public function createUser($username, $password, $email, $role)
    {
        $query = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':role', $role);
        return $stmt->execute();
    }

    /**
     * Mengambil data pengguna berdasarkan ID.
     *
     * @param int $id
     * @return array|null
     */
    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Memperbarui data pengguna berdasarkan ID.
     *
     * @param int $id
     * @param string $username
     * @param string $email
     * @return bool
     */
    public function updateUser($id, $username, $email, $password, $role)
    {
        $query = "UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':role', $role);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    /**
     * Menghapus data pengguna berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
