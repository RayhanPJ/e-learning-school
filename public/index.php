<?php
// Import UserController
require_once __DIR__ . '/../controllers/UserController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/AuthController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/DashboardController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/ClassController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/TestController.php';  // Pastikan path relatif benar

$controller = new UserController();
$dashboardController = new DashboardController();
$authController = new AuthController();
$classController = new ClassController();
$testController = new TestController();

// Ambil request URI dan metode request
$requestUri = $_SERVER['REQUEST_URI'];
$requestSrv = $_SERVER['REQUEST_METHOD'];

// Menghilangkan bagian "/e-learning-school/public" dari requestUri
$base_url = '/e-learning-school/public';
$requestUri = str_replace($base_url, '', $requestUri);  // Menghapus base_url dari requestUri

switch (true) {
    // Rute untuk dahsboard
    case $requestUri === '/dashboard' && $requestSrv === 'GET':
        $dashboardController->dashboard();
        // Sertakan template utama dengan konten dari dashboard
        require_once __DIR__ . '/../views/dashboard.php'; // Load template utama
        break;
    // Rute untuk login form
    case $requestUri === '/login' && $requestSrv === 'GET':
        require_once __DIR__ . '/../views/pages/auth/login.php';
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
        require_once __DIR__ . '/../views/pages/management/users/list.php';  // Pastikan path relatif benar
        break;

    // Rute untuk menampilkan form pembuatan pengguna
    case $requestUri === '/users-create' && $requestSrv === 'GET':
        $controller->create();
        require_once __DIR__ . '/../views/pages/management/users/add.php';
        break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === '/users-store' && $requestSrv === 'POST':
        $controller->store();
        break;

    // Rute untuk menampilkan form edit pengguna
    case preg_match('/^\/users-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $user = $controller->edit((int)$matches[1]); // Konversi ID ke integer
        require_once __DIR__ . '/../views/pages/management/users/edit.php';
        break;    

    // Rute untuk memperbarui pengguna
    case preg_match('/^\/users\/update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $controller->update($matches[1]);
        break;

    // Rute untuk menghapus pengguna
    case preg_match('/^\/users\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $controller->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar pengguna
    case $requestUri === '/class' && $requestSrv === 'GET':
        $class = $classController->index();
        require_once __DIR__ . '/../views/pages/management/class/list.php';  // Pastikan path relatif benar
        break;

    // Rute untuk menampilkan form pembuatan pengguna
    case $requestUri === '/class-create' && $requestSrv === 'GET':
        $classController->create();
        require_once __DIR__ . '/../views/pages/management/class/add.php';
        break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === '/class-store' && $requestSrv === 'POST':
        $classController->store();
        break;

    // Rute untuk menampilkan form edit pengguna
    case preg_match('/^\/class-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $class = $classController->edit((int)$matches[1]); // Konversi ID ke integer
        require_once __DIR__ . '/../views/pages/management/class/edit.php';
        break;    

    // Rute untuk memperbarui pengguna
    case preg_match('/^\/class\/update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $classController->update($matches[1]);
        break;

    // Rute untuk menghapus pengguna
    case preg_match('/^\/class\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $classController->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar pengguna
    case $requestUri === '/test' && $requestSrv === 'GET':
        $test = $testController->index();
        require_once __DIR__ . '/../views/pages/management/test/list.php';  // Pastikan path relatif benar
        break;

    // Rute untuk menampilkan form pembuatan pengguna
    // case $requestUri === '/test-create' && $requestSrv === 'GET':
    //     $testController->create();
    //     require_once __DIR__ . '/../views/pages/management/test/add.php';
    //     break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === '/tests-store' && $requestSrv === 'POST':
        // echo 'test';
        // json_encode($_POST);
        $testController->storeAPI();
        break;

    // // Rute untuk menampilkan form edit pengguna
    // case preg_match('/^\/test-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
    //     $test = $testController->edit((int)$matches[1]); // Konversi ID ke integer
    //     require_once __DIR__ . '/../views/pages/management/test/edit.php';
    //     break;    

    // // Rute untuk memperbarui pengguna
    // case preg_match('/^\/test\/update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
    //     $testController->update($matches[1]);
    //     break;

    // Rute untuk menghapus pengguna
    case preg_match('/^\/test\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $testController->delete($matches[1]);
        break;

    default:
        echo "404 Not Found";
        break;
}
