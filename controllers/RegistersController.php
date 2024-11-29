<?php
require_once __DIR__ . '/../models/RegistersModel.php';
require_once __DIR__ . '/../models/MajorModel.php';
require_once __DIR__ . '/../models/StudentDataModel.php';

class RegistersController {
    private $registersModel;
    private $majorModel;
    private $studentDataModel;

    public function __construct() {
        $this->registersModel = new RegistersModel();
        $this->majorModel = new MajorModel();
        $this->studentDataModel = new StudentDataModel();
    }

    // Method to show the registration form
    public function create() {
        $majors = $this->majorModel->getAllMajors();
        return $majors;
    }

    // Method to handle the registration logic
    public function store() {
        session_start();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $date_of_birth = trim($_POST['date_of_birth']);
            $phone = trim($_POST['phone']);
            $major_id = trim($_POST['major_id']);

            // Validate inputs
            if (empty($name)) {
                $errors['name'] = 'Please enter your name';
            }
            if (empty($date_of_birth)) {
                $errors['date_of_birth'] = 'Please enter your date of birth';
            }
            if (empty($phone)) {
                $errors['phone'] = 'Please enter your phone number';
            }
            if (empty($major_id)) {
                $errors['major_id'] = 'Please select a major';
            }

            // If there are errors, return to the form with errors
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST; // Save old input
                header('Location: ' . $_ENV['BASE_URL'] . '/registers-create');
                exit;
            }

            // Create the register
            

            // Create the register
            $registers = $this->registersModel->createRegister($name, $date_of_birth, $phone, $major_id);
            $_SESSION['flash'] = 'Registrasi berhasil ditambahkan.';
            // var_dump($registers['id']);die;
            if (isset($registers)) {
                $registersId = $registers['id'];
                $majorId = $registers['major_id'];
                // Tambahkan roll numbers ke student_data
                if ($this->studentDataModel->createStudentData($registersId, $majorId)) {
                    $_SESSION['flash'] = 'Student Data berhasil ditambahkan.';
                } else {
                    $_SESSION['flash'] = 'Student Data gagal ditambahkan';
                }
                header('Location: ' . $_ENV['BASE_URL'] . '/users-invoice/' . $registers['id']);
                exit;
            } else {
                $_SESSION['flash'] = 'Student gagal ditambahkan.';
                header('Location: ' . $_ENV['BASE_URL'] . '/registers-create');
                exit;
            }
        }
    }

    public function invoice($id)
    {
        session_start();
        return $this->registersModel->getRegisterById($id);
    }

    // private function authorize($requiredRole)
    // {
    //     if (!isset($_SESSION['user_id'])) {
    //         header('Location: ' . $_ENV['BASE_URL'] . '/login');
    //         exit;
    //     }

    //     if ($_SESSION['role'] !== $requiredRole) {
    //         header('Location: ' . $_ENV['BASE_URL'] . '/dashboard');
    //         exit;
    //     }
    // }
}
?>
