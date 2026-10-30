<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $logado = isset($_SESSION['logado']) && $_SESSION['logado'] == true;

    require_once('../controller/produtoController.php');
    $id_produto = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    $produtoObj = new Produto();
    $consulta = $produtoObj->consulta();
    
    $produtoEncontrado = null;
    foreach ($consulta as $p) {
        if ($p['id'] == $id_produto) {
            $produtoEncontrado = $p;
            break;
        }
    }

    if (!$produtoEncontrado) {
        header("Location: index.php");
        exit;
    }

    $nome = $produtoEncontrado['nome'];
    $descricao = $produtoEncontrado['descricao'];
    $preco = number_format($produtoEncontrado['preco'], 2, ',', '.');
    $imagem = $produtoEncontrado['imagem'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nome); ?> - Loja Online</title>
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
                    <a href="login.php" class="btn btn-info text-dark fw-semibold px-4"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="container my-5 flex-grow-1">
        <div class="mb-4">
            <a href="index.php" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Voltar para a Vitrine
            </a>
        </div>

        <div class="row g-5 align-items-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-3 text-center bg-light">
                    <?php if (!empty($imagem)) { ?>
                        <img src="<?php echo htmlspecialchars($imagem); ?>" alt="<?php echo htmlspecialchars($nome); ?>" class="img-fluid rounded" style="max-height: 450px; object-fit: contain;">
                    <?php } else { ?>
                        <div class="py-5 text-muted">
                            <i class="fas fa-camera fa-4x mb-3"></i>
                            <p>Sem Foto Disponível</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="fw-bold mb-3"><?php echo htmlspecialchars($nome); ?></h1>
                <h3 class="text-success fw-bold mb-4">R$ <?php echo $preco; ?></h3>
                <p class="text-muted fs-6 mb-4"><?php echo nl2br(htmlspecialchars($descricao)); ?></p>

                <div class="card border-0 shadow-sm p-4 bg-white">
                    <?php if ($logado) { ?>
                        <form method="post" action="../controller/carrinhoController.php?action=cadastrarCarrinho">
                            <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Quantidade:</label>
                                <input type="number" name="quantidade" class="form-control text-center w-50" value="1" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                                <i class="fas fa-cart-plus me-2"></i> Adicionar ao Carrinho
                            </button>
                        </form>
                    <?php } else { ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Quantidade:</label>
                            <input type="number" class="form-control text-center w-50" value="1" min="1" readonly>
                        </div>
                        <button type="button" onclick="alertaPrecisaLogar()" class="btn btn-primary btn-lg w-100 fw-semibold">
                            <i class="fas fa-cart-plus me-2"></i> Adicionar ao Carrinho
                        </button>
                    <?php } ?>
                </div>
            </div>
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
    <script>
        function alertaPrecisaLogar() {
            Swal.fire({
                title: "Atenção!",
                text: "Você precisa estar logado para adicionar produtos ao carrinho!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#0d6efd",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ir para o Login",
                cancelButtonText: "Continuar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "login.php";
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