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
        $users = $this->userModel->getAllUsers();
        // var_dump($users);die;
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
            $role = trim('admin');
    
            // Validasi input
            if (empty($username)) {
                $errors['username'] = 'Please enter Username';
            }
    
            if (empty($password)) {
                $errors['password'] = 'Please enter Password';
            }
    
            // Jika ada error, kembalikan ke view dengan error
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors; // Simpan error dalam session
                $_SESSION['old'] = $_POST;    // Simpan data input sebelumnya
                header('Location: ' . $_ENV['BASE_URL'] . '/users-create');
                exit;
            }
    
            // Jika validasi berhasil, update data
            if ($this->userModel->createUser($username, $password, $role)) {
                $_SESSION['flash'] = 'User berhasil ditambahkan.';
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
            } else {
                $_SESSION['flash'] = 'User gagal ditambahkan.';
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
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
            $password = trim($_POST['password']);
            $role = trim('admin');
    
            // Validasi input
            if (empty($username)) {
                $errors['username'] = 'Please enter Username';
            }
    
            if (empty($password)) {
                $errors['password'] = 'Please enter Password';
            }
    
            // Jika ada error, kembalikan ke view dengan error
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors; // Simpan error dalam session
                $_SESSION['old'] = $_POST;    // Simpan data input sebelumnya
                header('Location: ' . $_ENV['BASE_URL'] . '/users-create');
                exit;
            }
    
            // Jika validasi berhasil, update data
            if ($this->userModel->updateUser($id, $username, $password, $role)) {
                $_SESSION['flash'] = 'User berhasil diperbarui.';
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
            } else {
                $_SESSION['flash'] = 'User gagal diperbarui.';
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
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
