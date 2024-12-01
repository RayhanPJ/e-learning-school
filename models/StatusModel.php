<?php
require_once __DIR__ . '/../config/database.php';

class StatusModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Method to get all majors
    public function getAllStatus() {
        $query = "SELECT * FROM status";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get a major by ID
    public function getStatusById($id) {
        $query = "SELECT * FROM major WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to create a new major
    public function createStatus($name, $price) {
        $query = "INSERT INTO major (name, price) VALUES (:name, :price)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':price', $price);
        $stmt->execute();

        // Return the newly created major
        return $this->getStatusById($this->db->lastInsertId());
    }

    // Method to update a major
    public function updateStatus($id, $name, $price) {
        $query = "UPDATE major SET name = :name, price = :price WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Method to delete a major
    public function deleteStatus($id) {
        $query = "DELETE FROM major WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>
