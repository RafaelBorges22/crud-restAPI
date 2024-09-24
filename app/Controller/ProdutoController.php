<?php

namespace App\Controller;

use App\Model\Produto;

class ProdutoController {
    private $produto;

    public function __construct(Produto $model) {
        $this->produto = $model;
    }

    public function create($data) {
        if (!isset($data->nome) || !isset($data->descricao) || !isset($data->estoque) || !isset($data->preco) || !isset($data->user_insert)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos"]);
        } else if (strlen($data->nome) < 3) {
            http_response_code(400);
            echo json_encode(["error" => "O produto deve ter no minimo 3 caracteres"]);
        } else if ($data->preco < 1) {
            http_response_code(400);
            echo json_encode(["error" => "O preço deve ser um valor positivo"]);
        } else if ($data->estoque < 0) {
            http_response_code(400);
            echo json_encode(["error" => "O estoque deve ser maior ou igual a zero"]);
        } else {
            $this->produto->setNome($data->nome);
            $this->produto->setDescricao($data->descricao);
            $this->produto->setPreco($data->preco);
            $this->produto->setEstoque($data->estoque);
            $this->produto->setUserInsert($data->user_insert);
    
            if ($this->produto->insertProduto($this->produto)) {
                http_response_code(201);
                echo json_encode(["message" => "Produto criado com sucesso."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Erro ao criar produto."]);
            }
        }
    }

    public function read($id = null) {
        if ($id) {
            $result = $this->produto->getProdutoById($id);

            
            http_response_code(200);;
            echo json_encode($result);
        } else {
            $result = $this->produto->getAllProdutos();
    
            http_response_code(200);;
            echo json_encode($result);
        }
    }

    public function update($id, $data) {
        if (!isset($data->nome) || !isset($data->descricao) || !isset($data->estoque) || !isset($data->preco) || !isset($data->user_insert)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos"]);
        }

        $this->produto->setProdutoId($id);
        $this->produto->setNome($data->nome);
        $this->produto->setDescricao($data->descricao);
        $this->produto->setPreco($data->preco);
        $this->produto->setEstoque($data->estoque);
        $this->produto->setUserInsert($data->user_insert);

        if ($this->produto->updateProduto($this->produto)) {
            http_response_code(201);
            echo json_encode(["message" => "Produto atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao atualizar produto."]);
        }
    }

    public function delete($id) {
        if ($this->produto->deleteProduto($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Produto excluído com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao excluir produto."]);
        }
    }
}