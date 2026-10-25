<?php
require_once('../model/Carrinho.php');

class carrinhoController {

    public function consultar($id_usuario) {
        $carrinhoModel = new Carrinho();
        $result = $carrinhoModel->consulta($id_usuario);
        return $result;
    }

    public function consultaID($id) {
        $carrinhoModel = new Carrinho();
        $result = $carrinhoModel->consultaID($id);
        return $result;
    }

    public function inserir(Carrinho $carrinho) {
        if (strlen($carrinho->getIdProduto()) == 0 || strlen($carrinho->getQuantidade()) == 0) {
            header("Location: ../view/carrinho.php?campoVazio");
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $carrinhoModel = new Carrinho();
            $carrinhoModel->inserir($carrinho);
            header('Location: ../view/carrinho.php?cadastro=ok');
            exit();
        } else {
            header("Location: ../view/carrinho.php?erro");
            exit();
        }
    }

    public function editar(Carrinho $carrinho) {
        if (strlen($carrinho->getQuantidade()) == 0 || $carrinho->getQuantidade() <= 0) {
            header("Location: ../view/carrinho.php?campoVazio");
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $carrinhoModel = new Carrinho();
            $carrinhoModel->editar($carrinho, $carrinho->getId());
            header("Location: ../view/carrinho.php?edit=ok");
            exit();
        } else {
            header("Location: ../view/carrinho.php?erro=erro");
            exit();
        }
    }

    public function excluir($id) {
        $carrinhoModel = new Carrinho();
        $carrinhoModel->excluir($id);
        header("Location: ../view/carrinho.php?delete=ok");
        exit();
    }

    public function handleRequest() {
        if (isset($_GET['action']) && $_GET['action'] == 'cadastrarCarrinho') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $carrinho = new Carrinho();
            $carrinho->setIdUsuario($_SESSION['id_usuario']);
            $carrinho->setIdProduto($_POST['id_produto']);
            $carrinho->setQuantidade($_POST['quantidade']);
            $this->inserir($carrinho);
        }
        if (isset($_GET['action']) && $_GET['action'] == 'editarCarrinho') {
            $carrinho = new Carrinho();
            $carrinho->setId($_POST['meuid']);
            $carrinho->setQuantidade($_POST['quantidade']);
            $this->editar($carrinho);
        }
        if (isset($_GET['action']) && $_GET['action'] == 'excluirCarrinho') {
            $this->excluir($_GET['id']);
        }
    }
}

$CarrinhoController = new carrinhoController();
$CarrinhoController->handleRequest();
?>
