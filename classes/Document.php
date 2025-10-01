<?php
class Document {
    private $conn;
    private $table_name = "documents";

    public $id;
    public $title;
    public $description;
    public $file_path;
    public $category;
    public $user_id;
    public $approved;
    public $allow_download;
    public $uploaded_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET title=:title, description=:description, file_path=:file_path, category=:category, user_id=:user_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":file_path", $this->file_path);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":user_id", $this->user_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll($approved_only = true) {
        $query = "SELECT d.id, d.title, d.description, d.file_path, d.category, d.approved, d.allow_download, d.uploaded_at, u.username 
                  FROM " . $this->table_name . " d 
                  LEFT JOIN users u ON d.user_id = u.id";
        
        if($approved_only) {
            $query .= " WHERE d.approved = 1";
        }
        
        $query .= " ORDER BY d.uploaded_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function search($keyword, $category = null) {
        $query = "SELECT d.id, d.title, d.description, d.file_path, d.category, d.approved, d.allow_download, d.uploaded_at, u.username 
                  FROM " . $this->table_name . " d 
                  LEFT JOIN users u ON d.user_id = u.id 
                  WHERE d.approved = 1 AND (d.title LIKE :keyword OR d.description LIKE :keyword)";
        
        if($category && $category != 'all') {
            $query .= " AND d.category = :category";
        }
        
        $query .= " ORDER BY d.uploaded_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        
        if($category && $category != 'all') {
            $stmt->bindParam(":category", $category);
        }
        
        $stmt->execute();
        return $stmt;
    }

    public function approve() {
        $query = "UPDATE " . $this->table_name . " SET approved = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        
        return $stmt->execute();
    }

    public function toggleDownload() {
        $query = "UPDATE " . $this->table_name . " SET allow_download = :allow_download WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":allow_download", $this->allow_download);
        $stmt->bindParam(":id", $this->id);
        
        return $stmt->execute();
    }
}
?>