<?php
    class Quote {
        // DB Connection
        private $conn;
        private $table = 'quotes';
    
        
        // Properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;
        public $author;
        public $category;

        // Constructor

        public function __construct($db) {
            $this->conn = $db;
        }

        // Get categories
        public function read() {
            // Create query
            $query = 'SELECT 
            a.author as "Author Name",
            c.category as "Category",
            q.id,
            q.quote,
            q.author_id,
            q.category_id
            FROM
            ' . $this->table . ' q
            LEFT JOIN
                authors a ON a.id = q.author_id
            LEFT JOIN categories c ON c.id = category_id
            WHERE 1 = 1';

            // Create array for parameters
            $params = [];

            // Check for author_id
            if(!empty($this->author_id)) {
                $query .= ' AND q.author_id = :author_id';
                $params[':author_id'] = $this->author_id;
            }

            // Check for category_id
            if (!empty($this->category_id)) {
                $query .= ' AND q.category_id = :category_id';
                $params[':category_id'] = $this->category_id;
            }

                // Prepare statement
                try { 
                    $stmt = $this->conn->prepare($query);
                } catch (PDOException $e) {
                echo "Error preparing statement: " . $e->getMessage();
                return null;
                }

                // Bind parameters (if they exist)
                foreach($params as $key => $value) {
                    $stmt->bindParam($key, $value);
                }
                
                // Execute query
            try { $stmt->execute();
            } catch (PDOException $e) {
                echo "Error executing query: " . $e->getMessage();
                return null;
            } 
        
            return $stmt;
        }

        // Get single post

        public function read_single() {
            $query = 'SELECT 
            a.author as "Author Name",
            c.category as "Category",
            q.id,
            q.quote,
            q.author_id,
            q.category_id
            
        FROM
        ' . $this->table . ' q
        LEFT JOIN
            authors a ON a.id = q.author_id
        LEFT JOIN categories c ON c.id = q.category_id
        WHERE
            q.id = ?
            LIMIT 1';   

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
        // Set properties
        $this->id = $row['id'];
        $this->quote = $row['quote'];
        $this->author = $row['Author Name'];
        $this->author_id = $row['author_id'];
        $this->category = $row['Category'];
        $this->category_id = $row['category_id'];
        } else {
            
        }
    }

    // Create Quote
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)';

        // Prepare Statement
        try {
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            
            // Execute Query
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
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

    // Update Quote
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET quote = :quote, author_id = :author_id, category_id = :category_id WHERE id = :id';

        // Prepare Statement
        try {
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
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

        // Delete Quote
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
    public function exists($quote_id) {
        $query = 'SELECT id FROM ' . $this->table . '
        WHERE id = :quote_id LIMIT 1';

        //Prepare query
        $stmt = $this->conn->prepare($query);

        //Bind parameter
        $stmt->bindParam(':quote_id', $quote_id);

        //Execute query
        $stmt->execute();

        //Check if any row is returned
        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}