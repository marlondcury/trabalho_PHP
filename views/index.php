<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locadora Web fsdfsdfd</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/LocadoraWeb/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container py-2">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <span style="font-size:1.5rem;">🚗</span>
            <span>Locadora Web</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/LocadoraWeb/views/empresa.php"">Empresa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="veiculos.php">Veículos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contato.php">Fale Conosco</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-light btn-sm px-4 rounded-pill fw-semibold ms-lg-2" href="login.php">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge-info mb-4 d-inline-block">Bem-vindo à melhor experiência em locação</span>
                <h1>Encontre o veículo ideal para cada momento.</h1>
                <p class="mt-4 mb-4">
                    Uma locadora moderna, com visual elegante, sistema organizado e acesso rápido aos veículos
                    disponíveis para clientes e administradores.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="veiculos.php" class="btn btn-primary btn-acao">
                        Ver veículos
                    </a>
                    <a href="login.php" class="btn btn-outline-light btn-acao">
                        Acessar sistema
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="container secao">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Por que escolher nossa locadora?</h2>
        <p class="text-muted">Um sistema pensado para simplicidade, conforto e organização.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-moderno h-100 p-4">
                <div class="icone-card">🚘</div>
                <h4 class="fw-semibold">Frota variada</h4>
                <p class="text-muted mb-0">
                    Carros, categorias e exemplares organizados para facilitar a busca e a escolha do cliente.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-moderno h-100 p-4">
                <div class="icone-card">🔎</div>
                <h4 class="fw-semibold">Busca rápida</h4>
                <p class="text-muted mb-0">
                    Pesquisa por placa, nome, fabricante e motorização com acesso fácil e direto.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-moderno h-100 p-4">
                <div class="icone-card">👤</div>
                <h4 class="fw-semibold">Perfis de acesso</h4>
                <p class="text-muted mb-0">
                    Cada usuário visualiza apenas as opções da sua área: público, cliente ou administrador.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="container pb-5">
    <div class="destaque">
        <div class="row g-0">
            <div class="col-lg-6 p-5">
                <h3 class="fw-bold mb-3">Área do cliente</h3>
                <p class="text-muted">
                    Consulte seus dados, visualize locações abertas e concluídas, e alugue veículos disponíveis.
                </p>
                <ul class="text-muted">
                    <li>Alteração cadastral</li>
                    <li>Consulta de locações</li>
                    <li>Busca no acervo</li>
                </ul>
            </div>

            <div class="col-lg-6 p-5 bg-primary text-white">
                <h3 class="fw-bold mb-3">Área administrativa</h3>
                <p class="mb-0">
                    Gerencie veículos, categorias, exemplares e consulte locações por período com visual limpo e
                    profissional.
                </p>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container text-center">
        <p class="mb-1 fw-semibold">Locadora Web</p>
        <small>Projeto acadêmico — sistema de locação de veículos</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>