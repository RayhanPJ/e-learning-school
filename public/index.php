<?php
// var_dump($requestUri, $requestSrv);die;
require_once __DIR__ . '/../controllers/UserController.php';  // Perhatikan penempatan path yang benar

$controller =  new UserController();

// Ambil request URI dan gunakan parse_url untuk memisahkan path dari URL
$base_url = '/e-learning-school/public';

$requestUri = $_SERVER['REQUEST_URI'];
$requestSrv = $_SERVER['REQUEST_METHOD'];


switch (true) {
    // Rute untuk mendapatkan daftar pengguna
    case $requestUri === $base_url . '/users' && $requestSrv === 'GET':
        $users = $controller->index();
        // require_once __DIR__ . '/../views/pages/management/users/list.php';  // Pastikan path relatif benar
        break;

    // Rute untuk menampilkan form pembuatan pengguna
    case $requestUri === $base_url . '/users/create' && $requestSrv === 'GET':
        require_once __DIR__ . '/../views/management/users/add.php';
        break;

    // Rute untuk menyimpan pengguna baru
    case $requestUri === $base_url . '/users/store' && $requestSrv === 'POST':
        $controller->store();
        break;

    // Rute untuk menampilkan form edit pengguna
    case preg_match($base_url . '/\/edit\/(\d+)/', $requestUri, $matches) && $requestSrv === 'GET':
        $user = $controller->edit($matches[1]);
        require_once __DIR__ . '/../views/management/users/edit.php';
        break;

    // Rute untuk memperbarui pengguna
    case preg_match($base_url . '/\/update\/(\d+)/', $requestUri, $matches) && $requestSrv === 'POST':
        $controller->update($matches[1]);
        break;

    // Rute untuk menghapus pengguna
    case preg_match($base_url . '/\/delete\/(\d+)/', $requestUri, $matches) && $requestSrv === 'GET':
        $controller->delete($matches[1]);
        break;

    default:
        echo "404 Not Found";
        break;
}
