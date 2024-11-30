<?php
require_once __DIR__ . '/../config/database.php';

class DashboardController
{
    private $db;

    public function __construct()
    {
        // Membuat koneksi database menggunakan Database class
        $this->db = (new Database())->connect();
    }

    /**
     * Menangani proses login.
     */
    public function dashboard()
    {
        session_start();
        // Periksa apakah pengguna sudah login
        if (!isset($_SESSION['user_id'])) {
            // Jika belum login, redirect ke halaman login
            header('Location: '. $_ENV['BASE_URL']. '/login');
            exit;
        }
        
        require_once __DIR__ . '/../views/dashboard.php';
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
        header('Location: '. $_ENV['BASE_URL']. '/login');
        exit;
    }
}
