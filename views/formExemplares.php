<?php
session_start();
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/exemplaresDAO.php';
require_once '../dao/conexao.inc.php';

$exemplaresDao = new exemplaresDao();
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();
$veiculos = $pdo->query("SELECT placa, nome FROM veiculos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

$modoEdicao = false;
$exemplar = (object) ['id_exemplar' => '', 'placa_veiculo' => '', 'id_locacao' => 0, 'locado' => 0];

if (isset($_GET['id_exemplar'])) {
    $modoEdicao = true;
    $resultado = $exemplaresDao->buscarPorId($_GET['id_exemplar']);
    if ($resultado) {
        $exemplar = $resultado;
    } else {
        header("Location: exemplares.php");
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
    <title><?= $modoEdicao ? 'Editar Exemplar' : 'Novo Exemplar' ?> | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0"><?= $modoEdicao ? 'Editar Exemplar' : 'Cadastrar Novo Exemplar' ?></h1>
        <p class="opacity-75">Vincule uma unidade física a um veículo do acervo.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-moderno p-4 p-md-5">

                <form action="../controllers/controllerExemplares.php" method="POST">
                    <input type="hidden" name="acao" value="<?= $modoEdicao ? 'editar' : 'novo' ?>">
                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id_exemplar" value="<?= htmlspecialchars($exemplar->id_exemplar) ?>">
                    <?php endif; ?>

                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Veículo</label>
                            <select name="placa_veiculo" class="form-select" required>
                                <option value="">-- Selecione um veículo --</option>
                                <?php foreach ($veiculos as $v): ?>
                                    <option value="<?= htmlspecialchars($v['placa']) ?>"
                                        <?= $exemplar->placa_veiculo == $v['placa'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($v['placa']) ?> - <?= htmlspecialchars($v['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">ID da Locação vinculada (opcional)</label>
                            <input type="number" min="0" name="id_locacao" class="form-control"
                                   placeholder="0 se não houver" value="<?= htmlspecialchars($exemplar->id_locacao) ?>">
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="locado" id="locado"
                                    <?= $exemplar->locado ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="locado">
                                    Está locado atualmente
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="exemplares.php" class="btn btn-outline-secondary btn-acao px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-acao px-4">
                            <?= $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Exemplar' ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
