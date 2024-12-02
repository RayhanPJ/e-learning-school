<?php
// Import Controllers
require_once __DIR__ . '/controllers/TeachersController.php';  
require_once __DIR__ . '/controllers/AuthController.php';  
require_once __DIR__ . '/controllers/DashboardController.php';  
require_once __DIR__ . '/controllers/MajorController.php';  
require_once __DIR__ . '/controllers/TestController.php';  
require_once __DIR__ . '/controllers/RegistersController.php';  

// Inisialisasi controller
$controller = new TeachersController();
$dashboardController = new DashboardController();
$authController = new AuthController();
$majorController = new MajorController();
$testController = new TestController();
$registersController = new RegistersController();

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
        $users = $controller->index();
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
        $user = $controller->edit((int)$matches[1]); // Konversi ID ke integer
        break;    

    // Rute untuk memperbarui pengguna
    case preg_match('/^\/users\/update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $controller->update($matches[1]);
        break;
    
    // Rute untuk mendapatkan invoice pengguna
    case preg_match('/^\/users-invoice\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $user = $registersController->invoice($matches[1]);
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
        $major = $majorController->index();
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
        $major = $majorController->edit((int)$matches[1]); // Konversi ID ke integer
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
        $students = $registersController->index();
        break;

    // Rute untuk menampilkan form pembuatan registrasi
    case $requestUri === '/registers-create' && $requestSrv === 'GET':
        $majors = $registersController->create();
        break;

    // Rute untuk menyimpan registrasi baru
    case $requestUri === '/registers-store' && $requestSrv === 'POST':
        $registersController->store();
        break;
    
    // Rute untuk menampilkan form edit registrasi
    case preg_match('/^\/registers-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $registersController->edit($matches[1]);
        break;

    // Rute untuk memperbaharui registrasi
    case preg_match('/^\/registers-update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $registersController->update($matches[1]);
        break;

    // Rute untuk menghapus registrasi
    case preg_match('/^\/registers\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $registersController->delete($matches[1]);
        break;

    // Rute untuk menampilkan form pembuatan test
    case $requestUri === '/test-create' && $requestSrv === 'GET':
        $testController->create();
        break;

    // Rute untuk menyimpan test baru
    case $requestUri === '/tests-store' && $requestSrv === 'POST':
        $testController->store();
        break;

    // Rute untuk menghapus test
    case preg_match('/^\/test\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $testController->delete($matches[1]);
        break;

    default:
        echo "404 Not Found";
        break;
}
