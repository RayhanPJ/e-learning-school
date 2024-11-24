<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Menampilkan semua data pengguna.
     */
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
            header('Location:' . $_ENV['BASE_URL'] . '/login');
            exit;
        }

        $users = $this->userModel->getAllUsers();
        return $users; // Data untuk view
    }

    /**
     * Menyimpan data pengguna baru.
     */
    public function store()
    {
        session_start();
        if (!isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
            header('Location:' . $_ENV['BASE_URL'] . '/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $email = $_POST['email'];

            if ($this->userModel->createUser($username, $password, $email, $role)) {
                header('Location: ' . $_ENV['BASE_URL'] . '/users'); // Redirect ke daftar pengguna
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
        session_start();
        if (!isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
            header('Location:' . $_ENV['BASE_URL'] . '/login');
            exit;
        }
        return $this->userModel->getUserById($id);
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update($id)
    {
        session_start();
        if (!isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
            header('Location:' . $_ENV['BASE_URL'] . '/login');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
    
            $isCurrentUser = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id;
    
            if ($this->userModel->updateUser($id, $username, $email, $password, $role)) {
                if ($isCurrentUser) {
                    // Jika akun yang diupdate adalah akun aktif, hapus sesi
                    session_unset(); // Menghapus semua session
                    session_destroy(); // Menghancurkan sesi
                    header('Location: ' . $_ENV['BASE_URL'] . '/login'); // Redirect ke halaman login
                } else {
                    // Redirect ke daftar pengguna
                    header('Location: ' . $_ENV['BASE_URL'] . '/users');
                }
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
        session_start();
        if (!isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
            header('Location:' . $_ENV['BASE_URL'] . '/login');
            exit;
        }
        $isCurrentUser = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id;
    
        if ($this->userModel->deleteUser($id)) {
            if ($isCurrentUser) {
                // Jika akun yang dihapus adalah akun yang sedang aktif, lakukan logout
                session_unset(); // Menghapus semua session
                session_destroy(); // Menghancurkan sesi
                header('Location: ' . $_ENV['BASE_URL'] . '/login'); // Redirect ke halaman login
            } else {
                // Redirect ke daftar pengguna jika akun lain yang dihapus
                header('Location: ' . $_ENV['BASE_URL'] . '/users');
            }
            exit;
        } else {
            die('Gagal menghapus data pengguna.');
        }
    }
    
}
