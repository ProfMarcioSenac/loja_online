<?php
require_once('../model/Usuario.php');

class usuarioController {

    public function logar() {
        $usuario = new Usuario();

        $user = $_POST['usuario'];
        $senha = $_POST['senha'];
        $senha = hash('sha256', $senha);
        $usuario->logar($user, $senha);
    }

    public function sair() {
        session_start();
        session_destroy();
        header('Location: ../view/index.php?user=deslogado');
        exit();
    }

    public function handleRequest() {
        if (isset($_GET['action']) && $_GET['action'] == 'logar') {
            $this->logar();
        }
        if (isset($_GET['action']) && $_GET['action'] == 'sair') {
            $this->sair();
        }
    }
}

$UsuarioController = new usuarioController();
$UsuarioController->handleRequest();
?>
