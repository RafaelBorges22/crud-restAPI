<?php

namespace App\Controller;

use App\Model\Produto;
use PDOException;

class ControllerProduto {

    public function createProduto($request) {
        $produto = new Produto();
        
        $data = [
            'nome' => $request['nome'],
            'descricao' => $request['descricao'],
            'estoque' => $request['estoque'],
            'preco' => $request['preco'],
            'user_insert' => $request['user_insert']
        ];

        try {
            $produto->insertProduto($data);
            echo "Produto criado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao criar o produto: " . $e->getMessage();
        }
    }

    public function listProdutos() {
        $produto = new Produto();
        try {
            $produtos = $produto->getAllProdutos();  
            return $produtos;  
        } catch (PDOException $e) {
            echo "Erro ao listar produtos: " . $e->getMessage();
        }
    }

    public function getProduto($produtoId) {
        $produto = new Produto();
        try {
            $produtoData = $produto->getProdutoId($produtoId); 
            if ($produtoData) {
                return $produtoData;
            } else {
                echo "Produto não encontrado.";
            }
        } catch (PDOException $e) {
            echo "Erro ao buscar produto: " . $e->getMessage();
        }
    }

    public function updateProduto($produtoId, $request) {
        $produto = new Produto();
        try {
            $produto->setProdutoId($produtoId)
                    ->setNome($request['nome'])
                    ->setDescricao($request['descricao'])
                    ->setEstoque($request['estoque'])
                    ->setPreco($request['preco'])
                    ->setUserInsert($request['user_insert']);
                    
           // $produto->insertProduto($data);  

            echo "Produto atualizado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao atualizar o produto: " . $e->getMessage();
        }
    }

    public function deleteProduto($produtoId) {
        $produto = new Produto();
        try {
            $produto->deleteProduto($produtoId);
            echo "Produto excluído com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao excluir o produto: " . $e->getMessage();
        }
    }
}

