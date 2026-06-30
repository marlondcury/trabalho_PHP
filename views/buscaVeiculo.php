<?php include("menu.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos | Locadora Web</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header">
    <div class="container">
        <h1 class="fw-bold">Busca de Veículos</h1>
        <p class="mb-0 opacity-75">Pesquise pelo acervo disponível da locadora.</p>
    </div>
</section>

<div class="container py-5">
    <div class="card card-bloco p-4 p-md-5">
        <form action="../controllers/controllerVeiculo.php" method="GET">
            <input type="hidden" name="op" value="6">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Placa</label>
                    <input type="text" name="placa" class="form-control" placeholder="Ex: ABC1D23">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Ex: Civic">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fabricante</label>
                    <input type="text" name="fabricante" class="form-control" placeholder="Ex: Honda">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Motorização</label>
                    <input type="text" name="motorizacao" class="form-control" placeholder="Ex: 2.0">
                </div>
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" name="buscar" class="btn btn-primary btn-buscar">
                    Buscar
                </button>
                <a href="../index.php" class="btn btn-outline-secondary btn-buscar">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
