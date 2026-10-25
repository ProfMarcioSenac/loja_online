<?php
    session_start();
    if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Loja Online</title>
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
                <a href="carrinho.php" class="btn btn-info text-dark fw-semibold me-2"><i class="fas fa-shopping-cart me-1"></i> Carrinho</a>
                <a href="vendas.php" class="btn btn-outline-info me-3"><i class="fas fa-receipt me-1"></i> Minhas Compras</a>
                <a href="#" onclick="confirmSair()" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Sair</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="painel-box">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h2 class="fw-bold m-0"><i class="fas fa-id-card text-primary me-2"></i>Meus Dados de Perfil</h2>
                <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Voltar para a Loja</a>
            </div>

            <div class="row g-5">
                <div class="col-md-6 border-end">
                    <h5 class="fw-bold text-primary mb-3">Cadastrar Meu Perfil (Cadastro Único)</h5>
                    <form method="post" action="../controller/perfilController.php?action=cadastrarPerfil">
                        <div class="mb-3">
                            <input required type="text" name="nome" class="form-control" placeholder="Nome Completo">
                        </div>
                        <div class="mb-3">
                            <input required type="text" name="fone" class="form-control" placeholder="Telefone">
                        </div>
                        <div class="mb-3">
                            <input required type="email" name="email" class="form-control" placeholder="E-mail">
                        </div>
                        <div class="mb-3">
                            <input required type="text" name="endereco" class="form-control" placeholder="Endereço de Entrega">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">Salvar Perfil</button>
                    </form>
                </div>

                <div class="col-md-6">
                    <h5 class="fw-bold text-success mb-3">Atualizar Meu Perfil</h5>
                    <form method="post" action="../controller/perfilController.php?action=editarPerfil">
                        <div class="mb-3">
                            <input required type="text" name="nome" class="form-control" placeholder="Novo Nome Completo">
                        </div>
                        <div class="mb-3">
                            <input required type="text" name="fone" class="form-control" placeholder="Novo Telefone">
                        </div>
                        <div class="mb-3">
                            <input required type="email" name="email" class="form-control" placeholder="Novo E-mail">
                        </div>
                        <div class="mb-3">
                            <input required type="text" name="endereco" class="form-control" placeholder="Novo Endereço de Entrega">
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-semibold">Atualizar Dados</button>
                    </form>
                </div>
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
        if (isset($_GET['edit']) && $_GET['edit'] == 'ok') {
            echo "<script src='js/editado.js'></script>";
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
