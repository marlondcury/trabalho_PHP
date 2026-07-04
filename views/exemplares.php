<?php
session_start();
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/exemplaresDAO.php';
$exemplaresDao = new exemplaresDao();
$exemplares = $exemplaresDao->getExemplares();

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Exemplares | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Exemplares</h1>
        <p class="opacity-75">Controle das unidades físicas do acervo de veículos.</p>
    </div>
</section>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">Lista de Exemplares</h3>
        <a href="formExemplares.php" class="btn btn-primary btn-acao">+ Novo Exemplar</a>
    </div>

    <div class="card card-moderno p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary py-3">ID</th>
                        <th class="text-secondary py-3">Veículo (placa)</th>
                        <th class="text-secondary py-3">Locação vinculada</th>
                        <th class="text-secondary py-3">Situação</th>
                        <th class="text-secondary text-center py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($exemplares) > 0): ?>
                        <?php foreach ($exemplares as $ex): ?>
                        <tr>
                            <td class="py-3"><?= htmlspecialchars($ex->id_exemplar) ?></td>
                            <td class="py-3 fw-semibold text-dark">
                                <?= htmlspecialchars($ex->placa_veiculo) ?>
                                <?php if (!empty($ex->nome_veiculo)): ?>
                                    <small class="text-muted d-block"><?= htmlspecialchars($ex->nome_veiculo) ?></small>
                                <?php endif; ?>
                            </td>
                            <td class="py-3"><?= $ex->id_locacao > 0 ? htmlspecialchars($ex->id_locacao) : '-' ?></td>
                            <td class="py-3">
                                <?php if ($ex->locado): ?>
                                    <span class="badge bg-warning text-dark">Locado</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Disponível</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="formExemplares.php?id_exemplar=<?= urlencode($ex->id_exemplar) ?>" class="btn btn-sm btn-outline-primary px-3">Editar</a>
                                    <a href="../controllers/controllerExemplares.php?acao=excluir&id_exemplar=<?= urlencode($ex->id_exemplar) ?>"
                                       class="btn btn-sm btn-outline-danger px-3"
                                       onclick="return confirm('Tem certeza que deseja excluir o exemplar #<?= $ex->id_exemplar ?>?');">
                                       Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Nenhum exemplar cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
