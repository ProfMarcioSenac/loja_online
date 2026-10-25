<?php
require_once('../model/Produto.php');

class produtoController {

    public function consultar() {
        $produtoModel = new Produto();
        $result = $produtoModel->consulta();
        return $result;
    }

    public function consultaID($id) {
        $produtoModel = new Produto();
        $result = $produtoModel->consultaID($id);
        return $result;
    }

    public function handleRequest() {
    }
}

$ProdutoController = new produtoController();
$ProdutoController->handleRequest();
?>
