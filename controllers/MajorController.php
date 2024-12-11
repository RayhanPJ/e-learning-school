<?php
require_once __DIR__ . '/../models/MajorModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class MajorController extends BaseController
{
    private $majorModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->majorModel = new MajorModel();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Menampilkan semua major.
     */
    public function index()
    {
        $this->authorize('admin');
        $majors = $this->majorModel->getAllMajors();
        require_once __DIR__ . '/../views/pages/management/major/list.php'; 
        return $majors;
    }

    /**
     * Menampilkan halaman form untuk membuat major baru.
     */
    public function create()
    {
        $this->authorize('admin');
        require_once __DIR__ . '/../views/pages/management/major/add.php';
    }

    /**
     * Menyimpan major baru ke database.
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
        $errors = $this->validateMajorInputs($_POST);

        // Jika ada error, kembalikan ke view dengan error
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/major-create');
        }

        // Jika validasi berhasil, simpan data
        if ($this->majorModel->createMajor(trim($_POST['name']), trim($_POST['price']))) {
            $_SESSION['flash'] = 'Major berhasil ditambahkan.';
            header('Location: ' . $_ENV['BASE_URL'] . '/major');
            exit;
        } else {
            $_SESSION['flash'] = 'Major gagal ditambahkan.';
            header('Location: ' . $_ENV['BASE_URL'] . '/major');
            exit;
        }
    }

    /**
     * Menampilkan halaman form untuk mengedit major.
     */
    public function edit($id)
    {
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
        $this->authorize('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($id);
        }
    }

    private function handleUpdate($id)
    {
        $errors = $this->validateMajorInputs($_POST);

        // Jika ada error, kembalikan ke view dengan error
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/major-edit/' . $id);
        }

        // Jika validasi berhasil, update data
        if ($this->majorModel->updateMajor($id, trim($_POST['name']), trim($_POST['price']))) {
            $_SESSION['flash'] = 'Major berhasil diperbarui.';
            $_SESSION['class'] = 'alert-success';
            header('Location: ' . $_ENV['BASE_URL'] . '/major');
            exit;
        } else {
            $_SESSION['flash'] = 'Major gagal diperbarui.';
            $_SESSION['class'] = 'alert-warning';
            header('Location: ' . $_ENV['BASE_URL'] . '/major');
            exit;
        }
    }

    /**
     * Menghapus major dari database.
     */
    public function delete($id)
    {
        $this->authorize('admin');

        if ($this->majorModel->deleteMajor($id)) {
            $_SESSION['flash'] = 'Major berhasil dihapus.';
            $_SESSION['class'] = 'alert-danger';
            header('Location: ' . $_ENV['BASE_URL'] . '/major');
            exit;
        } else {
            die('Gagal menghapus major.');
        }
    }

    /**
     * Memvalidasi input major.
     */
    private function validateMajorInputs($data)
    {
        $errors = [];
        if (empty(trim($data['name']))) {
            $errors['name'] = 'Please enter Major Name';
        }
        if (empty(trim($data['price']))) {
            $errors['price'] = 'Please enter Major Price';
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
