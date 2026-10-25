<?php
require_once('../config/conexao.php');

class Venda extends Conexao {
    private $id;
    private $id_usuario;
    private $id_produto;
    private $quantidade;
    private $valor_total;
    private $tabela = 'vendas';

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

    public function getValorTotal() {
        return $this->valor_total;
    }

    public function setValorTotal($valor_total) {
        $this->valor_total = $valor_total;
    }

    public function consulta($id_usuario) {
        $sql = "SELECT v.id, v.id_usuario, v.id_produto, v.quantidade, v.valor_total, v.data_criado, p.nome 
                FROM $this->tabela v 
                INNER JOIN produtos p ON v.id_produto = p.id 
                WHERE v.id_usuario = :id_usuario 
                ORDER BY v.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function inserir(Venda $venda) {
        try {
            $sql = "INSERT INTO $this->tabela (id_usuario, id_produto, quantidade, valor_total) VALUES (:id_usuario, :id_produto, :quantidade, :valor_total)";
            $stmt = $this->conn->prepare($sql);

            $id_usuario = $venda->getIdUsuario();
            $id_produto = $venda->getIdProduto();
            $quantidade = $venda->getQuantidade();
            $valor_total = $venda->getValorTotal();

            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt->bindParam(':valor_total', $valor_total, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() <= 0) {
                header('Location: ../view/vendas.php?cadastro=erro');
                exit();
            }
        } catch (PDOException $e) {
            header('Location: ../view/vendas.php?cadastro=erro');
            exit();
        }
    }
}
?>
