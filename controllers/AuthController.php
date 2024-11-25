<?php
require_once __DIR__ . '/../models/AuthModel.php';

class AuthController
{
    private $authModel;

    public function __construct()
    {
        // Inisialisasi model AuthModel
        $this->authModel = new AuthModel();
    }

    /**
     * Menangani proses login.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data input dari form
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                die('Username dan password harus diisi.');
            }

            // Gunakan model untuk mencari pengguna
            $user = $this->authModel->login($username, $password);

            if ($user) {
                // Simpan data pengguna di session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect ke halaman dashboard
                header('Location: ' . $_ENV['BASE_URL'] . '/dashboard');
                exit;
            } else {
                die('Username atau password salah.');
            }
        }
    }

    /**
     * Menangani proses logout.
     */
    public function logout()
    {
        // Hapus sesi pengguna
        session_start();
        session_unset(); // Menghapus semua session
        session_destroy(); // Menghancurkan sesi

        // Redirect ke halaman login
        header('Location: ' . $_ENV['BASE_URL'] . '/login');
        exit;
    }
}
