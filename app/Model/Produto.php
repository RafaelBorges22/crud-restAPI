<?php

namespace App\Model;
use App\Database\Database;
use PDO;
use PDOException;

class Produto {
    private $produtoId;
    private $nome;
    private $descricao;
    private $estoque;
    private $preco;
    private $user_insert;
    private $data_hora;
    private $conn;
    private $table = 'produtos';

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getProdutoId() {
        return $this->produtoId;
    }
    public function setProdutoId($produtoId): self {
        $this->produtoId = $produtoId;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome): self {
        $this->nome = $nome;

        return $this;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao): self {
        $this->descricao = $descricao;
        return $this;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco): self {
        $this->preco = $preco;
        return $this;
    }
    public function getEstoque() {
        return $this->estoque;
    }

    public function setEstoque($estoque): self {
        $this->estoque = $estoque;
        return $this;
    }

    public function getUserInsert() {
        return $this->user_insert;
    }

    public function setUserInsert($userInsert): self {
        $this->user_insert = $userInsert;
        return $this;
    }

    public function insertProduto($produto) {
        $nome = $this->getNome();
        $descricao = $this->getDescricao();
        $estoque = $this->getEstoque();
        $preco = $this->getPreco();
        $user_insert = $this->getUserInsert();

        $query1 = "INSERT INTO $this->table (nome, descricao, estoque, preco, user_insert) 
            VALUES (:nome, :descricao, :estoque, :preco, :user_insert)";

        $stmt = $this->conn->prepare($query1);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":estoque", $estoque);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":user_insert", $user_insert);

        $stmt->execute();

        $acao = "CRIACAO PRODUTO";

        $query2 = "INSERT INTO logs (acao, produto_id, user_insert) VALUES (:acao, :produto_id, :user_insert)";
        $logStmt = $this->conn->prepare($query2);

        $logStmt->bindValue(":acao", $acao);
        $logStmt->bindValue(":produto_id", $this->conn->lastInsertId());
        $logStmt->bindValue(":user_insert", $user_insert);

        return $logStmt->execute();
    }

    public function getAllProdutos() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProdutoById($produtoId) {
        $query = "SELECT * FROM $this->table WHERE id = :produtoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":produtoId", $produtoId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduto($produto) {
        $produto_id = $this->getProdutoId();
        $nome = $this->getNome();
        $descricao = $this->getDescricao();
        $estoque = $this->getEstoque();
        $preco = $this->getPreco();
        $user_insert = $this->getUserInsert();

        $query1 = "UPDATE $this->table 
                SET nome = :nome, 
                    descricao = :descricao, 
                    estoque = :estoque, 
                    preco = :preco, 
                    user_insert = :user_insert 
                WHERE id = :produto_id";

        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":estoque", $estoque);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":user_insert", $user_insert);
        $stmt->bindParam(":produto_id", $produto_id);

        $stmt->execute();

        $acao = "ATUALIZAO PRODUTO";

        $query2 = "INSERT INTO logs (acao, produto_id, user_insert) VALUES (:acao, :produto_id, :user_insert)";
        $logStmt = $this->conn->prepare($query2);

        $logStmt->bindValue(":acao", $acao);
        $logStmt->bindValue(":produto_id", $produto_id);
        $logStmt->bindValue(":user_insert", $user_insert);

        return $logStmt->execute();
    }

    public function deleteProduto($produto_id) { 
        $query1 = "SELECT user_insert FROM $this->table WHERE id = :produto_id";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindValue(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        $query2 = "DELETE FROM $this->table WHERE id = :produto_id";

        $deleteStmt = $this->conn->prepare($query2);
        $deleteStmt->bindParam(":produto_id", $produto_id, PDO::PARAM_INT);

        $deleteStmt->execute();

        $user_insert = $produto['user_insert'];

        $acao = "EXCLUSAO PRODUTO";

        $query3 = "INSERT INTO logs (acao, produto_id, user_insert) VALUES (:acao, :produto_id, :user_insert)";
        $logStmt = $this->conn->prepare($query3);

        $logStmt->bindValue(":acao", $acao);
        $logStmt->bindValue(":produto_id", $produto_id);
        $logStmt->bindValue(":user_insert", $user_insert);

        return $logStmt->execute();
    }
}