<?php
require_once __DIR__ . '/../config/database.php';

class TestModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Menghubungkan ke database
    }

    // Method untuk mengambil semua ujian
    public function getAllTests() {
        $query = "SELECT * FROM tests"; // Mengambil semua data dari tabel 'tests'
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua ujian sebagai array asosiatif
    }

    // Method untuk mengambil semua ujian dengan status
    public function getAllTestsWithStatus() {
        $query = "
            SELECT 
                t.*,
                m.name AS major_name,
                s.name AS status_name,
                te.username AS teacher_username
            FROM 
                tests t  -- Mengambil data dari tabel 'tests'
            JOIN 
                major m ON t.major_id = m.id 
            JOIN 
                status s ON t.status_id = s.id
            JOIN 
                teachers te ON t.teacher_id = te.id
        ";
        
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->execute(); // Menjalankan kueri
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua hasil sebagai array asosiatif
    }

    // Method untuk mengambil semua ujian dengan status siswa
    public function getAllTestsWithStudentStatus($student_id = null) {
        $query = "
            SELECT 
                t.*,
                m.name AS major_name,
                s.name AS status_name,
                te.username AS teacher_username,
                st.score AS student_score,
                st.status AS student_status
            FROM 
                tests t
            JOIN 
                major m ON t.major_id = m.id 
            JOIN 
                status s ON t.status_id = s.id
            JOIN 
                teachers te ON t.teacher_id = te.id
            LEFT JOIN 
                students st ON t.id = st.test_id AND (:student_id IS NULL OR st.id = :student_id)
        ";
    
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':student_id', $student_id, $student_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL); // Mengikat ID siswa jika diberikan
        $stmt->execute(); // Menjalankan kueri
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua hasil sebagai array asosiatif
    }  
    
    public function getTestsByTestId($test_id, $student_id ) {
        // var_dump($test_id, $student_id);die;
        $query = "
            SELECT 
                t.*,
                m.name AS major_name,
                s.name AS status_name,
                te.username AS teacher_username,
                st.score AS student_score,
                st.status AS student_status
            FROM 
                tests t
            JOIN 
                major m ON t.major_id = m.id 
            JOIN 
                status s ON t.status_id = s.id
            JOIN 
                teachers te ON t.teacher_id = te.id
            LEFT JOIN 
                students st ON t.id = st.test_id AND st.id = :student_id
            WHERE 
                t.id = :test_id
        ";
    
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':test_id', $test_id); // Mengikat test_id
        $stmt->bindValue(':student_id', $student_id); // Mengikat ID siswa jika diberikan
        $stmt->execute(); // Menjalankan kueri
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua hasil sebagai array asosiatif
    }

    // Method untuk membuat ujian baru
    public function createTest($teacher_id, $name, $date, $status_id, $subject, $total_questions, $major_id) {
        $query = "INSERT INTO tests (teacher_id, name, date, status_id, subject, total_questions, major_id) 
                  VALUES (:teacher_id, :name, :date, :status_id, :subject, :total_questions, :major_id)"; // Kuery untuk menyimpan ujian baru
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':teacher_id', $teacher_id); // Mengikat nilai teacher_id
        $stmt->bindValue(':name', $name); // Mengikat nilai nama ujian
        $stmt->bindValue(':date', $date); // Mengikat nilai tanggal ujian
        $stmt->bindValue(':status_id', $status_id); // Mengikat nilai status_id
        $stmt->bindValue(':subject', $subject); // Mengikat nilai subjek
        $stmt->bindValue(':total_questions', $total_questions); // Mengikat nilai total pertanyaan
        $stmt->bindValue(':major_id', $major_id); // Mengikat nilai major_id
        $stmt->execute(); // Menjalankan kueri

        return $this->getTestById($this->db->lastInsertId()); // Mengembalikan ujian yang baru dibuat
    }

    // Method untuk mendapatkan ujian berdasarkan ID
    public function getTestById($id) {
        $query = "SELECT * FROM tests WHERE id = :id"; // Kuery untuk mengambil ujian berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        $stmt->execute(); // Menjalankan kueri
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan ujian sebagai array asosiatif
    }

    // Method untuk memperbarui ujian
    public function updateTest($id, $teacher_id, $name, $date, $status_id, $subject, $total_questions, $major_id) {
        $query = "UPDATE tests 
                  SET teacher_id = :teacher_id, 
                      name = :name, 
                      date = :date, 
                      status_id = :status_id, 
                      subject = :subject, 
                      total_questions = :total_questions, 
                      major_id = :major_id 
                  WHERE id = :id"; // Kuery untuk memperbarui ujian
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':teacher_id', $teacher_id); // Mengikat nilai teacher_id
        $stmt->bindValue(':name', $name); // Mengikat nilai nama ujian
        $stmt->bindValue(':date', $date); // Mengikat nilai tanggal ujian
        $stmt->bindValue(':status_id', $status_id); // Mengikat nilai status_id
        $stmt->bindValue(':subject', $subject); // Mengikat nilai subjek
        $stmt->bindValue(':total_questions', $total_questions); // Mengikat nilai total pertanyaan
        $stmt->bindValue(':major_id', $major_id); // Mengikat nilai major_id
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
    

    // Method untuk menghapus ujian
    public function deleteTest($id) {
        $query = "DELETE FROM tests WHERE id = :id"; // Kuery untuk menghapus ujian berdasarkan ID
        $stmt = $this->db->prepare($query); // Menyiapkan pernyataan
        $stmt->bindValue(':id', $id); // Mengikat nilai ID
        return $stmt->execute(); // Mengembalikan true jika berhasil
    }
}
?>
