<?php

namespace App;

require_once "../vendor/autoload.php";

use app\Model\Produto;
use App\Controller\ProdutoController;

function createUsers($data) {
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

createUsers($produto1);


/*rota controller
$produtoModel = new Produto();
$controller = new ProdutoController($produtoModel);

$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($url) {
    case '/create':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            $controller->create($data);
        }
        break;

    case '/login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            $controller->login($data);
        }
        break;

    case (preg_match('/\/read\/(\d+)/', $url, $matches) ? true : false):
        if ($method === 'GET') {
            $id = $matches[1];
            $controller->read($id);
        }
        break;

    case '/read':
        if ($method === 'GET') {
            $controller->read();
        }
        break;

    case (preg_match('/\/update\/(\d+)/', $url, $matches) ? true : false):
        if ($method === 'PUT') {
            $id = $matches[1];
            $data = json_decode(file_get_contents('php://input'));
            $controller->update($id, $data);
        }
        break;

    case (preg_match('/\/delete\/(\d+)/', $url, $matches) ? true : false):
        if ($method === 'DELETE') {
            $id = $matches[1];
            $controller->delete($id);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada"]);
        break;
}
*/
