<?php
session_start();

if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();

// Carrega clientes e veículos para os dropdowns
$clientes = $pdo->query("SELECT cpf, nome FROM clientes ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$veiculos = $pdo->query("SELECT placa, nome FROM veiculos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

$modoEdicao = false;
$locacao = [
    'id_locacao'  => '',
    'data'        => date('Y-m-d'),
    'valor_total' => '',
    'cpf_socio'   => '',
    'id_veiculo'  => ''
];

if (isset($_GET['id_locacao'])) {
    $modoEdicao = true;

    $stmt = $pdo->prepare("SELECT * FROM locacao WHERE id_locacao = :id");
    $stmt->execute(['id' => $_GET['id_locacao']]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $locacao = $resultado;
    } else {
        header("Location: locacoes.php");
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
    <title><?= $modoEdicao ? 'Editar Locação' : 'Nova Locação' ?> | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0"><?= $modoEdicao ? 'Editar Locação' : 'Nova Locação' ?></h1>
        <p class="opacity-75">Preencha os dados da locação abaixo.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-moderno p-4 p-md-5">

                <form action="../controllers/controllerLocacao.php" method="POST">
                    <input type="hidden" name="acao" value="<?= $modoEdicao ? 'editar' : 'novo' ?>">
                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id_locacao" value="<?= htmlspecialchars($locacao['id_locacao']) ?>">
                    <?php endif; ?>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Data da Locação</label>
                            <input type="date" name="data" class="form-control"
                                   value="<?= htmlspecialchars($locacao['data']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Valor Total (R$)</label>
                            <input type="number" name="valor_total" class="form-control"
                                   placeholder="Ex: 350.00" step="0.01" min="0"
                                   value="<?= htmlspecialchars($locacao['valor_total']) ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Cliente</label>
                            <select name="cpf_socio" class="form-select" required>
                                <option value="">-- Selecione um cliente --</option>
                                <?php foreach ($clientes as $cli): ?>
                                    <option value="<?= htmlspecialchars($cli['cpf']) ?>"
                                        <?= $locacao['cpf_socio'] == $cli['cpf'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cli['nome']) ?> �?" <?= htmlspecialchars($cli['cpf']) ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php if (empty($clientes)): ?>
                                    <option disabled>Nenhum cliente cadastrado</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Veículo</label>
                            <select name="id_veiculo" class="form-select" required>
                                <option value="">-- Selecione um veículo --</option>
                                <?php foreach ($veiculos as $v): ?>
                                    <option value="<?= htmlspecialchars($v['placa']) ?>"
                                        <?= $locacao['id_veiculo'] == $v['placa'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($v['placa']) ?> �?" <?= htmlspecialchars($v['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php if (empty($veiculos)): ?>
                                    <option disabled>Nenhum veículo cadastrado</option>
                                <?php endif; ?>
                            </select>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="locacoes.php" class="btn btn-outline-secondary btn-acao px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-acao px-4">
                            <?= $modoEdicao ? 'Salvar Alterações' : 'Registrar Locação' ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

