<?php
    session_start();
    if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras - Loja Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-loja sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="index.php">
                <i class="fas fa-store text-info me-2"></i>LOJA ONLINE
            </a>
            <div class="d-flex align-items-center">
                <a href="index.php" class="btn btn-outline-light me-2"><i class="fas fa-th-large me-1"></i> Vitrine</a>
                <a href="perfil.php" class="btn btn-outline-light me-2"><i class="fas fa-user me-1"></i> Meu Perfil</a>
                <a href="carrinho.php" class="btn btn-info text-dark fw-semibold me-3"><i class="fas fa-shopping-cart me-1"></i> Carrinho</a>
                <a href="#" onclick="confirmSair()" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Sair</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="painel-box">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h2 class="fw-bold m-0"><i class="fas fa-receipt text-success me-2"></i>Histórico de Compras</h2>
                <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Voltar à Vitrine</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>PEDIDO</th>
                            <th>PRODUTO</th>
                            <th>QUANTIDADE</th>
                            <th>VALOR TOTAL</th>
                            <th>DATA DA COMPRA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require_once('../controller/vendaController.php');
                            $venda = new Venda();
                            $consulta = $venda->consulta($_SESSION['id_usuario']);

                            foreach ($consulta as $linha) {
                                $id = $linha['id'];
                                $nome = $linha['nome'];
                                $quantidade = $linha['quantidade'];
                                $valor_total = number_format($linha['valor_total'], 2, ',', '.');
                                $data = $linha['data_criado'];

                                echo "
                                <tr>
                                    <td>#$id</td>
                                    <td class='fw-semibold'>$nome</td>
                                    <td>$quantidade</td>
                                    <td class='fw-bold text-success'>R$ $valor_total</td>
                                    <td class='text-muted'>$data</td>
                                </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php
        if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'ok') {
            echo "<script src='js/cadastro.js'></script>";
        }
        if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'erro') {
            echo "<script src='js/cadastro-erro.js'></script>";
        }
    ?>
    <script>
        function confirmSair() {
            Swal.fire({
                title: "DESLOGAR!",
                text: "VOCÊ TEM CERTEZA?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#060",
                cancelButtonColor: "#aaa",
                cancelButtonText: "Não Deslogar!",
                confirmButtonText: "Deslogar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `../controller/usuarioController.php?action=sair`;
                }
            });
        }
    </script>
</body>
</html>
<?php
    } else {
        header('Location: index.php');
        exit();
    }
?>
