<?php
// Import TeachersController
require_once __DIR__ . '/../controllers/TeachersController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/AuthController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/DashboardController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/MajorController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/TestController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/RegistersController.php';  // Pastikan path relatif benar

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
$base_url = '/e-learning-school/public';
$requestUri = str_replace($base_url, '', $requestUri);  // Menghapus base_url dari requestUri

switch (true) {
    // Rute untuk dahsboard
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
    
    // Rute untuk get invoice pengguna
    case preg_match('/^\/users-invoice\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $user = $registersController->invoice($matches[1]);
        
        break;

    // Rute untuk menghapus pengguna
    case preg_match('/^\/users\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $controller->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar pengguna
    case $requestUri === '/major' && $requestSrv === 'GET':
        $major = $majorController->index();
         // Pastikan path relatif benar
        break;

    // Rute untuk menampilkan form pembuatan pengguna
    case $requestUri === '/major-create' && $requestSrv === 'GET':
        $majorController->create();
        
        break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === '/major-store' && $requestSrv === 'POST':
        $majorController->store();
        break;

    // Rute untuk menampilkan form edit pengguna
    case preg_match('/^\/major-edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $major = $majorController->edit((int)$matches[1]); // Konversi ID ke integer
        
        break;    

    // Rute untuk memperbarui pengguna
    case preg_match('/^\/major\/update\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'POST':
        $majorController->update($matches[1]);
        break;

    // Rute untuk menghapus pengguna
    case preg_match('/^\/major\/delete\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $majorController->delete($matches[1]);
        break;

    // Rute untuk mendapatkan daftar pengguna
    // case $requestUri === '/test' && $requestSrv === 'GET':
    //     $test = $testController->index();
    //     require_once __DIR__ . '/../views/pages/management/test/list.php';  // Pastikan path relatif benar
    //     break;

    // Rute untuk menampilkan form pembuatan pengguna
    case $requestUri === '/registers-create' && $requestSrv === 'GET':
        $registers['majors'] = $registersController->create();
        
        break;
    case $requestUri === '/register-store' && $requestSrv === 'POST':
        $registersController->store();
        break;
    
    // Rute untuk menampilkan form pembuatan test
    case $requestUri === '/test-create' && $requestSrv === 'GET':
        $testController->create();
        
        break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === '/tests-store' && $requestSrv === 'POST':
        $testController->store();
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
