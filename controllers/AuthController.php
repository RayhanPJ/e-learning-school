<?php
require_once __DIR__ . '/../models/AuthModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';

class AuthController extends BaseController
{
    private $authModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        // Menampilkan halaman login
        require_once __DIR__ . '/../views/pages/auth/login.php';
    }

    /**
     * Menangani proses login.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
        }
    }

    private function handleLogin()
    {
        // Ambil data input dari form
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Validasi input
        if ($this->validateLoginInputs($username, $password)) {
            // Gunakan model untuk mencari pengguna
            $user = $this->authModel->login($username, $password);

            if ($user) {
                $this->initializeUserSession($user);
                // Redirect ke halaman dashboard
                header('Location: ' . $_ENV['BASE_URL'] . '/dashboard');
                exit;
            } else {
                die('Username atau password salah.');
            }
        }
    }

    private function validateLoginInputs($username, $password)
    {
        if (empty($username) || empty($password)) {
            die('Username dan password harus diisi.');
        }
        return true; // Jika validasi berhasil
    }

    private function initializeUserSession($user)
    {
        // Simpan data pengguna di session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }

    /**
     * Menangani proses logout.
     */
    public function logout()
    {
        $this->handleLogout();
    }

    private function handleLogout()
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
?>
