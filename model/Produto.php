<?php
require_once('../config/conexao.php');

class Produto extends Conexao {
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $imagem;
    private $tabela = 'produtos';

    public function __construct() {
        parent::__construct();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function consulta() {
        $sql = "SELECT id, nome, descricao, preco, imagem FROM $this->tabela";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function consultaID($id) {
        $sql = "SELECT id, nome, descricao, preco, imagem FROM $this->tabela WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->setId($result['id']);
            $this->setNome($result['nome']);
            $this->setDescricao($result['descricao']);
            $this->setPreco($result['preco']);
            $this->setImagem($result['imagem']);
        }
        return $result;
    }
}
?>
