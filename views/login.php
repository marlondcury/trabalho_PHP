<?php include("menu.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Locadora Web</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body class="pagina-login">

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-lg-5 col-md-7">
            <div class="card login-box">
                <div class="login-header text-center">
                    <h2 class="fw-bold mb-1">Acesso ao Sistema</h2>
                    <p class="mb-0 opacity-75">Entre com seu login e senha</p>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="../controllers/controllerUsuario.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Usuário</label>
                            <input type="text" name="login" class="form-control" placeholder="Digite seu usuário">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="Digite sua senha">
                        </div>

                        <button type="submit" name="entrar" class="btn btn-primary w-100 btn-login">
                            Entrar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
