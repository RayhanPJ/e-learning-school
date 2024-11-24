<?php

require_once __DIR__ . '/../config/database.php';

class UserController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    /**
     * Menampilkan semua data pengguna.
     */
    public function index()
    {
        // $query = "SELECT * FROM tbl_users";
        // $stmt = $this->db->prepare($query);
        // $stmt->execute();
        // $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // return $users; // Data untuk view

        echo 'testt';
    }

    /**
     * Menyimpan data pengguna baru.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            $query = "INSERT INTO tbl_users (username, password, email) VALUES (:username, :password, :email)";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
            $stmt->bindValue(':email', $email);

            if ($stmt->execute()) {
                header('Location: /path/to/users-list.php'); // Redirect ke daftar pengguna
                exit;
            } else {
                die('Gagal menyimpan data pengguna.');
            }
        }
    }

    /**
     * Mengambil data pengguna untuk di-edit.
     */
    public function edit($id)
    {
        $query = "SELECT * FROM tbl_users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user; // Data untuk view
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];

            $query = "UPDATE tbl_users SET username = :username, email = :email WHERE id = :id";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':id', $id);

            if ($stmt->execute()) {
                header('Location: /path/to/users-list.php'); // Redirect ke daftar pengguna
                exit;
            } else {
                die('Gagal memperbarui data pengguna.');
            }
        }
    }

    /**
     * Menghapus data pengguna.
     */
    public function delete($id)
    {
        $query = "DELETE FROM tbl_users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            header('Location: /path/to/users-list.php'); // Redirect ke daftar pengguna
            exit;
        } else {
            die('Gagal menghapus data pengguna.');
        }
    }
}
