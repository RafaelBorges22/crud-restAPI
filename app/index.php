<?php

namespace App;

require_once "../vendor/autoload.php";

use App\Model\Produto;

function createUser($data) {
    $produto = new Produto();

    $produto->insertProduto($data);

}

$produto1 = [
    "nome" => "Camiseta",
    "descricao" => "Camiseta M",
    "estoque" => 100,
    "preco" => 30.00,
    "user_insert" => "Joao",
];

createUser($produto1);
