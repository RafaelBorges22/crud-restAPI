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

    public function insertProduto($data) {
        // $nome = $produto->getNome();
        // $descricao = $produto->getDescricao();
        // $estoque = $produto->getEstoque();
        // $preco = $produto->getPreco();
        // $user_insert = $produto->getUserInsert();

        // query

        $nome = $data['nome'];
        $descricao = $data['descricao'];
        $estoque = $data['estoque'];
        $preco = $data['preco'];
        $user_insert = $data['user_insert'];

        // var_dump($produto);

        $query = "INSERT INTO $this->table (nome, descricao, estoque, preco, user_insert) 
            VALUES (:nome, :descricao, :estoque, :preco, :user_insert)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":estoque", $estoque);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":user_insert", $user_insert);

        return $stmt->execute();

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

}