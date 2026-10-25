<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login - Loja Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-loja py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="index.php">
                <i class="fas fa-store text-info me-2"></i>LOJA ONLINE
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="card card-login bg-white">
            <div class="bg-dark text-white text-center py-4">
                <i class="fas fa-user-circle fa-3x text-info mb-2"></i>
                <h4 class="mb-0 fw-bold">Acesso do Cliente</h4>
            </div>
            <div class="card-body p-4">
                <form method="post" action="../controller/usuarioController.php?action=logar">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">USUÁRIO</label>
                        <input required type="text" name="usuario" id="usuario" class="form-control form-control-lg" placeholder="Digite seu usuário">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-semibold">SENHA</label>
                        <input required type="password" name="senha" id="senha" class="form-control form-control-lg" placeholder="Digite sua senha">
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary btn-lg w-100 fw-semibold mb-3">Entrar</button>
                    <a href="index.php" class="btn btn-outline-secondary w-100">Voltar para a Vitrine</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php
        if (isset($_GET['erro']) && $_GET['erro'] == 'login') {
            echo "<script src='js/erro-login.js'></script>";
        }
    ?>
</body>
</html>
