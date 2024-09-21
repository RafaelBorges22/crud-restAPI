<?php
namespace app\Controller;

use app\Model\Produto;

class ProdutoController {
    private $produto;

    // Construtor com nome correto
    public function __construct(Produto $model) {
        $this->produto = $model;
    }

    public function create($data) {
        if (!isset($data->produtoId, $data->nome, $data->descricao)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos"]);
            return;
        }

        $ProdutoExistente = $this->produto->getProdutoId($data->produtoId);
        if ($ProdutoExistente) {
            http_response_code(409);
            echo json_encode(["error" => "Esse produto já existe."]);
            return;
        }

        $produto = new Produto();
        $produto->setNome($data->nome);
        $produto->setProdutoId($data->produtoId);
        $produto->setDescricao($data->descricao);

        if ($this->produto->insertProduto($produto)) {
            http_response_code(201);
            echo json_encode(["message" => "Produto criado com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Falha ao criar o produto."]);
        }
    }

    public function login($data) {
        if (!isset($data->user_insert)) {
            http_response_code(400);
            echo json_encode(["error" => "Precisa preencher o campo de usuário para login"]);
            return;
        }

        $produto = $this->produto->getUserInsert($data->user_insert);
        if ($produto($data->user_insert, $produto["user_insert"])) {
            unset($produto['user_insert']);
            http_response_code(200);
            echo json_encode(["message" => "Login bem sucedido", "user_insert" => $produto]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Nome de usuario inválido"]);
        }
    }

    public function read($id = null) {
        if ($id) {
            $result = $this->produto->getProdutoId($id);
            if($result){
                unset($result['senha']);
                $status = 200 ;
            }else{
                $status = 404;
            }
            
        } else {
            $result = $this->produto->getProdutoId();
            foreach ($result as &$produto) {
                unset($produto['senha']);
            }
            unset($produto);
            $status = !empty($result) ? 200 : 404;
        }
        http_response_code($status);
        echo json_encode($result ?: ["message"=>"nenhum produto encontrado"]);
    }

    public function update($id, $data) {
        if (!isset($data->nome, $data->descricao, $data->preco)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos para atualização do produto"]);
            return;
        }

        $this->produto->setProdutoId($id)->setNome($data->nome)->setDescricao($data->descricao)->setPreco($data->preco);

        if ($this->produto->insertProduto($this->produto)) {
            http_response_code(200);
            echo json_encode(["message" => "Produto atualizado com sucesso"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao atualizar produto"]);
        }
    }

    public function delete($id) {
        if ($this->produto->deleteProduto($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Produto excluído com sucesso"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao excluir produto"]);
        }
    }

}

