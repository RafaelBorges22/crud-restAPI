<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    // private $path = "produtos.sqlite";
    private $host = '127.0.0.1';
    private $db = 'produtosdb';
    private $user = 'root';
    private $pass = 'root';
    private $charset = 'utf8mb4';
    private $conn;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
            $this->conn = new PDO($dsn, $this->user, $this->pass, [PDO::ATTR_PERSISTENT => true]);

        } catch (PDOException $err) {
            echo "Cannot connect with DB: " . $err->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->conn;
        
    }
}

