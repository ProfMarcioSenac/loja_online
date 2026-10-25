<?php
require_once('../config/conexao.php');

class Usuario extends Conexao {
    private $id_usuario;
    private $usuario;
    private $senha;
    private $tabela = 'usuarios';

    public function __construct() {
        parent::__construct();
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function logar($usuario, $senha) {
        $sql = "SELECT id_usuario, usuario, senha FROM $this->tabela WHERE usuario = :usuario AND senha = :senha";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['logado'] = true;
            $_SESSION['id_usuario'] = $result['id_usuario'];
            $_SESSION['usuario'] = $result['usuario'];
            header('Location: ../view/index.php?logado=true');
            exit();
        } else {
            header('Location: ../view/login.php?erro=login');
            exit();
        }
    }
}
?>
