<?php

namespace App;

require_once "../vendor/autoload.php";

use App\Controller\ProdutoController;
use App\Model\Produto;

use App\Controller\LogController;
use App\Model\Log;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$produto = new Produto();
$controller = new ProdutoController($produto);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents("php://input"));

$uri = $_SERVER['REQUEST_URI'];

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (str_contains($uri, '/produtos')) {
            if(preg_match('/\/produtos\/(\d+)/', $uri, $match)){
                $id = $match[1];
                $data = json_decode(file_get_contents('php://input'));
                $controller->read($id);
            } else {
                $controller->read();
            }
        } else if ($uri === '/logs') {
            $log = new Log();
            $logController = new LogController($log);

            $logController->read();
        } else {
            echo json_encode(["message" => "Hello, World"]);
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

        if(preg_match('/\/produtos\/(\d+)/', $uri, $match)){
            $id = $match[1];
            $data = json_decode(file_get_contents('php://input'));
            $controller->delete($id);
            break;
        } else {
            http_response_code(405); // Not allowed
        }
        break;
    default:
        echo "Hello";
}
