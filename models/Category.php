<?php
class Category {
    // DB Connection
    private $conn;
    private $table = 'categories';
   
    
    // Properties
    public $id;
    public $category;

    // Constructor

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get categories
    public function read() {
        // Create query
        $query = 'SELECT id, category FROM categories ORDER BY id ASC';

        // Prepare statement
        try { 
            $stmt = $this->conn->prepare($query);
        } catch (PDOException $e) {
        echo "Error preparing statement: " . $e->getMessage();
        return null;
        }
        
        // Execute query
       try { $stmt->execute();
       } catch (PDOException $e) {
            echo "Error executing query: " . $e->getMessage();
            return null;
        } 

        return $stmt;
    }

     // Get single category
     public function read_single() {
        $query = 'SELECT id, category 
        FROM categories
        WHERE id = ?
        ORDER BY category DESC
        LIMIT 1'; 

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) { 
            // Set properties
            $this->category = $row['category'];
            $this->id = $row['id'];
        } else {
            
        }   
    } 

    // Create Category
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';

        // Prepare Statement
        try {
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(':category', $this->category);

            // Execute Query
            if ($stmt->execute()) {
                // Get last inserted ID
                $this->id = $this->conn->lastInsertId();  // Set category ID to last inserted ID
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Catch any errors during the execution
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update Category
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';

        // Prepare Statement
        try {
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            
            // Catch any errors during the execution
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete Category
    public function delete() {
        // Create Query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare Statement
        try {
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {

            // Catch any errors during the execution
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>