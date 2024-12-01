<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ .'/RegistersModel.php';

class StudentDataModel {
    private $db;
    private $registersModel;

    public function __construct() {
        $this->db = (new Database())->connect();
        $this->registersModel = new RegistersModel();
    }

    // Fetch all student data
    public function getAllStudentData() {
        $query = "SELECT * FROM student_data";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert multiple roll numbers for a class
    public function createStudentData($registers_id, $major_id) {
        // Get the count of registers with the same major_id
        $countResult = $this->registersModel->countRegisterByMajorId($major_id);
        $rollno = 0;

        // If countResult is not empty, get the count
        if ($countResult) {
            $rollno = $countResult + 1; // Increment by 1 for the new entry
        } else {
            $rollno = 1; // If no registers exist, start with roll number 1
        }

        // Insert the new student data
        $queryInsert = "INSERT INTO student_data (registers_id, rollno, major_id) VALUES (:registers_id, :rollno, :major_id)";
        $stmtInsert = $this->db->prepare($queryInsert);
        $stmtInsert->bindValue(':registers_id', $registers_id);
        $stmtInsert->bindValue(':rollno', $rollno);
        $stmtInsert->bindValue(':major_id', $major_id);
        return $stmtInsert->execute();

    }
    
    // Fetch student data by ID
    public function getStudentDataById($id) {
        $query = "SELECT * FROM student_data WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentsByMajorId($major_id) {
        $query = "
            SELECT 
                sd.id,
                r.name AS register_name,
                r.date_of_birth,
                r.phone,
                r.major_id,
                m.name AS major_name,
                m.price AS major_price,  -- Assuming 'price' is a column in the 'major' table
                r.status_payment,
                sd.rollno,
                sd.registers_id
            FROM 
                student_data sd
            JOIN 
                registers r ON sd.registers_id = r.id
            JOIN 
                major m ON sd.major_id = m.id  -- Join to get major details
            WHERE 
                sd.major_id = :major_id
                AND r.status_payment = 1  -- Filter for students with paid status
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':major_id', $major_id, PDO::PARAM_INT);  // Corrected the parameter binding
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
      

    // Update student data
    public function updateStudentData($id, $rollno, $class_id) {
        $query = "UPDATE student_data SET rollno = :rollno, class_id = :class_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':rollno', $rollno, PDO::PARAM_INT);
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete student data by ID
    public function deleteStudentData($id) {
        $query = "DELETE FROM student_data WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
