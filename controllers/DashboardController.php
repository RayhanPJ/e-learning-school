<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TestModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';

class DashboardController extends BaseController
{
    private $db;
    private $testModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->db = (new Database())->connect();
        $this->testModel = new TestModel();
    }

    /**
     * Menampilkan halaman dashboard.
     */
    public function dashboard()
    {
        $this->checkUserLogin();
        $tests = $this->testModel->getAllTests();

        require_once __DIR__ . '/../views/dashboard.php';
        return $tests;
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
