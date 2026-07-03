<?php
session_start();
require_once '../dao/conexao.inc.php';
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();

$condicoes = [];
$params = [];

if (isset($_GET['buscar'])) {
    if (!empty($_GET['placa'])) {
        $condicoes[] = "v.placa LIKE :placa";
        $params['placa'] = '%' . $_GET['placa'] . '%';
    }
    if (!empty($_GET['nome'])) {
        $condicoes[] = "v.nome LIKE :nome";
        $params['nome'] = '%' . $_GET['nome'] . '%';
    }
    if (!empty($_GET['fabricante'])) {
        $condicoes[] = "v.fabricante LIKE :fabricante";
        $params['fabricante'] = '%' . $_GET['fabricante'] . '%';
    }
    if (!empty($_GET['motor'])) {
        $condicoes[] = "v.motorizacao LIKE :motor";
        $params['motor'] = '%' . $_GET['motor'] . '%';
    }
}

$sql = "SELECT v.*, c.descricao AS categoria, (v.valorBase + c.valor) AS valor_total
        FROM veiculos v
        JOIN categoria c ON v.id_categoria = c.id_categoria";

if (!empty($condicoes)) {
    $sql .= " WHERE " . implode(" AND ", $condicoes);
}
$sql .= " ORDER BY v.nome";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/LocadoraWeb/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Busca de Veículos</h1>
        <p class="mb-0 opacity-75">Pesquise pelo acervo disponível da locadora.</p>
    </div>
</section>

<div class="container py-5">
    <div class="card card-moderno p-4 p-md-5 mb-4">
        <form action="buscaVeiculo.php" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Placa</label>
                    <input type="text" name="placa" class="form-control" placeholder="Ex: ABC1D23"
                           value="<?= htmlspecialchars($_GET['placa'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Ex: Civic"
                           value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fabricante</label>
                    <input type="text" name="fabricante" class="form-control" placeholder="Ex: Honda"
                           value="<?= htmlspecialchars($_GET['fabricante'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Motorização</label>
                    <input type="text" name="motor" class="form-control" placeholder="Ex: 2.0"
                           value="<?= htmlspecialchars($_GET['motor'] ?? '') ?>">
                </div>
            </div>
            <div class="mt-4 d-flex flex-wrap gap-2">
                <button type="submit" name="buscar" class="btn btn-primary btn-acao">Buscar</button>
                <a href="buscaVeiculo.php" class="btn btn-outline-secondary btn-acao">Limpar</a>
            </div>
        </form>
    </div>

    <?php if (isset($_GET['buscar']) || !isset($_GET['buscar'])): ?>
    <div class="card card-moderno p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary py-3">Nome</th>
                        <th class="text-secondary py-3">Fabricante</th>
                        <th class="text-secondary py-3">Placa</th>
                        <th class="text-secondary py-3">Motorização</th>
                        <th class="text-secondary py-3">Categoria</th>
                        <th class="text-secondary py-3">Valor (R$)</th>
                        <?php if (isset($_SESSION['usuarioLogado']) && $_SESSION['perfil'] == 'C'): ?>
                        <th class="text-secondary text-center py-3">Ação</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($veiculos) > 0): ?>
                        <?php foreach ($veiculos as $v): ?>
                        <tr>
                            <td class="py-3 fw-semibold text-dark"><?= htmlspecialchars($v['nome']) ?></td>
                            <td class="py-3"><?= htmlspecialchars($v['fabricante']) ?></td>
                            <td class="py-3"><?= htmlspecialchars($v['placa']) ?></td>
                            <td class="py-3"><?= htmlspecialchars($v['motorizacao']) ?></td>
                            <td class="py-3"><?= htmlspecialchars($v['categoria']) ?></td>
                            <td class="py-3">R$ <?= number_format($v['valor_total'], 2, ',', '.') ?></td>
                            <?php if (isset($_SESSION['usuarioLogado']) && $_SESSION['perfil'] == 'C'): ?>
                            <td class="py-3 text-center">
                                <a href="alugarVeiculo.php?placa=<?= urlencode($v['placa']) ?>"
                                   class="btn btn-sm btn-primary px-3">Alugar</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">Nenhum veículo encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once "includes/rodape.inc.php" ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
