<?php
require_once('../model/Perfil.php');

class perfilController {

    public function inserir(Perfil $perfil) {
        if (strlen($perfil->getNome()) == 0 || strlen($perfil->getFone()) == 0 || strlen($perfil->getEmail()) == 0 || strlen($perfil->getEndereco()) == 0) {
            header("Location: ../view/perfil.php?campoVazio");
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $perfilModel = new Perfil();
            $perfilModel->inserir($perfil);
            header('Location: ../view/perfil.php?cadastro=ok');
            exit();
        } else {
            header("Location: ../view/perfil.php?cadastro=erro");
            exit();
        }
    }

    public function editar(Perfil $perfil) {
        if (strlen($perfil->getNome()) == 0 || strlen($perfil->getFone()) == 0 || strlen($perfil->getEmail()) == 0 || strlen($perfil->getEndereco()) == 0) {
            header("Location: ../view/perfil.php?campoVazio");
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $perfilModel = new Perfil();
            $perfilModel->editar($perfil, $perfil->getIdUsuario());
            header("Location: ../view/perfil.php?edit=ok");
            exit();
        } else {
            header("Location: ../view/perfil.php?erro=erro");
            exit();
        }
    }

    public function handleRequest() {
        if (isset($_GET['action']) && $_GET['action'] == 'cadastrarPerfil') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $perfil = new Perfil();
            $perfil->setIdUsuario($_SESSION['id_usuario']);
            $perfil->setNome($_POST['nome']);
            $perfil->setFone($_POST['fone']);
            $perfil->setEmail($_POST['email']);
            $perfil->setEndereco($_POST['endereco']);
            $this->inserir($perfil);
        }
        if (isset($_GET['action']) && $_GET['action'] == 'editarPerfil') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $perfil = new Perfil();
            $perfil->setIdUsuario($_SESSION['id_usuario']);
            $perfil->setNome($_POST['nome']);
            $perfil->setFone($_POST['fone']);
            $perfil->setEmail($_POST['email']);
            $perfil->setEndereco($_POST['endereco']);
            $this->editar($perfil);
        }
    }
}

$PerfilController = new perfilController();
$PerfilController->handleRequest();
?>
