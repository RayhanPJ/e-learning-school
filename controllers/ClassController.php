<?php

require_once __DIR__ . '/../models/ClassModel.php';
require_once __DIR__ . '/../models/StudentDataModel.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class ClassController
{
    private $classModel;
    private $studentDataModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->studentDataModel = new StudentDataModel();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Menampilkan semua class.
     */
    public function index()
    {
        session_start();
        $this->authorize('admin');
        $class = $this->classModel->getAllClass();
        return $class;
    }

    /**
     * Menampilkan halaman form untuk membuat class baru.
     */
    public function create()
    {
        session_start();
        $this->authorize('admin');
    }

    /**
     * Menyimpan class baru ke database.
     */
    public function store()
    {
        session_start();
        $this->authorize('admin');
    
        $errors = []; // Array untuk menyimpan error
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $starting_roll_number = trim($_POST['starting_roll_number']);
            $ending_roll_number = trim($_POST['ending_roll_number']);
    
            // Validasi input
            if (empty($name)) {
                $errors['name'] = 'Please enter Class Name';
            }
    
            if (empty($starting_roll_number)) {
                $errors['starting_roll_number'] = 'Please enter Starting Roll Number';
            }
    
            if (empty($ending_roll_number)) {
                $errors['ending_roll_number'] = 'Please enter Ending Roll Number';
            }
    
            // Jika ada error, kembalikan ke view dengan error
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors; // Simpan error dalam session
                $_SESSION['old'] = $_POST;    // Simpan data input sebelumnya
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
            }
    
            // Jika validasi berhasil, tambahkan data ke classes
            $class = $this->classModel->createClass($name, $starting_roll_number, $ending_roll_number);

            if ($class) {
                $classId = $class['id'];
                // Tambahkan roll numbers ke student_data
                if ($this->studentDataModel->createStudentData($starting_roll_number, $ending_roll_number, $classId)) {
                    $_SESSION['flash'] = 'Class berhasil ditambahkan beserta student data.';
                } else {
                    $_SESSION['flash'] = 'Class berhasil, namun gagal menambahkan student data.';
                }
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
            } else {
                $_SESSION['flash'] = 'Class gagal ditambahkan.';
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
            }
        }
    }
    

    /**
     * Menampilkan halaman form untuk mengedit class.
     */
    public function edit($id)
    {
        session_start();
        $this->authorize('admin');
        $class = $this->classModel->getClassById($id);

        return $class;
    }

    /**
     * Memperbarui data class di database.
     */
    public function update($id)
    {
        session_start();
        $this->authorize('admin');
    
        $errors = []; // Array untuk menyimpan error
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            // $starting_roll_number = trim($_POST['starting_roll_number']);
            // $ending_roll_number = trim($_POST['ending_roll_number']);
    
            // Validasi input
            if (empty($name)) {
                $errors['name'] = 'Please enter Class Name';
            }
    
            // if (empty($starting_roll_number)) {
            //     $errors['starting_roll_number'] = 'Please enter Starting Roll Number';
            // }
    
            // if (empty($ending_roll_number)) {
            //     $errors['ending_roll_number'] = 'Please enter Ending Roll Number';
            // }
    
            // Jika ada error, kembalikan ke view dengan error
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors; // Simpan error dalam session
                $_SESSION['old'] = $_POST;    // Simpan data input sebelumnya
                header('Location: ' . $_ENV['BASE_URL'] . '/class-edit/' . $id);
                exit;
            }
    
            // Jika validasi berhasil, update data
            if ($this->classModel->updateClass($id, $name)) {
                $_SESSION['flash'] = 'Class berhasil diperbarui.';
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
            } else {
                $_SESSION['flash'] = 'Class gagal diperbarui.';
                header('Location: ' . $_ENV['BASE_URL'] . '/class');
                exit;
            }
        }
    }
    

    /**
     * Menghapus class dari database.
     */
    public function delete($id)
    {
        session_start();
        $this->authorize('admin');

        if ($this->classModel->deleteClass($id)) {
            $_SESSION['flash'] = 'Class berhasil dihapus.';
            header('Location: ' . $_ENV['BASE_URL'] . '/class');
            exit;
        } else {
            die('Gagal menghapus class.');
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
