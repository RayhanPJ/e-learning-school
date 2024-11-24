<?php
// Import UserController
require_once __DIR__ . '/../controllers/UserController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/AuthController.php';  // Pastikan path relatif benar
require_once __DIR__ . '/../controllers/DashboardController.php';  // Pastikan path relatif benar

$controller = new UserController();
$dashboardController = new DashboardController();
$authController = new AuthController();

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
        $page = 'dashboard'; // Tentukan halaman yang akan dimuat
        require_once __DIR__ . '/../views/main.php'; // Load template utama
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
    case $requestUri === '/users/create' && $requestSrv === 'GET':
        require_once __DIR__ . '/../views/pages/management/users/add.php';
        break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === '/users/store' && $requestSrv === 'POST':
        $controller->store();
        break;

    // Rute untuk menampilkan form edit pengguna
    case preg_match('/^\/users\/edit\/(\d+)$/', $requestUri, $matches) && $requestSrv === 'GET':
        $user = $controller->edit($matches[1]);
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

    default:
        echo "404 Not Found";
        break;
}
