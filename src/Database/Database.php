<?php

namespace Vendor\Backend;

use PDO;
use PDOException;

class Database {
    private $path = "produtosdb.sqlite";
    
    public function connect() {
        try {
            $pdo = new PDO("sqlite:" . $this->path);
            return $pdo;

        } catch (PDOException $err) {
            echo "Cannot connect with DB: " . $err->getMessage();
        }
    }
}

$conn = new Database();
$conn->connect();
