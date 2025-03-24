<?php
    
    class Database {
        private $conn;
        private $host;
        private $port = 5432;
        private $dbname;
        private $username;
        private $password;

        public function __construct() {
            $this->host = getenv('HOST');
            $this->dbname = getenv('DBNAME');
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
        }

        public function connect() {
            if ($this->conn) {
                return $this->conn;
            } else {
                $dsn = "pgsql:host={$this->host};dbname={$this->dbname};";
                try{
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch(PDOException $e) {
                    echo 'Connection Error: ' . $e->getMessage();

                }
            }
        }
    }
 