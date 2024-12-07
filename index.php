<?php
// Import Controllers
require_once __DIR__ . '/controllers/TeachersController.php';  
require_once __DIR__ . '/controllers/AuthController.php';  
require_once __DIR__ . '/controllers/DashboardController.php';  
require_once __DIR__ . '/controllers/MajorController.php';  
require_once __DIR__ . '/controllers/TestController.php';  
require_once __DIR__ . '/controllers/RegistersController.php';  
require_once __DIR__ . '/controllers/QuestionController.php';  

// Inisialisasi controller
$controller = new TeachersController();
$dashboardController = new DashboardController();
$authController = new AuthController();
$majorController = new MajorController();
$testController = new TestController();
$registersController = new RegistersController();
$questionsController = new QuestionController();

// Ambil request URI dan metode request
$requestUri = $_SERVER['REQUEST_URI'];
$requestSrv = $_SERVER['REQUEST_METHOD'];

// Menghilangkan bagian "/e-learning-school/public" dari requestUri
$base_url = '/e-learning-school';
$requestUri = str_replace($base_url, '', $requestUri);  // Menghapus base_url dari requestUri

// Redirect ke /registers-create jika mengakses root URL
if ($requestUri === '/') {
    header('Location: ' . $_ENV['BASE_URL'] . '/registers-create');
    exit;
}

// Routing
switch (true) {
    // Rute untuk dashboard
    case $requestUri === '/dashboard' && $requestSrv === 'GET':
        $dashboardController->dashboard();
        break;

    // Rute untuk login form
    case $requestUri === '/login' && $requestSrv === 'GET':
        $authController->index();
        break;

    // Rute untuk login action (POST)
    case $requestUri === '/login' && $requestSrv === 'POST':
        $authController->login();
        break;

    // Rute untuk logout
    case $requestUri === '/logout' && $requestSrv === 'GET':
        $authController->logout();
        break;

    // Rute untuk mendapatkan daftar pengguna
    case $requestUri === '/users' && $requestSrv === 'GET':
        $controller->index();
        break;

    // Rute untuk menampilkan form pembuatan pengguna
    case $requestUri === '/users-create' && $requestSrv === 'GET':
        $controller->create();
        break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === '/users-store' && $requestSrv === 'POST':
        $controller->store();
        break;

    // Rute untuk menampilkan form edit pengguna
    case preg_match('/^\/users-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $controller->edit((int)$matches[1]); // Konversi ID ke integer
        break;    

    // Rute untuk memperbarui pengguna
    case preg_match('/^\/users\/update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $controller->update($matches[1]);
        break;
    
    // Rute untuk mendapatkan invoice pengguna
    case preg_match('/^\/users-invoice\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $registersController->invoice($matches[1]);
        break;

    // Rute untuk memperbarui invoice
    case preg_match('/^\/invoice-update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $registersController->confirmPayment($matches[1]);
        break;

    // Rute untuk menghapus pengguna
    case preg_match('/^\/users\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $controller->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar major
    case $requestUri === '/major' && $requestSrv === 'GET':
        $majorController->index();
        break;

    // Rute untuk menampilkan form pembuatan major
    case $requestUri === '/major-create' && $requestSrv === 'GET':
        $majorController->create();
        break;

    // Rute untuk menyimpan major baru
    case $requestUri === '/major-store' && $requestSrv === 'POST':
        $majorController->store();
        break;

    // Rute untuk menampilkan form edit major
    case preg_match('/^\/major-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $majorController->edit((int)$matches[1]); // Konversi ID ke integer
        break;    

    // Rute untuk memperbarui major
    case preg_match('/^\/major\/update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $majorController->update($matches[1]);
        break;

    // Rute untuk menghapus major
    case preg_match('/^\/major\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $majorController->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar registrasi
    case $requestUri === '/registers' && $requestSrv === 'GET':
        $registersController->index();
        break;

    // Rute untuk menampilkan form pembuatan registrasi
    case $requestUri === '/registers-create' && $requestSrv === 'GET':
        $registersController->create();
        break;

    // Rute untuk menyimpan registrasi baru
    case $requestUri === '/registers-store' && $requestSrv === 'POST':
        $registersController->store();
        break;
    
    // Rute untuk menampilkan form edit registrasi
    case preg_match('/^\/registers-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $registersController->edit($matches[1]);
        break;

    // Rute untuk memperbarui registrasi
    case preg_match('/^\/registers-update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $registersController->update($matches[1]);
        break;

    // Rute untuk menghapus registrasi
    case preg_match('/^\/registers\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $registersController->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar test
    case $requestUri === '/tests' && $requestSrv === 'GET':
        $testController->index();
        break;

    // Rute untuk menampilkan table test report
    case $requestUri === '/tests-report' && $requestSrv === 'GET':
        $testController->report();
        break;

    // Rute untuk menampilkan form edit test
    case preg_match('/^\/tests-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $testController->edit($matches[1]);
        break;

    // Rute untuk menampilkan form detail test
    case preg_match('/^\/tests-detail\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $testController->detail($matches[1]);
        break;

    // Rute untuk menampilkan form pembuatan test
    case $requestUri === '/tests-create' && $requestSrv === 'GET':
        $testController->create();
        break;

    // Rute untuk menyimpan test baru
    case $requestUri === '/tests-store' && $requestSrv === 'POST':
        $testController->store();
        break;

    // Rute untuk menghapus test
    case preg_match('/^\/tests\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $testController->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar questions
    case $requestUri === '/questions' && $requestSrv === 'GET':
        $questionsController->index();
        break;

    // Rute untuk menampilkan form edit questions
    case preg_match('/^\/questions-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $questionsController->edit($matches[1]);
        break;

    // Rute untuk menampilkan form pembuatan questions
    case preg_match('/^\/questions-create\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $questionsController->create($matches[1]);
        break;

    // Rute untuk menampilkan form pembuatan questions
    case preg_match('/^\/questions-show\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $questionsController->showQuestions($matches[1]);
        break;

    // Rute untuk menyimpan questions baru
    case $requestUri === '/questions-store' && $requestSrv === 'POST':
        $questionsController->store();
        break;

    // Rute untuk menyimpan jawaban
    case $requestUri === '/submit-answers' && $requestSrv === 'POST':
        $questionsController->submitAnswers();
        break;

    // Rute untuk menghapus questions
    case preg_match('/^\/questions\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $questionsController->delete($matches[1]);
        break;

    default:
        echo "404 Not Found"; // Menampilkan pesan jika rute tidak ditemukan
        break;
}
