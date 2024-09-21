<?php

namespace app\Controller;
use app\Model\Produto;

class ProdutoController{
    private $produto;

    public function _construct(Produto $model){
        $this->produto = $model;
    }
public function create($data){
    if (!isset($data->produtoId, $data->nome, $data->descricao)) {
        # code...
    }
}

}



