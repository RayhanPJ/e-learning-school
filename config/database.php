<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Lokasi vendor autoloader

use Dotenv\Dotenv;

class Database
{
    private $host;
    private $dbName;
    private $username;
    private $password;
    private $port;
    private $conn;

    public function __construct()
    {
        // Inisialisasi dotenv untuk membaca file .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Mengambil konfigurasi dari file .env
        $this->host = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'] ?? 'root'; // Default username jika tidak ditentukan
        $this->password = $_ENV['DB_PASSWORD'] ?? '';    // Default password jika tidak ditentukan
        $this->port = $_ENV['DB_PORT'] ?? 3306;          // Default port jika tidak ditentukan
    }

    public function connect()
    {
        try {
            // Membuat DSN untuk koneksi PDO
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbName;charset=utf8mb4";

            // Membuat koneksi ke database menggunakan PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Set mode error ke exception untuk penanganan error yang lebih baik
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Mengembalikan koneksi yang sudah terhubung
            return $this->conn;

        } catch (PDOException $e) {
            // Menangani error dan menampilkan pesan error
            // Pastikan untuk tidak menampilkan error langsung pada produksi
            error_log("Database connection failed: " . $e->getMessage());  // Log error
            die("Database connection failed. Please try again later.");
        }
    }
}
