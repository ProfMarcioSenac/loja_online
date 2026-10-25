<?php
    session_start();
    if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho - Loja Online</title>
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
                <a href="vendas.php" class="btn btn-outline-info me-3"><i class="fas fa-receipt me-1"></i> Minhas Compras</a>
                <a href="#" onclick="confirmSair()" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Sair</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="painel-box">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h2 class="fw-bold m-0"><i class="fas fa-shopping-cart text-primary me-2"></i>Meu Carrinho de Compras</h2>
                <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Continuar Comprando</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>PRODUTO</th>
                            <th>PREÇO UNIT.</th>
                            <th style="width: 200px;">QUANTIDADE</th>
                            <th>SUBTOTAL</th>
                            <th class="text-center">REMOVER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require_once('../controller/carrinhoController.php');
                            $carrinho = new Carrinho();
                            $consulta = $carrinho->consulta($_SESSION['id_usuario']);
                            $totalGeral = 0;

                            foreach ($consulta as $linha) {
                                $id = $linha['id'];
                                $nome = $linha['nome'];
                                $preco = number_format($linha['preco'], 2, ',', '.');
                                $quantidade = $linha['quantidade'];
                                $subtotal = number_format($linha['subtotal'], 2, ',', '.');
                                $totalGeral += $linha['subtotal'];
                        ?>
                        <tr>
                            <td>#<?php echo $id; ?></td>
                            <td class="fw-semibold"><?php echo $nome; ?></td>
                            <td>R$ <?php echo $preco; ?></td>
                            <td>
                                <form method="post" action="../controller/carrinhoController.php?action=editarCarrinho" class="d-flex">
                                    <input type="hidden" name="meuid" value="<?php echo $id; ?>">
                                    <input type="number" name="quantidade" value="<?php echo $quantidade; ?>" min="1" class="form-control form-control-sm text-center me-2" required>
                                    <button type="submit" class="btn btn-success btn-sm" title="Atualizar Quantidade"><i class="fas fa-sync-alt"></i></button>
                                </form>
                            </td>
                            <td class="fw-bold text-dark">R$ <?php echo $subtotal; ?></td>
                            <td class="text-center">
                                <a class="btn btn-outline-danger btn-sm" id="excluir<?php echo $id; ?>" onclick="confirmDelete(<?php echo $id; ?>)" href="#"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="4" class="text-end fw-bold fs-5">TOTAL DO PEDIDO:</td>
                            <td colspan="2" class="fw-bold fs-4 text-success">R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?php if ($totalGeral > 0) { ?>
                <div class="d-flex justify-content-end mt-4">
                    <form method="post" action="../controller/vendaController.php?action=cadastrarVenda">
                        <button type="submit" class="btn btn-success btn-lg px-5 fw-bold">
                            <i class="fas fa-check-circle me-2"></i>Finalizar Compra
                        </button>
                    </form>
                </div>
            <?php } ?>
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
        if (isset($_GET['edit']) && $_GET['edit'] == 'ok') {
            echo "<script src='js/editado.js'></script>";
        }
        if (isset($_GET['delete']) && $_GET['delete'] == 'ok') {
            echo "<script src='js/excluido.js'></script>";
        }
    ?>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Não será possível reverter essa ação!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#c00",
                cancelButtonColor: "#aaa",
                cancelButtonText: "Cancelar!",
                confirmButtonText: "Apagar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `../controller/carrinhoController.php?id=${id}&action=excluirCarrinho`;
                }
            });
        }

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
