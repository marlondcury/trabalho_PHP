<?php
session_start();
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();

$dataInicio = $_GET['data_inicio'] ?? '';
$dataFim = $_GET['data_fim'] ?? '';

$sql = "
    SELECT l.*, c.nome AS nome_cliente
    FROM locacao l
    LEFT JOIN clientes c ON l.cpf_socio = c.cpf
";
$condicoes = [];
$params = [];

if (!empty($dataInicio)) {
    $condicoes[] = "l.data >= :data_inicio";
    $params['data_inicio'] = $dataInicio . " 00:00:00";
}
if (!empty($dataFim)) {
    $condicoes[] = "l.data <= :data_fim";
    $params['data_fim'] = $dataFim . " 23:59:59";
}
if (!empty($condicoes)) {
    $sql .= " WHERE " . implode(" AND ", $condicoes);
}
$sql .= " ORDER BY l.id_locacao DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$locacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$agora = date('Y-m-d H:i:s');

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Locações | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Locações</h1>
        <p class="opacity-75">Gerencie as locações de veículos.</p>
    </div>
</section>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">Lista de Locações</h3>
        <a href="formLocacao.php" class="btn btn-primary btn-acao">+ Nova Locação</a>
    </div>

    <div class="card card-moderno p-4 mb-4">
        <form action="locacoes.php" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Data inicial</label>
                <input type="date" name="data_inicio" class="form-control" value="<?= htmlspecialchars($dataInicio) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Data final</label>
                <input type="date" name="data_fim" class="form-control" value="<?= htmlspecialchars($dataFim) ?>">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-acao">Filtrar</button>
                <a href="locacoes.php" class="btn btn-outline-secondary btn-acao">Limpar</a>
            </div>
        </form>
    </div>

    <div class="card card-moderno p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary py-3">#</th>
                        <th class="text-secondary py-3">Data</th>
                        <th class="text-secondary py-3">Data Fim</th>
                        <th class="text-secondary py-3">Cliente (CPF)</th>
                        <th class="text-secondary py-3">ID Veículo</th>
                        <th class="text-secondary py-3">Valor Total</th>
                        <th class="text-secondary py-3">Status</th>
                        <th class="text-secondary text-center py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($locacoes) > 0): ?>
                        <?php foreach ($locacoes as $loc): ?>
                        <tr>
                            <td class="py-3"><?= htmlspecialchars($loc['id_locacao']) ?></td>
                            <td class="py-3"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($loc['data']))) ?></td>
                            <td class="py-3"><?= !empty($loc['data_fim']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($loc['data_fim']))) : '-' ?></td>
                            <td class="py-3 fw-semibold text-dark">
                                <?= htmlspecialchars($loc['nome_cliente'] ?? $loc['cpf_socio']) ?>
                                <small class="text-muted d-block"><?= htmlspecialchars($loc['cpf_socio']) ?></small>
                            </td>
                            <td class="py-3"><?= htmlspecialchars($loc['id_veiculo']) ?></td>
                            <td class="py-3">R$ <?= number_format($loc['valor_total'], 2, ',', '.') ?></td>
                            <td class="py-3">
                                <?php if ($loc['devolvida']): ?>
                                    <span class="badge bg-success">Concluída</span>
                                <?php elseif (!empty($loc['data_fim']) && $loc['data_fim'] < $agora): ?>
                                    <span class="badge bg-danger">Atrasada</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Em Aberto</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <?php if (!$loc['devolvida']): ?>
                                    <a href="../controllers/controllerLocacao.php?acao=devolver&id_locacao=<?= urlencode($loc['id_locacao']) ?>"
                                       class="btn btn-sm btn-outline-success px-3"
                                       onclick="return confirm('Marcar a locação #<?= $loc['id_locacao'] ?> como devolvida agora? O valor total será recalculado com base no tempo real de uso.');">
                                       Marcar Devolução
                                    </a>
                                    <?php endif; ?>
                                    <a href="formLocacao.php?id_locacao=<?= urlencode($loc['id_locacao']) ?>"
                                       class="btn btn-sm btn-outline-primary px-3">Editar</a>
                                    <a href="../controllers/controllerLocacao.php?acao=excluir&id_locacao=<?= urlencode($loc['id_locacao']) ?>"
                                       class="btn btn-sm btn-outline-danger px-3"
                                       onclick="return confirm('Tem certeza que deseja excluir a locação #<?= $loc['id_locacao'] ?>?');">
                                       Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">Nenhuma locação cadastrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

