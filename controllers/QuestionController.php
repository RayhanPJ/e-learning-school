<?php
require_once __DIR__ . '/../models/QuestionModel.php';
require_once __DIR__ . '/../models/QuestionTestMappingModel.php'; // Sertakan model pemetaan
require_once __DIR__ . '/../models/ScoreModel.php'; // Sertakan model skor
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi autoloader vendor

use Dotenv\Dotenv;

class QuestionController extends BaseController
{
    private $questionModel;
    private $questionTestMappingModel; // Tambahkan model pemetaan
    private $scoreModel; // Tambahkan model skor

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->questionModel = new QuestionModel(); // Menginisialisasi model Question
        $this->questionTestMappingModel = new QuestionTestMappingModel(); // Menginisialisasi model pemetaan
        $this->scoreModel = new ScoreModel(); // Menginisialisasi model Score
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load(); // Memuat variabel lingkungan
    }

    /**
     * Menampilkan semua pertanyaan.
     */
    public function index()
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi
        $questions = $this->questionModel->getAllQuestions(); // Mengambil semua pertanyaan

        require_once __DIR__ . '/../views/pages/management/question/list.php'; // Memuat tampilan daftar pertanyaan

        return $questions; // Mengembalikan daftar pertanyaan
    }

    /**
     * Menampilkan halaman untuk membuat pertanyaan baru.
     */
    public function create($id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi
        $tests_id = $id; // Menyimpan ID ujian

        require_once __DIR__ . '/../views/pages/management/question/add.php'; // Memuat tampilan untuk menambah pertanyaan

        return $tests_id; // Mengembalikan ID ujian
    }

    /**
     * Menampilkan halaman untuk mengedit pertanyaan yang ada.
     */
    public function edit($id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi
        $question = $this->questionModel->getQuestionById($id); // Mengambil pertanyaan berdasarkan ID
        
        if (!$question) {
            $_SESSION['flash'] = 'Pertanyaan tidak ditemukan.'; // Mengatur pesan flash jika pertanyaan tidak ditemukan
            header('Location: ' . $_ENV['BASE_URL'] . '/questions'); // Mengarahkan ke daftar pertanyaan
            exit;
        }

        require_once __DIR__ . '/../views/pages/management/question/edit.php'; // Memuat tampilan untuk mengedit pertanyaan

        return $questions; // Mengembalikan pertanyaan
    }

    /**
     * Menyimpan pertanyaan baru ke dalam database.
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
        $errors = $this->validateQuestionInputs($_POST); // Memvalidasi input

        // Jika ada kesalahan, kembali ke tampilan dengan kesalahan
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/questions-create');
        }

        // Menyimpan pertanyaan ke dalam database
        $question = $this->questionModel->createQuestion(
            trim($_POST['title']),
            trim($_POST['optionA']),
            trim($_POST['optionB']),
            trim($_POST['optionC']),
            trim($_POST['optionD']),
            trim($_POST['correctAns']),
            trim($_POST['score'])
        );

        if ($question) {
            $question_id = $question['id']; // Mendapatkan ID pertanyaan yang baru dimasukkan

            $this->questionTestMappingModel->createMapping($question_id, trim($_POST['tests_id'])); // Membuat pemetaan
            $this->scoreModel->createScore(trim($_POST['tests_id']), $question_id); // Membuat entri skor

            $_SESSION['flash'] = 'Pertanyaan berhasil dibuat.'; // Mengatur pesan sukses
            header('Location: ' . $_ENV['BASE_URL'] . '/tests-detail/' . $_POST['tests_id']); // Mengarahkan ke detail ujian
            exit;
        } else {
            $_SESSION['flash'] = 'Gagal membuat pertanyaan.'; // Mengatur pesan gagal
            header('Location: ' . $_ENV['BASE_URL'] . '/questions-create'); // Mengarahkan kembali ke formulir pembuatan
            exit;
        }
    }

    /**
     * Memperbarui pertanyaan yang ada.
     */
    public function update($id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($id); // Menangani operasi pembaruan
        }
    }

    private function handleUpdate($id)
    {
        $errors = $this->validateQuestionInputs($_POST); // Memvalidasi input

        // Jika ada kesalahan, kembali ke tampilan dengan kesalahan
        if (!empty($errors)) {
            $this->handleValidationErrors($errors, $_POST, '/questions-edit/' . $id);
        }

        // Memperbarui pertanyaan di database
        $updated = $this->questionModel->updateQuestion(
            $id,
            trim($_POST['title']),
            trim($_POST['optionA']),
            trim($_POST['optionB']),
            trim($_POST['optionC']),
            trim($_POST['optionD']),
            trim($_POST['correctAns']),
            trim($_POST['score'])
        );

        if ($updated) {
            $_SESSION['flash'] = 'Pertanyaan berhasil diperbarui.'; // Mengatur pesan sukses
            header('Location: ' . $_ENV['BASE_URL'] . '/questions'); // Mengarahkan ke daftar pertanyaan
            exit;
        } else {
            $_SESSION['flash'] = 'Gagal memperbarui pertanyaan.'; // Mengatur pesan gagal
            header('Location: ' . $_ENV['BASE_URL'] . '/questions-edit/' . $id); // Mengarahkan kembali ke formulir edit
            exit;
        }
    }

    /**
     * Menghapus pertanyaan dari database.
     */
    public function delete($id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi

        if ($this->questionModel->deleteQuestion($id)) {
            $this->questionTestMappingModel->deleteMapping($id, null); // Opsional menghapus pemetaan
            $_SESSION['flash'] = 'Pertanyaan berhasil dihapus.'; // Mengatur pesan sukses
            header('Location: ' . $_ENV['BASE_URL'] . '/questions'); // Mengarahkan ke daftar pertanyaan
            exit;
        } else {
            die('Gagal menghapus pertanyaan.'); // Menangani kegagalan
        }
    }

    /**
     * Menampilkan pertanyaan untuk ujian tertentu.
     */
    public function showQuestions($test_id)
    {
        $this->authorize('student'); // Memastikan pengguna memiliki otorisasi

        // Mengambil pertanyaan untuk ujian yang ditentukan
        $questions = $this->questionTestMappingModel->getQuestionsByTestId($test_id);

        // Memuat tampilan untuk menampilkan pertanyaan
        require_once __DIR__ . '/../views/pages/management/question/show.php';

        return $questions; // Mengembalikan daftar pertanyaan
    }

    /**
     * Menangani pengiriman jawaban ujian.
     */
    public function submitAnswers()
    {
        $this->authorize('student'); // Memastikan pengguna memiliki otorisasi sebagai siswa
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_SESSION['user_id']; // Mengambil ID siswa dari sesi
            $total_score = 0; // Inisialisasi total skor
    
            foreach ($_POST['q_answer'] as $question_id => $selected_option) {
                // Mengambil jawaban yang benar untuk pertanyaan
                $question = $this->questionModel->getQuestionById($question_id);
                if ($question) {
                    // Memeriksa apakah opsi yang dipilih benar
                    if ($question['correctAns'] == $selected_option) {
                        // Memperbarui jumlah jawaban benar di tabel skor
                        $this->scoreModel->updateCorrectCount($question_id, 1);
    
                        // Mendapatkan skor untuk pertanyaan
                        $score_earned = $this->scoreModel->getQuestionScore($question_id);
                        $total_score += $score_earned; // Mengakumulasi total skor
                    }
                }
            }
    
            // Memperbarui total skor siswa berdasarkan total skor yang diperoleh
            $this->scoreModel->updateStudentScore($student_id, $total_score);
    
            // Mengarahkan ke dashboard setelah pemrosesan
            header('Location: ' . $_ENV['BASE_URL'] . '/dashboard');
            exit;
        }
    }

    /**
     * Memvalidasi input pertanyaan.
     */
    private function validateQuestionInputs($data)
    {
        $errors = [];
        if (empty(trim($data['title']))) {
            $errors['title'] = 'Judul pertanyaan diperlukan.'; // Pesan kesalahan jika judul kosong
        }
        if (empty(trim($data['optionA']))) {
            $errors['optionA'] = 'Opsi A diperlukan.'; // Pesan kesalahan jika opsi A kosong
        }
        if (empty(trim($data['optionB']))) {
            $errors['optionB'] = 'Opsi B diperlukan.'; // Pesan kesalahan jika opsi B kosong
        }
        if (empty(trim($data['optionC']))) {
            $errors['optionC'] = 'Opsi C diperlukan.'; // Pesan kesalahan jika opsi C kosong
        }
        if (empty(trim($data['optionD']))) {
            $errors['optionD'] = 'Opsi D diperlukan.'; // Pesan kesalahan jika opsi D kosong
        }
        if (empty(trim($data['correctAns']))) {
            $errors['correctAns'] = 'Jawaban benar diperlukan.'; // Pesan kesalahan jika jawaban benar kosong
        }
        if (empty(trim($data['score']))) {
            $errors['score'] = 'Skor diperlukan.'; // Pesan kesalahan jika skor kosong
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
}
?>
