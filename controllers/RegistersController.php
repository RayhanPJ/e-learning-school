<?php
require_once __DIR__ . '/../models/RegistersModel.php';
require_once __DIR__ . '/../models/MajorModel.php';
require_once __DIR__ . '/../models/StudentDataModel.php';
require_once __DIR__ . '/../controllers/BaseController.php';

class RegistersController extends BaseController
{
    private $registersModel;
    private $majorModel;
    private $studentDataModel;

    public function __construct() {
        parent::__construct(); // Memanggil konstruktor BaseController
        $this->registersModel = new RegistersModel();
        $this->majorModel = new MajorModel();
        $this->studentDataModel = new StudentDataModel();
        $this->setGuestRole();
    }

    /**
     * Menampilkan semua registrasi siswa.
     */
    public function index() {
        $this->authorize('admin');
        $students = $this->registersModel->getAllRegistersWithMajor();
        require_once __DIR__ . '/../views/pages/student/list.php'; 
        return $students;
    }

    /**
     * Menampilkan halaman untuk membuat registrasi siswa baru.
     */
    public function create() {
        $majors = $this->majorModel->getAllMajors();
        require_once __DIR__ . '/../views/pages/student/add.php';
        return $majors;
    }

    /**
     * Menyimpan data registrasi siswa baru.
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStore();
        }
    }

    /**
     * Menangani logika penyimpanan registrasi siswa baru.
     */
    private function handleStore() {
        $errors = $this->validateInputs($_POST);

        // Jika ada error, kembalikan ke form dengan error
        if (!empty($errors)) {
            $this->handleValidationErrors($errors);
        }

        // Buat registrasi
        $registers = $this->registersModel->createRegister(
            trim($_POST['name']),
            trim($_POST['date_of_birth']),
            trim($_POST['phone']),
            trim($_POST['major_id'])
        );

        $_SESSION['class'] = 'alert-success';
        $_SESSION['flash'] = 'Registrasi berhasil ditambahkan.';

        if ($registers) {
            $this->addStudentData($registers);
        } else {
            $_SESSION['class'] = 'alert-danger';
            $_SESSION['flash'] = 'Student gagal ditambahkan.';
            header('Location: ' . $_ENV['BASE_URL'] . '/registers-create');
            exit;
        }
    }

    /**
     * Memvalidasi input dari form registrasi.
     */
    private function validateInputs($data) {
        $errors = [];
        if (empty(trim($data['name']))) {
            $errors['name'] = 'Please enter your name';
        }
        if (empty(trim($data['date_of_birth']))) {
            $errors['date_of_birth'] = 'Please enter your date of birth';
        }
        if (empty(trim($data['phone']))) {
            $errors['phone'] = 'Please enter your phone number';
        }
        if (empty(trim($data['major_id']))) {
            $errors['major_id'] = 'Please select a major';
        }
        return $errors;
    }

    /**
     * Menangani kesalahan validasi dan mengarahkan kembali ke form.
     */
    private function handleValidationErrors($errors) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST; // Simpan input lama
        header('Location: ' . $_ENV['BASE_URL'] . '/registers-create');
        exit;
    }

    /**
     * Menambahkan data siswa setelah registrasi berhasil.
     */
    private function addStudentData($registers) {
        $registersId = $registers['id'];
        $majorId = $registers['major_id'];

        if ($this->studentDataModel->createStudentData($registersId, $majorId)) {
            $_SESSION['class'] = 'alert-success';
            $_SESSION['flash'] = 'Student Data berhasil ditambahkan.';
        } else {
            $_SESSION['class'] = 'alert-danger';
            $_SESSION['flash'] = 'Student Data gagal ditambahkan';
        }

        header('Location: ' . $_ENV['BASE_URL'] . ($_SESSION['role'] == 'admin' ? '/registers' : '/users-invoice/' . $registersId));
        exit;
    }

    /**
     * Menampilkan invoice berdasarkan ID registrasi.
     */
    public function invoice($id) {
        $user = $this->registersModel->getRegisterWithMajorById($id);
        require_once __DIR__ . '/../views/pages/invoice/invoice.php';
        return $user;
    }

    /**
     * Menampilkan halaman untuk mengedit registrasi siswa.
     */
    public function edit($id) {
        $this->authorize('admin');
        $registers = $this->registersModel->getRegisterById($id);
        $majors = $this->majorModel->getAllMajors();
        $data = [
            'registers' => $registers,
            'majors' => $majors
        ];
        
        require_once __DIR__ . '/../views/pages/student/edit.php';
        return $data; 
    }

    /**
     * Memperbarui data registrasi siswa.
     */
    public function update($id) {
        $this->authorize('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleUpdate($id);
        }
    }

    /**
     * Menangani logika pembaruan registrasi siswa.
     */
    private function handleUpdate($id) {
        $errors = $this->validateInputs($_POST);

        // Jika ada error, kembalikan ke form dengan error
        if (!empty($errors)) {
            $this->handleValidationErrors($errors);
        }

        // Perbarui data
        if ($this->registersModel->updateRegister($id, trim($_POST['name']), trim($_POST['date_of_birth']), trim($_POST['phone']), trim($_POST['major_id']))) {
            $_SESSION['class'] = 'alert-success';
            $_SESSION['flash'] = 'Register berhasil diperbarui.';
        } else {
            $_SESSION['class'] = 'alert-danger';
            $_SESSION['flash'] = 'Register gagal diperbarui.';
        }

        header('Location: ' . $_ENV['BASE_URL'] . ($_SESSION['role'] == 'admin' ? '/registers' : '/registers-create'));
        exit;
    }

    /**
     * Mengonfirmasi pembayaran berdasarkan ID registrasi.
     */
    public function confirmPayment($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePaymentConfirmation($id);
        }
    }

    /**
     * Menangani logika konfirmasi pembayaran.
     */
    private function handlePaymentConfirmation($id) {
        $status_payment = 1;

        if ($this->registersModel->confirmRegister($id, $status_payment)) {
            $_SESSION['flash'] = 'Payment Berhasil.';
            $_SESSION['class'] = 'alert-success';
        } else {
            $_SESSION['flash'] = 'Payment Gagal.';
            $_SESSION['class'] = 'alert-warning';
        }

        header('Location: ' . $_ENV['BASE_URL'] . ($_SESSION['role'] == 'admin' ? '/registers' : '/registers-create'));
        exit;
    }

    /**
     * Menghapus registrasi berdasarkan ID.
     */
    public function delete($id) {
        $this->authorize('admin');
        if ($this->registersModel->deleteRegister($id)) {
            $_SESSION['flash'] = 'Registers berhasil dihapus.';
            $_SESSION['class'] = 'alert-danger';
            header('Location: ' . $_ENV['BASE_URL'] . '/registers');
            exit;
        } else {
            die('Gagal menghapus registers.');
        }
    }
}
?>
