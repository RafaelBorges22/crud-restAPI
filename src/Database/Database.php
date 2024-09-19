<?php

namespace Vendor\Backend;

use PDO;

class Database {
    private $path = "produtosdb.sqlite";
    
    public function connect() {
        try {
            $pdo = new PDO("sqlite:$this->path");

            return $pdo;

        } catch (PDOException $err) {
            echo "Cannot connect with DB ".e->getMessage();
        }
    }
}

$conn = new Database;
$conn->connect();