<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/BaseController.php';

class DashboardController extends BaseController
{
    private $db;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->db = (new Database())->connect();
    }

    /**
     * Menampilkan halaman dashboard.
     */
    public function dashboard()
    {
        $this->checkUserLogin();
        require_once __DIR__ . '/../views/dashboard.php';
    }

    /**
     * Memeriksa apakah pengguna sudah login.
     */
    private function checkUserLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirectToLogin();
        }
    }

    /**
     * Mengarahkan pengguna ke halaman login.
     */
    private function redirectToLogin()
    {
        header('Location: ' . $_ENV['BASE_URL'] . '/login');
        exit;
    }
}
?>
