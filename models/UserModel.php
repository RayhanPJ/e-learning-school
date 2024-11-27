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
        $query = "SELECT * FROM teachers";
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
    public function createUser($username, $password, $email, string $role = 'admin')
    {
        $query = "INSERT INTO teachers (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
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
        $query = "SELECT * FROM teachers WHERE id = :id";
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
    public function updateUser($id, $username, $email, $password, string $role = 'admin')
    {
        $query = "UPDATE teachers SET username = :username, email = :email, password = :password, role = :role WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
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
        $query = "DELETE FROM teachers WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function getAllUsersWithDetails()
    {
        $query = "
            SELECT 
                u.id AS id_user,
                u.username,
                u.role,
                u.email,
                j.nama_jurusan,
                p.status AS status_pembayaran,
                p.tanggal_pembayaran,
                t.token
            FROM teachers u
            LEFT JOIN pembayaran p ON u.id = p.id_user
            LEFT JOIN jurusan j ON p.id_jurusan = j.id
            LEFT JOIN tokens t ON u.id = t.id_user
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
