// models/ClassModel.php
<?php
require_once __DIR__ . '/../config/database.php';

class ClassModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllClass() {
        $query = "SELECT * FROM classes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createClass($name, $starting_roll_number, $ending_roll_number)
    {
        // Query untuk memasukkan data baru
        $query = "INSERT INTO classes (name, starting_roll_number, ending_roll_number) 
                  VALUES (:name, :starting_roll_number, :ending_roll_number)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':starting_roll_number', $starting_roll_number);
        $stmt->bindValue(':ending_roll_number', $ending_roll_number);
        $stmt->execute();

        // Return data yang baru dibuat
        return $this->getClassById($this->db->lastInsertId());
    }
    

    public function getClassById($id) {
        $query = "SELECT * FROM classes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateClass($id, $name) {
        $query = "UPDATE classes SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function deleteClass($id) {
        $query = "DELETE FROM classes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>
