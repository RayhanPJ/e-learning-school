<?php

class BaseController
{
    public function __construct()
    {
        // Memulai session jika belum dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Memeriksa hak akses pengguna berdasarkan peran.
     */
    protected function authorize($requiredRole)
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = 'Anda belum login!';
            $_SESSION['class'] = 'alert-danger';
            header('Location: ' . $_ENV['BASE_URL'] . '/login');
            exit;
        }

        if ($_SESSION['role'] !== $requiredRole) {
            $_SESSION['flash'] = 'Anda bukan Admin!';
            $_SESSION['class'] = 'alert-warning';
            header('Location: ' . $_ENV['BASE_URL'] . '/dashboard');
            exit;
        }
    }

    /**
     * Mengatur role pengguna sebagai 'guest' jika belum login.
     */
    protected function setGuestRole()
    {
        if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = 'guest';
        }
    }
}
