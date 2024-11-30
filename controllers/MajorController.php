<?php

require_once __DIR__ . '/../models/MajorModel.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class MajorController
{
    private $majorModel;


    public function __construct()
    {
        $this->majorModel = new MajorModel();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Menampilkan semua major.
     */
    public function index()
    {
        session_start();
        $this->authorize('admin');
        $major = $this->majorModel->getAllMajors();

        require_once __DIR__ . '/../views/pages/management/major/list.php'; 
        return $major;
    }

    /**
     * Menampilkan halaman form untuk membuat major baru.
     */
    public function create()
    {
        session_start();
        $this->authorize('admin');

        require_once __DIR__ . '/../views/pages/management/major/add.php';
    }

    /**
     * Menyimpan major baru ke database.
     */
    public function store()
    {
        session_start();
        $this->authorize('admin');

        $errors = []; // Array untuk menyimpan error

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);
            
            if (empty($price)) {
                $errors['price'] = 'Please enter Major Name';
            }

            // Validasi input
            if (empty($name)) {
                $errors['name'] = 'Please enter Major Name';
            }

            // Jika ada error, kembalikan ke view dengan error
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors; // Simpan error dalam session
                $_SESSION['old'] = $_POST;    // Simpan data input sebelumnya
                header('Location: ' . $_ENV['BASE_URL'] . '/major-create');
                exit;
            }

            // Jika validasi berhasil, update data
            if ($this->majorModel->createMajor($name, $price)) {
                $_SESSION['flash'] = 'Major berhasil ditambahkan.';
                header('Location: ' . $_ENV['BASE_URL'] . '/major');
                exit;
            } else {
                $_SESSION['flash'] = 'Major gagal ditambahkan.';
                header('Location: ' . $_ENV['BASE_URL'] . '/major');
                exit;
            }
        }
    }

    

    /**
     * Menampilkan halaman form untuk mengedit major.
     */
    public function edit($id)
    {
        session_start();
        $this->authorize('admin');
        $major = $this->majorModel->getMajorById($id);

        require_once __DIR__ . '/../views/pages/management/major/edit.php';
        return $major;
    }

    /**
     * Memperbarui data major di database.
     */
    public function update($id)
    {
        session_start();
        $this->authorize('admin');
    
        $errors = []; // Array untuk menyimpan error
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);

    
            // Validasi input
            if (empty($name)) {
                $errors['name'] = 'Please enter Major Name';
            }

            if (empty($price)) {
                $errors['price'] = 'Please enter Major Name';
            }
    
            // Jika ada error, kembalikan ke view dengan error
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors; // Simpan error dalam session
                $_SESSION['old'] = $_POST;    // Simpan data input sebelumnya
                header('Location: ' . $_ENV['BASE_URL'] . '/major-edit/' . $id);
                exit;
            }
    
            // Jika validasi berhasil, update data
            if ($this->majorModel->updateMajor($id, $name, $price)) {
                $_SESSION['flash'] = 'Major berhasil diperbarui.';
                header('Location: ' . $_ENV['BASE_URL'] . '/major');
                exit;
            } else {
                $_SESSION['flash'] = 'Major gagal diperbarui.';
                header('Location: ' . $_ENV['BASE_URL'] . '/major');
                exit;
            }
        }
    }
    

    /**
     * Menghapus major dari database.
     */
    public function delete($id)
    {
        session_start();
        $this->authorize('admin');

        if ($this->majorModel->deleteMajor($id)) {
            $_SESSION['flash'] = 'Major berhasil dihapus.';
            header('Location: ' . $_ENV['BASE_URL'] . '/major');
            exit;
        } else {
            die('Gagal menghapus major.');
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
