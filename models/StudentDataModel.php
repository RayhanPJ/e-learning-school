<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ .'/RegistersModel.php';

class StudentDataModel {
    private $db;
    private $registersModel;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
        $this->registersModel = new RegistersModel(); // Menginisialisasi model Registers
    }

    // Method untuk mengambil semua data siswa
    public function getAllStudentData() {
        $query = "SELECT * FROM student_data"; // Mengambil semua data dari tabel 'student_data'
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua data siswa sebagai array asosiatif
    }

    // Method untuk memasukkan beberapa nomor urut untuk sebuah kelas
    public function createStudentData($registers_id, $major_id) {
        // Menghitung jumlah pendaftaran dengan major_id yang sama
        $countResult = $this->registersModel->countRegisterByMajorId($major_id);
        $rollno = 0;

        // Jika countResult tidak kosong, ambil jumlahnya
        if ($countResult) {
            $rollno = $countResult + 1; // Increment 1 untuk entri baru
        } else {
            $rollno = 1; // Jika tidak ada pendaftaran, mulai dengan nomor urut 1
        }

        // Memasukkan data siswa baru
        $queryInsert = "INSERT INTO student_data (registers_id, rollno, major_id) VALUES (:registers_id, :rollno, :major_id)";
        $stmtInsert = $this->db->prepare($queryInsert); // Menyiapkan pernyataan
        $stmtInsert->bindValue(':registers_id', $registers_id); // Mengikat nilai registers_id
        $stmtInsert->bindValue(':rollno', $rollno); // Mengikat nilai rollno
        $stmtInsert->bindValue(':major_id', $major_id); // Mengikat nilai major_id
        return $stmtInsert->execute(); // Mengembalikan true jika berhasil
    }
    
    // Method untuk mengambil data siswa berdasarkan ID
    public function getStudentDataById($id) {
        $query = "SELECT * FROM student_data WHERE id = :id"; // Kuery untuk mengambil data siswa berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan data siswa sebagai array asosiatif
    }

    // Method untuk mengambil siswa berdasarkan ID jurusan
    public function getStudentsByMajorId($major_id) {
        $query = "
            SELECT 
                sd.id,
                r.name AS register_name,
                r.date_of_birth,
                r.phone,
                r.major_id,
                m.name AS major_name,
                m.price AS major_price,
                r.status_payment,
                sd.rollno,
                sd.registers_id
            FROM 
                student_data sd
            JOIN 
                registers r ON sd.registers_id = r.id
            JOIN 
                major m ON sd.major_id = m.id
            WHERE 
                sd.major_id = :major_id
                AND r.status_payment = 1 
        ";
        
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':major_id', $major_id, PDO::PARAM_INT); // Mengikat nilai major_id
        $stmt->execute(); // Menjalankan kueri
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua siswa untuk jurusan tertentu
    }

    // Method untuk memperbarui data siswa
    public function updateStudentData($id, $rollno, $class_id) {
        $query = "UPDATE student_data SET rollno = :rollno, class_id = :class_id WHERE id = :id"; // Kuery untuk memperbarui data siswa
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':rollno', $rollno, PDO::PARAM_INT); // Mengikat nilai rollno
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT); // Mengikat nilai class_id
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }

    // Method untuk menghapus data siswa berdasarkan ID
    public function deleteStudentData($id) {
        $query = "DELETE FROM student_data WHERE id = :id"; // Kuery untuk menghapus data siswa berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
}
?>
