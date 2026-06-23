<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container py-2">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-white" href="/LocadoraWeb/views/index.php">
            <span>Locadora Web</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link text-dark" href="/LocadoraWeb/views/index.php">Início</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="/LocadoraWeb/views/empresa.php">Empresa</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="/LocadoraWeb/views/veiculos.php">Veículos</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="/LocadoraWeb/views/contato.php">Contato</a></li>
                
                <?php if(!isset($_SESSION['usuarioLogado'])): ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary rounded-pill px-4 fw-semibold ms-lg-2" href="/LocadoraWeb/views/login.php">
                            Login
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link text-primary fw-bold px-3" href="/LocadoraWeb/views/dashboard.php">Meu Painel</a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="btn btn-outline-danger rounded-pill px-4 fw-semibold ms-lg-2" href="/LocadoraWeb/controllers/controllerUsuario.php?acao=logout">
                            Sair
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>