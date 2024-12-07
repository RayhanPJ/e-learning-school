<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TestModel.php';
require_once __DIR__ . '/../models/ScoreCalculationModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';

class DashboardController extends BaseController
{
    private $db;
    private $testModel;
    private $scoreCalculationModel;

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->db = (new Database())->connect(); // Menghubungkan ke database
        $this->testModel = new TestModel(); // Menginisialisasi model Test
        $this->scoreCalculationModel = new ScoreCalculationModel(); // Menginisialisasi model ScoreCalculation
    }

    /**
     * Menampilkan halaman dashboard.
     */
    public function dashboard()
    {
        $this->checkUserLogin(); // Memastikan pengguna sudah login

        // Mengambil data ujian berdasarkan peran pengguna
        if ($_SESSION['role'] == 'admin') {
            // Jika pengguna adalah admin, ambil semua ujian tanpa status siswa
            $tests = $this->testModel->getAllTestsWithStatus(); // Mengambil ujian dengan status untuk admin
        } else {
            // Jika pengguna adalah siswa, ambil ujian dengan status siswa
            $tests = $this->testModel->getAllTestsWithStudentStatus($_SESSION['user_id']); // Mengambil ujian dengan status siswa
        }

        // Menyiapkan data untuk tampilan
        $preparedTests = [];
        foreach ($tests as $test) {
            // Menentukan warna dan teks badge berdasarkan status_id
            $badgeColor = '';
            $badgeText = '';
            $clickable = true;

            // Menentukan badge berdasarkan status_id
            switch ($test['status_id']) {
                case 2:
                    $badgeColor = 'badge-success'; // Hijau
                    $badgeText = 'TEST RUNNING'; // Ujian sedang berlangsung
                    break;
                case 1:
                    $badgeColor = 'badge-warning'; // Kuning
                    $badgeText = 'TEST PENDING'; // Ujian tertunda
                    $clickable = false; // Tidak dapat diklik
                    break;
                case 3:
                    $badgeColor = 'badge-info'; // Biru
                    $badgeText = 'TEST COMPLETED'; // Ujian selesai
                    break;
                default:
                    $clickable = false; // Tidak dapat diklik untuk status lainnya
                    break;
            }

            // Menentukan badge tambahan berdasarkan student_status
            $studentBadgeColor = '';
            $studentBadgeText = '';
            $studentClickable = true;

            if (isset($test['student_status'])) { // Memeriksa apakah student_status ada
                if ($test['student_status'] === 1) {
                    $studentBadgeColor = 'badge-info'; // Biru
                    $studentBadgeText = 'Done'; // Selesai
                    $studentClickable = false; // Tidak dapat diklik
                } elseif ($test['student_status'] === 0) {
                    $studentBadgeColor = 'badge-success'; // Hijau
                    $studentBadgeText = 'On Going'; // Sedang berlangsung
                }
            }

            // Menggabungkan clickability
            if (!$clickable || !$studentClickable) {
                $clickable = false; // Jika salah satu tidak dapat diklik, set ke false
            }

            // Menghitung rata-rata skor dan grade jika ujian telah selesai dan pengguna adalah siswa
            $averageScore = null;
            $grade = null;
            if ($_SESSION['role'] !== 'admin' && $test['student_status'] === 1) { // Hanya menghitung jika ujian telah selesai untuk siswa
                $averageScore = $this->scoreCalculationModel->calculateAverageScore($_SESSION['user_id'], $test['id']); // Menghitung rata-rata skor
                $grade = $this->scoreCalculationModel->getGrade($averageScore); // Mendapatkan grade
            }

            // Menyiapkan data ujian dengan badge, clickability, rata-rata skor, dan grade
            $preparedTests[] = [
                'id' => $test['id'],
                'name' => $test['name'],
                'subject' => $test['subject'],
                'date' => $test['date'],
                'badgeColor' => $badgeColor,
                'badgeText' => $badgeText,
                'studentBadgeColor' => $studentBadgeColor,
                'studentBadgeText' => $studentBadgeText,
                'studentScore' => isset($test['student_score']) ? $test['student_score'] : null, // Hanya untuk siswa
                'studentStatus' => isset($test['student_status']) ? $test['student_status'] : null, // Hanya untuk siswa
                'clickable' => $clickable,
                'url' => ($_SESSION['role'] === 'student') ? $_ENV['BASE_URL'] . '/questions-show/' . $test['id'] : $_ENV['BASE_URL'] . '/tests-detail/' . $test['id'],
                'averageScore' => $averageScore,
                'grade' => $grade,
            ];
        }

        // Mengarahkan data ujian yang telah disiapkan ke tampilan
        require_once __DIR__ . '/../views/dashboard.php';
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
