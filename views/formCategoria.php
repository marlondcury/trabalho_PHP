<?php
session_start();
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/categoriaDAO.php';
$categoriaDao = new categoriaDao();

$modoEdicao = false;
$categoria = (object) ['id_categoria' => '', 'descricao' => '', 'valor' => ''];

if (isset($_GET['id_categoria'])) {
    $modoEdicao = true;
    $resultado = $categoriaDao->buscarPorId($_GET['id_categoria']);
    if ($resultado) {
        $categoria = $resultado;
    } else {
        header("Location: categorias.php");
        exit;
    }
}

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $modoEdicao ? 'Editar Categoria' : 'Nova Categoria' ?> | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0"><?= $modoEdicao ? 'Editar Categoria' : 'Cadastrar Nova Categoria' ?></h1>
        <p class="opacity-75">O valor informado é somado ao valor base do veículo na hora da locação.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-moderno p-4 p-md-5">

                <form action="../controllers/controllerCategoria.php" method="POST">
                    <input type="hidden" name="acao" value="<?= $modoEdicao ? 'editar' : 'novo' ?>">
                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id_categoria" value="<?= htmlspecialchars($categoria->id_categoria) ?>">
                    <?php endif; ?>

                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Descrição</label>
                            <input type="text" name="descricao" class="form-control" placeholder="Ex: SUV"
                                   maxlength="20" value="<?= htmlspecialchars($categoria->descricao) ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Valor adicional (R$)</label>
                            <input type="number" step="0.01" min="0" name="valor" class="form-control"
                                   placeholder="Ex: 200.00" value="<?= htmlspecialchars($categoria->valor) ?>" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="categorias.php" class="btn btn-outline-secondary btn-acao px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-acao px-4">
                            <?= $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Categoria' ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
