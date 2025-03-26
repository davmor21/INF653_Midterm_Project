<?php
    class Author{
        // DB Stuff
        private $conn;
        private $table = 'authors';

        // Properties
        public $id;
        public $author; 

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Authors
        public function read() {
            // Create query
            $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id ASC';
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Executed query
            $stmt->execute();

            return $stmt;
        }
        public function read_single(){
            // Create query
            $query = 'SELECT id, author
                FROM ' . $this->table . '
                WHERE id = ?
                LIMIT 1';
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row){
                // Set Properties
                $this->author = $row['author'];
                $this->id = $row['id'];
            } else{
                
            }
        }
        public function create(){
            // Create query
            $query = 'INSERT INTO ' . $this->table . ' (author) VALUES(:author)';
                
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind data
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
        // Update Author
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';

            // Prepare Statement
            try {
                $stmt = $this->conn->prepare($query);

                // Clean data
                $this->author = htmlspecialchars(strip_tags($this->author));
                $this->id = htmlspecialchars(strip_tags($this->id));

                // Bind data
                $stmt->bindParam(':author', $this->author);
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

        // Delete Author
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

                // Catch any errors during execution
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
    }
?>