<?php 
// 1. Inicia a sessão para podermos acessar os dados
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Trava de Segurança: Se não existir ninguém logado na sessão, redireciona para o login
if (!isset($_SESSION['usuarioLogado'])) {
    header("Location: login.php");
    exit; // Para a execução da página aqui mesmo
}

// 3. Resgata os dados da sessão e passa para as variáveis que o seu HTML já está usando
$usuarioLogado = $_SESSION['usuarioLogado'];
$perfil = $_SESSION['perfil'];

// 4. Agora sim, inclui o menu e carrega o resto da página
include("menu.php"); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocadoraWeb/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold">Olá, <?php echo htmlspecialchars($usuarioLogado['user']); ?>!</h1>
        <p class="mb-0 opacity-75">Bem-vindo ao seu painel de controle.</p>
    </div>
</section>

<div class="container py-5">

    <?php if ($perfil == 'A'): ?>
        
        <h3 class="fw-bold mb-4">Visão Geral - Administração</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-moderno h-100 p-4">
                    <div class="icone-card bg-danger">🚘</div>
                    <h4 class="fw-semibold">Gerenciar Veículos</h4>
                    <p class="text-muted mb-3">Adicione, edite ou remova veículos da frota.</p>
                    <a href="veiculos.php" class="btn btn-outline-primary mt-auto">Acessar</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-moderno h-100 p-4">
                    <div class="icone-card bg-success">📝</div>
                    <h4 class="fw-semibold">Locações</h4>
                    <p class="text-muted mb-3">Controle de reservas e devoluções.</p>
                    <a href="locacoes.php" class="btn btn-outline-primary mt-auto">Ver Locações</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-moderno h-100 p-4">
                    <div class="icone-card bg-warning">👥</div>
                    <h4 class="fw-semibold">Clientes</h4>
                    <p class="text-muted mb-3">Gerenciamento de usuários cadastrados.</p>
                    <a href="clientes.php" class="btn btn-outline-primary mt-auto">Ver Clientes</a>
                </div>
            </div>
        </div>

    <?php else: ?>
        
        <h3 class="fw-bold mb-4">Minha Área</h3>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card card-moderno h-100 p-4">
                    <div class="icone-card">🔍</div>
                    <h4 class="fw-semibold">Alugar um Veículo</h4>
                    <p class="text-muted mb-3">Busque no nosso acervo e faça sua reserva agora mesmo.</p>
                    <a href="buscaVeiculo.php" class="btn btn-primary mt-auto">Buscar Veículos</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-moderno h-100 p-4">
                    <div class="icone-card">📅</div>
                    <h4 class="fw-semibold">Minhas Locações</h4>
                    <p class="text-muted mb-3">Veja o histórico dos carros que você alugou e prazos de devolução.</p>
                    <a href="minhasLocacoes.php" class="btn btn-outline-primary mt-auto">Histórico</a>
                </div>
            </div>
        </div>
        
    <?php endif; ?>

</div>

<?php require_once "includes/rodape.inc.php" ?>
