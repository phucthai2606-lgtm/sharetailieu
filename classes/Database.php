<?php
require_once(__DIR__ . '/../config/database.php');

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new PDO(
            "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USERNAME,
            DB_PASSWORD
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection() {
        return $this->conn;
    }
}