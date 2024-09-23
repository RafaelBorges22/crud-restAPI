<?php
require "../../vendor/autoload.php";

use App\Controller\ProdutoController;
use App\Model\Produto;

$produto = new Produto();
$controller = new ProdutoController($produto);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents("php://input"));

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $controller->create($data);
        break;
    default:
        echo "Hello";
}