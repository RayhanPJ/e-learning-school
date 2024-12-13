<?php
require_once __DIR__ . '/../config/database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        // Membuat koneksi database menggunakan kelas Database
        $this->db = (new Database())->connect();
    }

    /**
     * Mengambil semua data pengguna.
     *
     * @return array
     */
    public function getAllUsers()
    {
        $query = "SELECT * FROM teachers"; // Mengambil semua data dari tabel 'teachers'
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua pengguna sebagai array asosiatif
    }

    /**
     * Menyimpan data pengguna baru.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @return bool
     */
    public function createUser($username, $password, string $role = 'admin')
    {
        $query = "INSERT INTO teachers (username, password, role) VALUES (:username, :password, :role)"; // Kuery untuk menyimpan pengguna baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':username', $username); // Mengikat nilai username
        $stmt->bindValue(':password', $password); // Mengikat nilai password
        $stmt->bindValue(':role', $role); // Mengikat nilai role
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    /**
     * Mengambil data pengguna berdasarkan ID.
     *
     * @param int $id
     * @return array|null
     */
    public function getUserById($id)
    {
        $query = "SELECT * FROM teachers WHERE id = :id"; // Kuery untuk mengambil pengguna berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan pengguna sebagai array asosiatif
    }

    /**
     * Memperbarui data pengguna berdasarkan ID.
     *
     * @param int $id
     * @param string $username
     * @param string $email
     * @return bool
     */
    public function updateUser($id, $username, $password, string $role = 'admin')
    {
        $query = "UPDATE teachers SET username = :username, password = :password, role = :role WHERE id = :id"; // Kuery untuk memperbarui data pengguna
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':username', $username); // Mengikat nilai username
        $stmt->bindValue(':password', $password); // Mengikat nilai password
        $stmt->bindValue(':role', $role); // Mengikat nilai role
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    /**
     * Menghapus data pengguna berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser($id)
    {
        $query = "DELETE FROM teachers WHERE id = :id"; // Kuery untuk menghapus pengguna berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    /**
     * Mengambil semua pengguna dengan detail tambahan.
     *
     * @return array
     */
    public function getAllUsersWithDetails()
    {
        $query = "
            SELECT 
                u.id AS id_user,
                u.username,
                u.role,
                j.nama_jurusan,
                p.status AS status_pembayaran,
                p.tanggal_pembayaran,
                t.token
            FROM teachers u
            LEFT JOIN pembayaran p ON u.id = p.id_user
            LEFT JOIN jurusan j ON p.id_jurusan = j.id
            LEFT JOIN tokens t ON u.id = t.id_user
        "; // Kuery untuk mengambil semua pengguna dengan detail tambahan

        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua hasil sebagai array asosiatif
    }
}
?>
