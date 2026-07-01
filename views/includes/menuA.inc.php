<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container py-2">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark" href="/LocadoraWeb/views/index.php">
            <span>Locadora Web <small class="text-danger fs-6">(Admin)</small></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuAdm">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuAdm">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link text-dark" href="/LocadoraWeb/views/buscaVeiculo.php">Gerenciar Veículos</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="/LocadoraWeb/views/locacoes.php">Controle de Locações</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="/LocadoraWeb/views/clientes.php">Clientes Cadastrados</a></li>
                
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link text-primary fw-bold px-3" href="/LocadoraWeb/views/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <a class="btn btn-outline-danger rounded-pill px-4 fw-semibold ms-lg-2" href="/LocadoraWeb/controllers/controllerUsuario.php?acao=logout">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>