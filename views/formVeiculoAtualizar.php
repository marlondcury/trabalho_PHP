<?php
require_once '../classes/veiculo.php';
require_once '../classes/categoria.php';
require_once '../dao/categoriaDAO.php';
session_start();

$veiculo = $_SESSION['veiculo'] ?? null;

if (!$veiculo) {
    header("Location: ../views/buscaVeiculo.php");
    exit;
}

$categoriaDao = new categoriaDao();
$categorias = $categoriaDao->getCategorias();

unset($_SESSION['veiculo']);

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Veículo | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header">
    <div class="container">
        <h1 class="fw-bold">Editar Veículo</h1>
        <p class="mb-0 opacity-75">Altere os dados do veículo.</p>
    </div>
</section>

<div class="container py-5">
    <div class="card card-bloco p-4 p-md-5">
        <form action="../controllers/controllerVeiculo.php" method="POST">
            <input type="hidden" name="op" value="5">
            <input type="hidden" name="veiculo_id" value="<?php echo $veiculo->getVeiculoId(); ?>">
            <input type="hidden" name="placa" value="<?php echo $veiculo->getPlaca(); ?>">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Placa</label>
                    <!-- Desabilitada pois não se altera placa -->
                    <input type="text" class="form-control" value="<?php echo $veiculo->getPlaca(); ?>" disabled>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nome</label>
                    <input type="text" name="nome" class="form-control" value="<?php echo $veiculo->getNome(); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fabricante</label>
                    <input type="text" name="fabricante" class="form-control" value="<?php echo $veiculo->getFabricante(); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Ano de Fabricação</label>
                    <input type="number" name="anoFabricacao" class="form-control" value="<?php echo $veiculo->getAnoFabricacao(); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Motorização</label>
                    <input type="text" name="motorizacao" class="form-control" value="<?php echo $veiculo->getMotorizacao(); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Valor Base (R$)</label>
                    <input type="number" step="0.01" name="valorBase" class="form-control" value="<?php echo $veiculo->getValorBase(); ?>" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Opcionais</label>
                    <input type="text" name="opcionais" class="form-control" value="<?php echo $veiculo->getOpcionais(); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Categoria</label>
                    <select name="id_categoria" class="form-select" required>
                        <?php foreach ($categorias as $cat){ ?>
                            <option value="<?php echo $cat->id_categoria; ?>"
                                <?php echo ($cat->id_categoria == $veiculo->getIdCategoria()) ? 'selected' : ''; ?>>
                                <?php echo $cat->descricao; ?> — R$ <?php echo number_format($cat->valor, 2, ',', '.'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                <a href="buscaVeiculo.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
</body>
</html>