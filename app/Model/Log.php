<?php

namespace App\Model;
use App\Database\Database;
use PDO;
use PDOException;

class Log {
    private $logId;
    private $acao;
    private $data_hora;
    private $produto_id;
    private $user_insert;
    private $table = 'logs';
    
    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getLogId() {
        return $this->logId;
    }

    public function setLogId($produtoId): self {
        $this->logId = $logId;
        return $this;
    }

    public function getAcao() {
        return $this->logId;
    }

    public function setAcao($acao): self {
        $this->acao = $acao;
        return $this;
    }

    public function getDataHora() {
        return $this->data_hora;
    }

    public function setDataHora($data_hora): self {
        $this->data_hora = $data_hora;
        return $this;
    }

    public function getProdutoId() {
        return $this->produto_id;
    }

    public function setProdutoId($produto_id): self {
        $this->produto_id = $produto_id;
        return $this;
    }

    public function getUserInsert() {
        return $this->produto_id;
    }

    public function setUserInsert($user_insert): self {
        $this->user_insert = $user_insert;
        return $this;
    }

    public function getAllLogs() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}