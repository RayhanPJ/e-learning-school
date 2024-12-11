<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class TeachersController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->userModel = new UserModel();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Menampilkan semua data pengguna.
     */
    public function index()
    {
        $this->authorize('admin'); // Hanya admin yang bisa mengakses
        $users = $this->userModel->getAllUsers();

        require_once __DIR__ . '/../views/pages/management/users/list.php';
        return $users; // Data untuk view
    }

    /**
     * Halaman untuk membuat pengguna baru.
     */
    public function create()
    {
        $this->authorize('admin');
        require_once __DIR__ . '/../views/pages/management/users/add.php';
    }

    /**
     * Menyimpan data pengguna baru.
     */
    public function store()
    {
        $this->authorize('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStore();
        }
    }

    private function handleStore()
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $role = 'admin'; // Role default

        $errors = $this->validateUserInputs($username, $password);

        // Jika ada error, kembalikan ke view dengan error
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/users-create');
        }

        // Jika validasi berhasil, simpan data
        if ($this->userModel->createUser($username, $password, $role)) {
            $_SESSION['flash'] = 'User berhasil ditambahkan.';
            $_SESSION['class'] = 'alert-success';
            header('Location: ' . $_ENV['BASE_URL'] . '/class');
            exit;
        } else {
            $_SESSION['flash'] = 'User gagal ditambahkan.';
            $_SESSION['class'] = 'alert-warning';
            header('Location: ' . $_ENV['BASE_URL'] . '/class');
            exit;
        }
    }

    /**
     * Halaman edit data pengguna.
     */
    public function edit($id)
    {
        $this->authorize('admin');
        $user = $this->userModel->getUserById($id);

        require_once __DIR__ . '/../views/pages/management/users/edit.php';
        return $user;
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update($id)
    {
        $this->authorize('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($id);
        }
    }

    private function handleUpdate($id)
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $role = 'admin'; // Role default

        $errors = $this->validateUserInputs($username, $password);

        // Jika ada error, kembalikan ke view dengan error
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/users-edit/' . $id);
        }

        // Jika validasi berhasil, update data
        if ($this->userModel->updateUser($id, $username, $password, $role)) {
            $_SESSION['flash'] = 'User berhasil diperbarui.';
            $_SESSION['class'] = 'alert-success';
            header('Location: ' . $_ENV['BASE_URL'] . '/class');
            exit;
        } else {
            $_SESSION['flash'] = 'User gagal diperbarui.';
            $_SESSION['class'] = 'alert-warning';
            header('Location: ' . $_ENV['BASE_URL'] . '/class');
            exit;
        }
    }

    /**
     * Menghapus data pengguna.
     */
    public function delete($id)
    {
        $this->authorize('admin');

        if ($this->userModel->deleteUser($id)) {
            $_SESSION['flash'] = 'Pengguna berhasil dihapus.';
            $_SESSION['class'] = 'alert-danger';
            header('Location: ' . $_ENV['BASE_URL'] . '/users');
            exit;
        } else {
            die('Gagal menghapus data pengguna.');
        }
    }

    /**
     * Memvalidasi input pengguna.
     */
    private function validateUserInputs($username, $password)
    {
        $errors = [];
        if (empty($username)) {
            $errors['username'] = 'Please enter Username';
        }
        if (empty($password)) {
            $errors['password'] = 'Please enter Password';
        }
        return $errors;
    }

    /**
     * Menangani kesalahan validasi.
     */
    private function handleValidationErrors($errors, $oldData, $redirectPath)
    {
        $_SESSION['errors'] = $errors; // Simpan error dalam session
        $_SESSION['old'] = $oldData;    // Simpan data input sebelumnya
        header('Location: ' . $_ENV['BASE_URL'] . $redirectPath);
        exit;
    }
}
?>
