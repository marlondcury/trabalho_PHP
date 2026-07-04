<?php
session_start();
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/categoriaDAO.php';
$categoriaDao = new categoriaDao();
$categorias = $categoriaDao->getCategorias();

$erro = $_SESSION['erroCategoria'] ?? null;
unset($_SESSION['erroCategoria']);

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Categorias</h1>
        <p class="opacity-75">Gerencie as categorias de veículos e seus valores adicionais.</p>
    </div>
</section>

<div class="container py-5">

    <?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">Lista de Categorias</h3>
        <a href="formCategoria.php" class="btn btn-primary btn-acao">+ Nova Categoria</a>
    </div>

    <div class="card card-moderno p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary py-3">ID</th>
                        <th class="text-secondary py-3">Descrição</th>
                        <th class="text-secondary py-3">Valor adicional (R$)</th>
                        <th class="text-secondary text-center py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($categorias) > 0): ?>
                        <?php foreach ($categorias as $cat): ?>
                        <tr>
                            <td class="py-3"><?= htmlspecialchars($cat->id_categoria) ?></td>
                            <td class="py-3 fw-semibold text-dark"><?= htmlspecialchars($cat->descricao) ?></td>
                            <td class="py-3">R$ <?= number_format($cat->valor, 2, ',', '.') ?></td>
                            <td class="py-3 text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="formCategoria.php?id_categoria=<?= urlencode($cat->id_categoria) ?>" class="btn btn-sm btn-outline-primary px-3">Editar</a>
                                    <a href="../controllers/controllerCategoria.php?acao=excluir&id_categoria=<?= urlencode($cat->id_categoria) ?>"
                                       class="btn btn-sm btn-outline-danger px-3"
                                       onclick="return confirm('Tem certeza que deseja excluir a categoria <?= htmlspecialchars($cat->descricao) ?>?');">
                                       Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">Nenhuma categoria cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
