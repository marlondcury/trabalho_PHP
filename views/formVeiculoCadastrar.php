<?php
require_once '../classes/categoria.php';
require_once '../dao/categoriaDAO.php';

$categoriaDao = new categoriaDao();
$categorias = $categoriaDao->getCategorias();

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Veículo | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header">
    <div class="container">
        <h1 class="fw-bold">Cadastrar Veículo</h1>
        <p class="mb-0 opacity-75">Preencha os dados do novo veículo.</p>
    </div>
</section>

<div class="container py-5">
    <div class="card card-bloco p-4 p-md-5">
        <form action="../controllers/controllerVeiculo.php" method="POST">
            <input type="hidden" name="op" value="1">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Placa</label>
                    <input type="text" name="placa" class="form-control" placeholder="Ex: ABC1D23" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Ex: Civic" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fabricante</label>
                    <input type="text" name="fabricante" class="form-control" placeholder="Ex: Honda" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Ano de Fabricação</label>
                    <input type="number" name="anoFabricacao" class="form-control" placeholder="Ex: 2022" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Motorização</label>
                    <input type="text" name="motorizacao" class="form-control" placeholder="Ex: 2.0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Valor Base (R$)</label>
                    <input type="number" step="0.01" name="valorBase" class="form-control" placeholder="Ex: 150.00" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Opcionais</label>
                    <input type="text" name="opcionais" class="form-control" placeholder="Ex: Ar condicionado, Direção hidráulica">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoria</label>
                    <select name="id_categoria" class="form-select" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $cat){?>
                            <option value="<?php echo $cat->id_categoria; ?>">
                                <?php echo $cat->descricao; ?> — R$ <?php echo number_format($cat->valor, 2, ',', '.'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="../index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
</body>
</html>