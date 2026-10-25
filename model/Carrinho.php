<?php
require_once('../config/conexao.php');

class Carrinho extends Conexao {
    private $id;
    private $id_usuario;
    private $id_produto;
    private $quantidade;
    private $tabela = 'carrinho';

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

    public function getIdProduto() {
        return $this->id_produto;
    }

    public function setIdProduto($id_produto) {
        $this->id_produto = $id_produto;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function consulta($id_usuario) {
        $sql = "SELECT c.id, c.id_usuario, c.id_produto, c.quantidade, p.nome, p.preco, (c.quantidade * p.preco) AS subtotal 
                FROM $this->tabela c 
                INNER JOIN produtos p ON c.id_produto = p.id 
                WHERE c.id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function consultaID($id) {
        $sql = "SELECT id, id_usuario, id_produto, quantidade FROM $this->tabela WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->setId($result['id']);
            $this->setIdUsuario($result['id_usuario']);
            $this->setIdProduto($result['id_produto']);
            $this->setQuantidade($result['quantidade']);
        }
        return $result;
    }

    public function inserir(Carrinho $carrinho) {
        try {
            $sql = "INSERT INTO $this->tabela (id_usuario, id_produto, quantidade) VALUES (:id_usuario, :id_produto, :quantidade)";
            $stmt = $this->conn->prepare($sql);

            $id_usuario = $carrinho->getIdUsuario();
            $id_produto = $carrinho->getIdProduto();
            $quantidade = $carrinho->getQuantidade();

            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() <= 0) {
                header('Location: ../view/carrinho.php?cadastro=erro');
                exit();
            }
        } catch (PDOException $e) {
            header('Location: ../view/carrinho.php?cadastro=erro');
            exit();
        }
    }

    public function editar(Carrinho $carrinho, $id) {
        $sql = "UPDATE $this->tabela SET quantidade = :quantidade WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $quantidade = $carrinho->getQuantidade();
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function excluir($id) {
        $sql = "DELETE FROM $this->tabela WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
