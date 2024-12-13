<?php
require_once __DIR__ . '/../models/QuestionModel.php';
require_once __DIR__ . '/../models/QuestionTestMappingModel.php'; // Sertakan model pemetaan
require_once __DIR__ . '/../models/StudentModel.php'; // Sertakan model skor
require_once __DIR__ . '/../controllers/BaseController.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi autoloader vendor

use Dotenv\Dotenv;

class QuestionController extends BaseController
{
    private $questionModel;
    private $questionTestMappingModel; // Tambahkan model pemetaan
    private $studentModel; // Tambahkan model skor

    public function __construct()
    {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->questionModel = new QuestionModel(); // Menginisialisasi model Question
        $this->questionTestMappingModel = new QuestionTestMappingModel(); // Menginisialisasi model pemetaan
        $this->studentModel = new StudentModel(); // Menginisialisasi model Score
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load(); // Memuat variabel lingkungan
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
            header('Location: ' . $_ENV['BASE_URL'] . '/dashboard'); // Mengarahkan ke daftar pertanyaan
            exit;
        }

        require_once __DIR__ . '/../views/pages/management/question/edit.php'; // Memuat tampilan untuk mengedit pertanyaan

        return $question; // Mengembalikan pertanyaan
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
            $this->questionTestMappingModel->createMapping($question['id'], trim($_POST['tests_id'])); // Membuat pemetaan

            $_SESSION['flash'] = 'Pertanyaan berhasil dibuat.'; // Mengatur pesan sukses
            $_SESSION['class'] = 'alert-success';
            header('Location: ' . $_ENV['BASE_URL'] . '/tests-detail/' . $_POST['tests_id']); // Mengarahkan ke detail ujian
            exit;
        } else {
            $_SESSION['flash'] = 'Gagal membuat pertanyaan.'; // Mengatur pesan gagal
            $_SESSION['class'] = 'alert-warning';
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
            $_SESSION['class'] = 'alert-success';
            header('Location: ' . $_ENV['BASE_URL'] . '/dashboard'); // Mengarahkan ke daftar pertanyaan
            exit;
        } else {
            $_SESSION['flash'] = 'Gagal memperbarui pertanyaan.'; // Mengatur pesan gagal
            $_SESSION['class'] = 'alert-warning';
            header('Location: ' . $_ENV['BASE_URL'] . '/questions-edit/' . $id); // Mengarahkan kembali ke formulir edit
            exit;
        }
    }

    /**
     * Menghapus pertanyaan dari database.
     */
    public function delete($id, $test_id)
    {
        $this->authorize('admin'); // Memastikan pengguna memiliki otorisasi

        $this->questionTestMappingModel->deleteMapping($id, $test_id); // Opsional menghapus pemetaan
        if ($this->questionModel->deleteQuestion($id)) {
            $_SESSION['flash'] = 'Pertanyaan berhasil dihapus.'; // Mengatur pesan sukses
            $_SESSION['class'] = 'alert-danger';
            header('Location: ' . $_ENV['BASE_URL'] . '/dashboard'); // Mengarahkan ke daftar pertanyaan
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
                        $total_score += $question['score']; // Mengakumulasi total skor
                    }
                    
                }
            }

            // Memperbarui total skor siswa berdasarkan total skor yang diperoleh
            $this->studentModel->updateStudentScore($student_id, $total_score);

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
