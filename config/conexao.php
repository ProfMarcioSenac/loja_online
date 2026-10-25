<?php
abstract class Conexao {
    private $servidor = 'localhost';
    private $user = 'publico';
    private $pass = 'publico';
    private $banco = 'loja_online';
    protected $conn;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
            $this->user = 'cliente';
            $this->pass = 'cliente';
        } else {
            $this->user = 'publico';
            $this->pass = 'publico';
        }
        $this->conexao();
    }

    private function conexao() {
        $this->conn = new PDO("mysql:host=$this->servidor;dbname=$this->banco", $this->user, $this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
?>
