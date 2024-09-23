<?php

namespace App;

require_once "../vendor/autoload.php";

use App\Controller\ProdutoController;
use App\Model\Produto;

$produto = new Produto();
$controller = new ProdutoController($produto);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents("php://input"));

$uri = $_SERVER['REQUEST_URI'];

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(preg_match('/\/produtos\/(\d+)/', $uri, $match)){
            $id = $match[1];
            $data = json_decode(file_get_contents('php://input'));
            $controller->read($id);
            break;
        } else {
            $controller->read();
        }
        break;
    case 'POST':
        $controller->create($data);
        break;
    case 'PUT':
        if(preg_match('/\/produtos\/(\d+)/', $uri, $match)){
            $id = $match[1];
            $data = json_decode(file_get_contents('php://input'));
            $controller->update($id, $data);
        }
    break;
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id === null) {
            http_response_code(405); // Not allowed
        }
        $controller->delete($id);
        break;
    default:
        echo "Hello";
}
