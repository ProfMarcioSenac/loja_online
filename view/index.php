<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $logado = isset($_SESSION['logado']) && $_SESSION['logado'] == true;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Online - Vitrine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-loja sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="index.php">
                <i class="fas fa-store text-info me-2"></i>LOJA ONLINE
            </a>
            <div class="d-flex align-items-center">
                <?php if ($logado) { ?>
                    <a href="perfil.php" class="btn btn-outline-light me-2"><i class="fas fa-user me-1"></i> Meu Perfil</a>
                    <a href="carrinho.php" class="btn btn-info text-dark fw-semibold me-2"><i class="fas fa-shopping-cart me-1"></i> Carrinho</a>
                    <a href="vendas.php" class="btn btn-outline-info me-3"><i class="fas fa-receipt me-1"></i> Minhas Compras</a>
                    <a href="#" onclick="confirmSair()" class="btn btn-danger"><i class="fas fa-sign-out-alt me-1"></i> Sair</a>
                <?php } else { ?>
                    <a href="login.php" id="login" class="btn btn-info text-dark fw-semibold px-4"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="container my-5 flex-grow-1">
        <div class="hero-banner d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold mb-2">Tecnologia e Informática</h1>
                <p class="mb-0 text-white-50 fs-5">Confira nosso catálogo completo de equipamentos e periféricos.</p>
            </div>
            <i class="fas fa-laptop-code fa-4x text-info opacity-50 d-none d-md-block"></i>
        </div>

        <div class="row g-4">
            <?php
                require_once('../controller/produtoController.php');
                $produto = new Produto();
                $consulta = $produto->consulta();

                foreach ($consulta as $linha) {
                    $id = $linha['id'];
                    $nome = $linha['nome'];
                    $descricao = $linha['descricao'];
                    $preco = number_format($linha['preco'], 2, ',', '.');
                    $imagem = $linha['imagem'];
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <a href="detalhes.php?id=<?php echo $id; ?>" id="produto<?php echo $id; ?>" class="text-decoration-none">
                    <div class="card card-produto shadow-sm h-100">
                        <div class="produto-img-wrapper">
                            <?php if (!empty($imagem)) { ?>
                                <img src="<?php echo htmlspecialchars($imagem); ?>" alt="<?php echo htmlspecialchars($nome); ?>">
                            <?php } else { ?>
                                <div class="placeholder-sem-foto">
                                    <i class="fas fa-camera"></i>
                                    <span>Sem Foto</span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <h5 class="card-title fw-bold text-dark mb-2"><?php echo $nome; ?></h5>
                                <p class="card-text text-muted small mb-3"><?php echo $descricao; ?></p>
                            </div>
                            <div class="pt-3 border-top">
                                <p class="preco-destaque mb-0">R$ <?php echo $preco; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>

    <footer class="bg-black text-white py-2 mt-auto border-top border-secondary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="small mb-0 text-white-50"><i class="fas fa-store text-info me-1"></i> &copy; <?php echo date('Y'); ?> Loja Online. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="admin/index.php" class="text-decoration-none text-white-50 small">
                        <i class="fas fa-lock me-1"></i> Acesso Admin
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php
        if (isset($_GET['logado']) && $_GET['logado'] == 'true') {
            echo "<script src='js/logado.js'></script>";
        }
        if (isset($_GET['user']) && $_GET['user'] == 'deslogado') {
            echo "<script src='js/deslogado.js'></script>";
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