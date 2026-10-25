<?php
require_once('../model/Venda.php');
require_once('../model/Carrinho.php');

class vendaController {

    public function consultar($id_usuario) {
        $vendaModel = new Venda();
        $result = $vendaModel->consulta($id_usuario);
        return $result;
    }

    public function finalizarCompra($id_usuario) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $carrinhoModel = new Carrinho();
            $itens = $carrinhoModel->consulta($id_usuario);

            if (count($itens) == 0) {
                header("Location: ../view/carrinho.php?erro");
                exit();
            }

            $vendaModel = new Venda();
            foreach ($itens as $item) {
                $venda = new Venda();
                $venda->setIdUsuario($id_usuario);
                $venda->setIdProduto($item['id_produto']);
                $venda->setQuantidade($item['quantidade']);
                $venda->setValorTotal($item['subtotal']);
                $vendaModel->inserir($venda);
                $carrinhoModel->excluir($item['id']);
            }

            header('Location: ../view/vendas.php?cadastro=ok');
            exit();
        } else {
            header("Location: ../view/carrinho.php?erro");
            exit();
        }
    }

    public function handleRequest() {
        if (isset($_GET['action']) && $_GET['action'] == 'cadastrarVenda') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->finalizarCompra($_SESSION['id_usuario']);
        }
    }
}

$VendaController = new vendaController();
$VendaController->handleRequest();
?>
