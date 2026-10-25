<?php
require_once('../config/conexao.php');

class Perfil extends Conexao {
    private $id;
    private $id_usuario;
    private $nome;
    private $fone;
    private $email;
    private $endereco;
    private $tabela = 'perfil';

    public function __construct() {
        parent::__construct();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getFone() {
        return $this->fone;
    }

    public function setFone($fone) {
        $this->fone = $fone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function inserir(Perfil $perfil) {
        try {
            $sql = "INSERT INTO $this->tabela (id_usuario, nome, fone, email, endereco) VALUES (:id_usuario, :nome, :fone, :email, :endereco)";
            $stmt = $this->conn->prepare($sql);

            $id_usuario = $perfil->getIdUsuario();
            $nome = $perfil->getNome();
            $fone = $perfil->getFone();
            $email = $perfil->getEmail();
            $endereco = $perfil->getEndereco();

            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':fone', $fone, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                header('Location: ../view/perfil.php?cadastro=ok');
                exit();
            } else {
                header('Location: ../view/perfil.php?cadastro=erro');
                exit();
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                header('Location: ../view/perfil.php?cadastro=erro');
                exit();
            } else {
                header('Location: ../view/perfil.php?cadastro=erro');
                exit();
            }
        }
    }

    public function editar(Perfil $perfil, $id_usuario) {
        try {
            $sql = "UPDATE $this->tabela SET nome = :nome, fone = :fone, email = :email, endereco = :endereco WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($sql);

            $nome = $perfil->getNome();
            $fone = $perfil->getFone();
            $email = $perfil->getEmail();
            $endereco = $perfil->getEndereco();

            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':fone', $fone, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            header('Location: ../view/perfil.php?cadastro=erro');
            exit();
        }
    }
}
?>
