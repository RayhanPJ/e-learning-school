<?php
require_once __DIR__ . '/../models/TestModel.php';
require_once __DIR__ . '/../models/StudentDataModel.php';
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/MajorModel.php';
require_once __DIR__ . '/../models/StatusModel.php';
require_once __DIR__ . '/../models/QuestionModel.php';
require_once __DIR__ . '/../models/ScoreCalculationModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi autoloader vendor

use Dotenv\Dotenv;

class TestController extends BaseController
{
    private $testModel;
    private $studentDataModel;
    private $studentModel;
    private $majorModel;
    private $statusModel;
    private $questionModel;
    private $scoreCalculationModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->testModel = new TestModel(); // Menginisialisasi model Test
        $this->studentDataModel = new StudentDataModel(); // Menginisialisasi model Data Siswa
        $this->studentModel = new StudentModel(); // Menginisialisasi model Siswa
        $this->majorModel = new MajorModel(); // Menginisialisasi model Jurusan
        $this->statusModel = new StatusModel(); // Menginisialisasi model Status
        $this->questionModel = new QuestionModel(); // Menginisialisasi model Pertanyaan
        $this->scoreCalculationModel = new ScoreCalculationModel(); // Menginisialisasi model Perhitungan Skor
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load(); // Memuat variabel lingkungan
    }

    /**
     * Menampilkan semua test.
     */
    public function index()
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi
        $tests = $this->testModel->getAllTestsWithStatus(); // Mengambil semua ujian dengan status

        require_once __DIR__ . '/../views/pages/management/test/list.php'; // Memuat tampilan daftar ujian
        return $tests; // Mengembalikan daftar ujian
    }

    /**
     * Menampilkan laporan semua test.
     */
    public function report()
    {
        $this->checkUserLogin(); // Memastikan pengguna sudah login
        $tests = $this->testModel->getAllTestsWithStatus(); // Mengambil semua ujian dengan status

        // Inisialisasi model perhitungan skor
        $this->scoreCalculationModel = new ScoreCalculationModel();

        // Menyiapkan data untuk tampilan
        $preparedTests = [];
        foreach ($tests as $test) {
            // Menghitung total skor untuk ujian
            $totalScore = $this->scoreCalculationModel->getTotalScoreForTest($test['id']);

            // Menghitung rata-rata skor dan grade jika ujian telah selesai
            $averageScore = null;
            $grade = null;
            if ($test['student_status'] === 1) { // Hanya menghitung jika ujian telah selesai
                $averageScore = $this->scoreCalculationModel->calculateAverageScore($_SESSION['user_id'], $test['id']);
                $grade = $this->scoreCalculationModel->getGrade($averageScore);
            }

            // Menyiapkan data ujian dengan total skor, rata-rata skor, dan grade
            $preparedTests[] = [
                'id' => $test['id'],
                'name' => $test['name'],
                'subject' => $test['subject'],
                'date' => $test['date'],
                'teacher_username' => $test['teacher_username'],
                'major_name' => $test['major_name'],
                'total_questions' => $test['total_questions'],
                'status_name' => $test['status_name'],
                'studentScore' => $test['student_score'],
                'studentStatus' => $test['student_status'],
                'totalScore' => $totalScore, // Menyertakan total skor
                'averageScore' => $averageScore,
                'grade' => $grade,
            ];
        }

        // Mengarahkan data ujian yang telah disiapkan ke tampilan laporan
        require_once __DIR__ . '/../views/pages/report/list.php';
    }

    /**
     * Menampilkan halaman untuk membuat test baru.
     */
    public function create()
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi
        $majors = $this->majorModel->getAllMajors(); // Mengambil semua jurusan
        $status = $this->statusModel->getAllStatus(); // Mengambil semua status
        
        $data = [
            'majors' => $majors,
            'status' => $status
        ];
        
        require_once __DIR__ . '/../views/pages/management/test/add.php'; // Memuat tampilan untuk menambah ujian
        return $data; // Mengembalikan data jurusan dan status
    }

    /**
     * Menampilkan halaman untuk mengedit test yang ada.
     */
    public function edit($id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi
        $majors = $this->majorModel->getAllMajors(); // Mengambil semua jurusan
        $status = $this->statusModel->getAllStatus(); // Mengambil semua status
        $tests = $this->testModel->getTestById($id); // Mengambil ujian berdasarkan ID
        $page = 'edit'; // Menentukan halaman edit
        
        $data = [
            'majors' => $majors,
            'status' => $status,
            'tests' => $tests,
            'page' => $page
        ];
        
        require_once __DIR__ . '/../views/pages/management/test/edit.php'; // Memuat tampilan untuk mengedit ujian
        return $data; // Mengembalikan data jurusan, status, dan ujian
    }

    /**
     * Menampilkan halaman detail test yang ada.
     */
    public function detail($id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi
        $majors = $this->majorModel->getAllMajors(); // Mengambil semua jurusan
        $status = $this->statusModel->getAllStatus(); // Mengambil semua status
        $tests = $this->testModel->getTestById($id); // Mengambil ujian berdasarkan ID
        $questions = $this->questionModel->getAllQuestions(); // Mengambil semua pertanyaan
        $page = 'detail'; // Menentukan halaman detail
        
        $data = [
            'majors' => $majors,
            'status' => $status,
            'tests' => $tests,
            'questions' => $questions,
            'page' => $page
        ];
        
        require_once __DIR__ . '/../views/pages/management/test/edit.php'; // Memuat tampilan untuk detail ujian
        return $data; // Mengembalikan data jurusan, status, ujian, dan pertanyaan
    }

    /**
     * Menyimpan test baru ke database.
     */
    public function store()
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStore(); // Menangani operasi penyimpanan
        }
    }

    private function handleStore()
    {
        $errors = $this->validateTestInputs($_POST); // Memvalidasi input

        // Jika ada kesalahan, kembalikan ke tampilan dengan kesalahan
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/test-create');
        }

        // Simpan test ke database
        $test = $this->testModel->createTest(
            $_SESSION['user_id'],
            trim($_POST['test_name']),
            trim($_POST['test_date']),
            trim($_POST['test_status']),
            trim($_POST['subject_name']),
            trim($_POST['total_questions']),
            trim($_POST['major_id'])
        );

        if ($test) {
            $this->handleStudentCreation($test['id'], $_POST['major_id']); // Menangani pembuatan siswa
            $_SESSION['flash'] = 'Test berhasil dibuat.'; // Mengatur pesan sukses
            header('Location: ' . $_ENV['BASE_URL'] . '/tests'); // Mengarahkan ke daftar ujian
            exit;
        } else {
            $_SESSION['flash'] = 'Gagal membuat test.'; // Mengatur pesan gagal
            header('Location: ' . $_ENV['BASE_URL'] . '/test-create'); // Mengarahkan kembali ke formulir pembuatan
            exit;
        }
    }

    private function handleStudentCreation($test_id, $major_id)
    {
        // Mengambil semua siswa dalam jurusan dan menambahkan ke tabel siswa
        $students = $this->studentDataModel->getStudentsByMajorId($major_id);
        foreach ($students as $student) {
            $rollno = $student['id'];
            $username = $student['register_name']; // Mengambil nama pendaftaran siswa
            $password = $this->generateRandomString(8 - strlen($test_id)) . $test_id; // Menghasilkan password acak
            $this->studentModel->createStudent($test_id, $rollno, $username, $password); // Membuat entri siswa
        }
    }

    /**
     * Menghapus test dari database.
     */
    public function delete($id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi

        if ($this->testModel->deleteTest($id)) {
            $_SESSION['flash'] = 'Test berhasil dihapus.'; // Mengatur pesan sukses
            header('Location: ' . $_ENV['BASE_URL'] . '/tests'); // Mengarahkan ke daftar ujian
            exit;
        } else {
            die('Gagal menghapus test.'); // Menangani kegagalan
        }
    }

    /**
     * Memvalidasi input test.
     */
    private function validateTestInputs($data)
    {
        $errors = [];
        if (empty(trim($data['test_name']))) {
            $errors['test_name'] = 'Nama test diperlukan.'; // Pesan kesalahan jika nama test kosong
        }
        if (empty(trim($data['subject_name']))) {
            $errors['subject_name'] = 'Nama mata pelajaran diperlukan.'; // Pesan kesalahan jika nama mata pelajaran kosong
        }
        if (empty(trim($data['test_date']))) {
            $errors['test_date'] = 'Tanggal test diperlukan.'; // Pesan kesalahan jika tanggal test kosong
        }
        return $errors; // Mengembalikan daftar kesalahan
    }

    /**
     * Menangani kesalahan validasi.
     */
    private function handleValidationErrors($errors, $oldData, $redirectPath)
    {
        $_SESSION['errors'] = $errors; // Menyimpan kesalahan di sesi
        $_SESSION['old'] = $oldData;    // Menyimpan data input lama
        header('Location: ' . $_ENV['BASE_URL'] . $redirectPath); // Mengarahkan kembali ke formulir
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
            $randomString .= $characters[rand(0, $charactersLength - 1)]; // Menghasilkan karakter acak
        }

        return $randomString; // Mengembalikan string acak
    }

    /**
     * Memeriksa apakah pengguna sudah login.
     */
    private function checkUserLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirectToLogin(); // Mengarahkan ke halaman login jika belum login
        }
    }

    /**
     * Mengarahkan pengguna ke halaman login.
     */
    private function redirectToLogin()
    {
        header('Location: ' . $_ENV['BASE_URL'] . '/login'); // Mengarahkan ke halaman login
        exit; // Menghentikan eksekusi script
    }
}
?>
