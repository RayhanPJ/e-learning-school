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
        $users = $this->userModel->getAllUsersWithDetails();
        var_dump($users);die;
        $this->authorize('admin'); // Hanya admin yang bisa mengakses

        return $users; // Data untuk view
    }

    /**
     * Halaman untuk membuat pengguna baru.
     */
    public function create()
    {
        session_start();
        $this->authorize('admin');
        // Tampilan form pembuatan pengguna.
    }

    /**
     * Menyimpan data pengguna baru.
     */
    public function store()
    {
        session_start();
        $this->authorize('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $role = trim($_POST['role']);
            $email = trim($_POST['email']);

            // Validasi data
            if (empty($username) || empty($password) || empty($role) || empty($email)) {
                die('Semua kolom wajib diisi.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die('Format email tidak valid.');
            }


            if ($this->userModel->createUser($username, $password, $email, $role)) {
                $_SESSION['flash'] = 'Pengguna berhasil ditambahkan.';
                header('Location: ' . $_ENV['BASE_URL'] . '/users');
                exit;
            } else {
                die('Gagal menyimpan data pengguna.');
            }
        }
    }

    /**
     * Halaman edit data pengguna.
     */
    public function edit($id)
    {
        session_start();
        $this->authorize('admin');
        return $this->userModel->getUserById($id);
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update($id)
    {
        session_start();
        $this->authorize('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $role = trim($_POST['role']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die('Format email tidak valid.');
            }

            if ($this->userModel->updateUser($id, $username, $email, $password, $role)) {
                $_SESSION['flash'] = 'Pengguna berhasil diperbarui.';
                header('Location: ' . $_ENV['BASE_URL'] . '/users');
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
        $this->authorize('admin');

        if ($this->userModel->deleteUser($id)) {
            $_SESSION['flash'] = 'Pengguna berhasil dihapus.';
            header('Location: ' . $_ENV['BASE_URL'] . '/users');
            exit;
        } else {
            die('Gagal menghapus data pengguna.');
        }
    }

    /**
     * Memeriksa hak akses pengguna berdasarkan peran.
     */
    private function authorize($requiredRole)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . $_ENV['BASE_URL'] . '/login');
            exit;
        }

        if ($_SESSION['role'] !== $requiredRole) {
            header('Location: ' . $_ENV['BASE_URL'] . '/dashboard');
            exit;
        }
    }
}
