<?php

require_once __DIR__ . '/../models/TestModel.php';
require_once __DIR__ . '/../models/StudentDataModel.php';
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class TestController
{
    private $testModel;
    private $studentDataModel;
    private $studentModel;

    public function __construct()
    {
        $this->testModel = new TestModel();
        $this->studentDataModel = new StudentDataModel();
        $this->studentModel = new StudentModel();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Menampilkan semua test.
     */
    public function index()
    {
        session_start();
        $this->authorize('admin');
        $tests = $this->testModel->getAllTests();
        return $tests;
    }

    public function create()
    {
        session_start();
        $this->authorize('admin');
        // Tampilan form pembuatan pengguna.
    }

    /**
     * Menyimpan test baru ke database.
     */
    public function store()
    {
        session_start();
        $this->authorize('admin');

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $test_name = trim($_POST['test_name']);
            $test_subject = trim($_POST['subject_name']);
            $test_date = trim($_POST['test_date']);
            $total_questions = trim($_POST['total_questions']);
            $status_id = trim($_POST['test_status']);
            $class_id = trim($_POST['test_class']);
            $teacher_id = trim($_POST['teacher_id']);
            // $teacher_id = $_SESSION['user_id'];

            // Validasi input
            if (empty($test_name)) {
                $errors['test_name'] = 'Test Name is required.';
            }
            if (empty($test_subject)) {
                $errors['subject_name'] = 'Subject Name is required.';
            }
            if (empty($test_date)) {
                $errors['test_date'] = 'Test Date is required.';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: ' . $_ENV['BASE_URL'] . '/test-create');
                exit;
            }

            // Simpan test ke database
            $test = $this->testModel->createTest(
                $teacher_id,
                $test_name,
                $test_date,
                $status_id,
                $test_subject,
                $total_questions,
                $class_id
            );

            if ($test) {
                $test_id = $test['id'];

                // Ambil semua siswa dalam kelas dan tambahkan ke tabel students
                $students = $this->studentDataModel->getStudentsByClassId($class_id);
                foreach ($students as $student) {
                    $rollno = $student['id'];
                    $password = $this->generateRandomString(8 - strlen($test_id)) . $test_id;
                    $this->studentModel->createStudent($test_id, $rollno, $password);
                }

                $_SESSION['flash'] = 'Test berhasil dibuat.';
                header('Location: ' . $_ENV['BASE_URL'] . '/tests');
                exit;
            } else {
                $_SESSION['flash'] = 'Gagal membuat test.';
                header('Location: ' . $_ENV['BASE_URL'] . '/test-create');
                exit;
            }
        }
    }

//     public function storeAPI()
// {
//     header('Content-Type: application/json');

//     try {
//         // Mulai sesi
//         session_start();

//         // Periksa apakah pengguna memiliki izin
//         // $this->authorize('admin');

//         // Validasi hanya menerima metode POST
//         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//             http_response_code(405);
//             echo json_encode(['error' => 'Method not allowed']);
//             return;
//         }

//         $errors = [];

//         // Ambil data dari body
//         $test_name = trim($_POST['test_name'] ?? '');
//         $test_subject = trim($_POST['subject_name'] ?? '');
//         $test_date = trim($_POST['test_date'] ?? '');
//         $total_questions = trim($_POST['total_questions'] ?? '');
//         $status_id = trim($_POST['test_status'] ?? '');
//         $class_id = trim($_POST['test_class'] ?? '');
//         $teacher_id = trim($_POST['teacher_id'] ?? '');

//         // Validasi input
//         if (empty($test_name)) {
//             $errors['test_name'] = 'Test Name is required.';
//         }
//         if (empty($test_subject)) {
//             $errors['subject_name'] = 'Subject Name is required.';
//         }
//         if (empty($test_date)) {
//             $errors['test_date'] = 'Test Date is required.';
//         }

//         // Jika ada error, kembalikan respons JSON
//         if (!empty($errors)) {
//             http_response_code(400);
//             echo json_encode([
//                 'status' => 'error',
//                 'errors' => $errors,
//             ]);
//             return;
//         }

//         // Simpan test ke database
//         $test = $this->testModel->createTest(
//             $teacher_id,
//             $test_name,
//             $test_date,
//             $status_id,
//             $test_subject,
//             $total_questions,
//             $class_id
//         );

//         if (!$test) {
//             http_response_code(500);
//             echo json_encode([
//                 'status' => 'error',
//                 'message' => 'Failed to create test.',
//             ]);
//             return;
//         }

//         $test_id = $test['id'];

//         // Ambil semua siswa dalam kelas dan tambahkan ke tabel students
//         $students = $this->studentDataModel->getStudentsByClassId($class_id);
//         foreach ($students as $student) {
//             $rollno = $student['id'];
//             $password = $this->generateRandomString(8 - strlen($test_id)) . $test_id;
//             $this->studentModel->createStudent($test_id, $rollno, $password);
//         }

//         // Kembalikan respons sukses
//         http_response_code(201);
//         echo json_encode([
//             'status' => 'success',
//             'message' => 'Test created successfully.',
//             'data' => [
//                 'test_id' => $test_id,
//             ],
//         ]);
//     } catch (Exception $e) {
//         // Tangkap error dan kembalikan log
//         http_response_code(500);
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'An error occurred.',
//             'error' => $e->getMessage(),
//         ]);
//     }
// }


    /**
     * Menghapus test dari database.
     */
    public function delete($id)
    {
        session_start();
        $this->authorize('admin');

        if ($this->testModel->deleteTest($id)) {
            $_SESSION['flash'] = 'Test berhasil dihapus.';
            header('Location: ' . $_ENV['BASE_URL'] . '/tests');
            exit;
        } else {
            die('Gagal menghapus test.');
        }
    }

    /**
     * Fungsi untuk menghasilkan string acak.
     */
    private function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
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
