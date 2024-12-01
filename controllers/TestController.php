<?php
require_once __DIR__ . '/../models/TestModel.php';
require_once __DIR__ . '/../models/StudentDataModel.php';
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/MajorModel.php';
require_once __DIR__ . '/../models/StatusModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class TestController extends BaseController
{
    private $testModel;
    private $studentDataModel;
    private $studentModel;
    private $majorModel;
    private $statusModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->testModel = new TestModel();
        $this->studentDataModel = new StudentDataModel();
        $this->studentModel = new StudentModel();
        $this->majorModel = new MajorModel();
        $this->statusModel = new StatusModel();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    /**
     * Menampilkan semua test.
     */
    public function index()
    {
        $this->authorize('admin');
        $tests = $this->testModel->getAllTests();
        return $tests;
    }

    /**
     * Menampilkan halaman untuk membuat test baru.
     */
    public function create()
    {
        $this->authorize('admin');
        $majors = $this->majorModel->getAllMajors();
        $status = $this->statusModel->getAllStatus();
        
        $data = [
            'majors' => $majors,
            'status' => $status
        ];
        
        require_once __DIR__ . '/../views/pages/management/test/add.php';
        return $data;
    }

    /**
     * Menyimpan test baru ke database.
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
        $errors = $this->validateTestInputs($_POST);

        // Jika ada error, kembalikan ke view dengan error
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/test-create');
        }

        // Simpan test ke database
        $test = $this->testModel->createTest(
            $_POST['teacher_id'],
            trim($_POST['test_name']),
            trim($_POST['test_date']),
            trim($_POST['test_status']),
            trim($_POST['subject_name']),
            trim($_POST['total_questions']),
            trim($_POST['test_major'])
        );

        if ($test) {
            $this->handleStudentCreation($test['id'], $_POST['test_major']);
            $_SESSION['flash'] = 'Test berhasil dibuat.';
            header('Location: ' . $_ENV['BASE_URL'] . '/tests');
            exit;
        } else {
            $_SESSION['flash'] = 'Gagal membuat test.';
            header('Location: ' . $_ENV['BASE_URL'] . '/test-create');
            exit;
        }
    }

    private function handleStudentCreation($test_id, $major_id)
    {
        // Ambil semua siswa dalam kelas dan tambahkan ke tabel students
        $students = $this->studentDataModel->getStudentsByMajorId($major_id);
        foreach ($students as $student) {
            $rollno = $student['id'];
            $username = $student['username']; // Perbaiki variabel dari $$username menjadi $username
            $password = $this->generateRandomString(8 - strlen($test_id)) . $test_id;
            $this->studentModel->createStudent($test_id, $rollno, $username, $password);
        }
    }

    /**
     * Menghapus test dari database.
     */
    public function delete($id)
    {
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
     * Memvalidasi input test.
     */
    private function validateTestInputs($data)
    {
        $errors = [];
        if (empty(trim($data['test_name']))) {
            $errors['test_name'] = 'Test Name is required.';
        }
        if (empty(trim($data['subject_name']))) {
            $errors['subject_name'] = 'Subject Name is required.';
        }
        if (empty(trim($data['test_date']))) {
            $errors['test_date'] = 'Test Date is required.';
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
}
?>
