<?php
session_start();

if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'C') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();

$email = $_SESSION['usuarioLogado']['email'];

$stmt = $pdo->prepare("
    SELECT l.id_locacao, l.data, l.data_fim, l.valor_total, l.devolvida, l.id_veiculo AS placa,
           COALESCE(v.nome, l.id_veiculo) AS nome_veiculo
    FROM locacao l
    JOIN clientes c ON l.cpf_socio = c.cpf
    LEFT JOIN veiculos v ON l.id_veiculo = v.placa
    WHERE c.email = :email
    ORDER BY l.data DESC
");
$stmt->execute(['email' => $email]);
$locacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$hoje = date('Y-m-d H:i:s');

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Locações | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Minhas Locações</h1>
        <p class="opacity-75">Histórico de veículos que você alugou.</p>
    </div>
</section>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">Histórico</h3>
    </div>

    <div class="card card-moderno p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary py-3">#</th>
                        <th class="text-secondary py-3">Retirada</th>
                        <th class="text-secondary py-3">Devolução</th>
                        <th class="text-secondary py-3">Veículo</th>
                        <th class="text-secondary py-3">Placa</th>
                        <th class="text-secondary py-3">Valor Total</th>
                        <th class="text-secondary py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($locacoes) > 0): ?>
                        <?php foreach ($locacoes as $loc): ?>
                        <tr>
                            <td class="py-3"><?= htmlspecialchars($loc['id_locacao']) ?></td>
                            <td class="py-3"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($loc['data']))) ?></td>
                            <td class="py-3"><?= $loc['data_fim'] ? htmlspecialchars(date('d/m/Y H:i', strtotime($loc['data_fim']))) : '-' ?></td>
                            <td class="py-3 fw-semibold text-dark"><?= htmlspecialchars($loc['nome_veiculo']) ?></td>
                            <td class="py-3"><?= htmlspecialchars($loc['placa']) ?></td>
                            <td class="py-3">R$ <?= number_format($loc['valor_total'], 2, ',', '.') ?></td>
                            <td class="py-3">
                                <?php $dataRef = $loc['data_fim'] ?? $loc['data']; ?>
                                <?php if ($loc['devolvida']): ?>
                                    <span class="badge bg-success">Concluída</span>
                                <?php elseif ($dataRef < $hoje): ?>
                                    <span class="badge bg-danger">Atrasada</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Em Aberto</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Você ainda não possui locações registradas.</td>
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

