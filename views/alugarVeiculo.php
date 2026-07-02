<?php
session_start();

if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'C') {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_GET['placa'])) {
    header("Location: buscaVeiculo.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();

$stmt = $pdo->prepare("
    SELECT v.*, c.descricao AS categoria, c.valor AS valor_categoria, (v.valorBase + c.valor) AS valor_total
    FROM veiculos v
    JOIN categoria c ON v.id_categoria = c.id_categoria
    WHERE v.placa = :placa
");
$stmt->execute(['placa' => $_GET['placa']]);
$veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$veiculo) {
    header("Location: buscaVeiculo.php");
    exit;
}

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alugar Veículo | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Confirmar Locação</h1>
        <p class="opacity-75">Revise os dados e escolha a data da locação.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <?php if (isset($_GET['erro']) && $_GET['erro'] == 'indisponivel'): ?>
            <div class="alert alert-danger mb-4">
                Este veículo já está alugado na data selecionada. Escolha outra data.
            </div>
            <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 'jaTemLocacao'): ?>
            <div class="alert alert-danger mb-4">
                Você já possui uma locação em aberto. Só é possível alugar um novo veículo após a conclusão da locação atual.
            </div>
            <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 'dataInvalida'): ?>
            <div class="alert alert-danger mb-4">
                A data de devolução não pode ser anterior à data de retirada.
            </div>
            <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 'veiculoInvalido'): ?>
            <div class="alert alert-danger mb-4">
                Não foi possível calcular o valor da locação para este veículo. Tente novamente.
            </div>
            <?php elseif (isset($_GET['erro']) && $_GET['erro'] == 'cadastroIncompleto'): ?>
            <div class="alert alert-danger mb-4">
                Seu cadastro de cliente está incompleto e por isso não é possível concluir a locação. Procure o administrador para regularizar seu cadastro.
            </div>
            <?php endif; ?>

            <div class="card card-moderno p-4 mb-4">
                <h5 class="fw-bold mb-3">Detalhes do Veículo</h5>
                <div class="row g-2">
                    <div class="col-6">
                        <p class="mb-1 text-muted small">Nome</p>
                        <p class="fw-semibold"><?= htmlspecialchars($veiculo['nome']) ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted small">Fabricante</p>
                        <p class="fw-semibold"><?= htmlspecialchars($veiculo['fabricante']) ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted small">Placa</p>
                        <p class="fw-semibold"><?= htmlspecialchars($veiculo['placa']) ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted small">Motorização</p>
                        <p class="fw-semibold"><?= htmlspecialchars($veiculo['motorizacao']) ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted small">Categoria</p>
                        <p class="fw-semibold"><?= htmlspecialchars($veiculo['categoria']) ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted small">Valor da Diária</p>
                        <p class="fw-bold text-primary fs-5">R$ <?= number_format($veiculo['valor_total'], 2, ',', '.') ?> /dia</p>
                    </div>
                </div>
            </div>

            <div class="card card-moderno p-4 p-md-5">
                <form action="../controllers/controllerLocacao.php" method="POST">
                    <input type="hidden" name="acao" value="alugarCliente">
                    <input type="hidden" name="id_veiculo" value="<?= htmlspecialchars($veiculo['placa']) ?>">

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Retirada (data e hora)</label>
                            <input type="datetime-local" name="data" id="data_inicio" class="form-control"
                                   value="<?= date('Y-m-d\TH:i') ?>" min="<?= date('Y-m-d\TH:i') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Devolução (data e hora)</label>
                            <input type="datetime-local" name="data_fim" id="data_fim" class="form-control"
                                   value="<?= date('Y-m-d\TH:i', strtotime('+1 day')) ?>" min="<?= date('Y-m-d\TH:i') ?>" required>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                        <span id="resumo-diarias">1 diária</span>
                        <strong id="resumo-total">R$ <?= number_format($veiculo['valor_total'], 2, ',', '.') ?></strong>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="buscaVeiculo.php" class="btn btn-outline-secondary btn-acao px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-acao px-4">Confirmar Locação</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const inicio = document.getElementById('data_inicio');
    const fim = document.getElementById('data_fim');
    const valorDiaria = <?= (float) $veiculo['valor_total'] ?>;
    const resumoDiarias = document.getElementById('resumo-diarias');
    const resumoTotal = document.getElementById('resumo-total');

    // Fecha os dias completos de 24h e só soma diária
    // tolerância de 2h
    const TOLERANCIA_HORAS = 2;
    function calcularDiarias(inicioDate, fimDate) {
        const diaMs = 1000 * 60 * 60 * 24;
        const toleranciaMs = TOLERANCIA_HORAS * 60 * 60 * 1000;
        const diffMs = fimDate - inicioDate;
        const diasCompletos = Math.floor(diffMs / diaMs);
        const resto = diffMs - (diasCompletos * diaMs);
        const dias = diasCompletos + (resto > toleranciaMs ? 1 : 0);
        return Math.max(1, dias);
    }

    function atualizarResumo() {
        const inicioDate = new Date(inicio.value);
        const fimDate = new Date(fim.value);
        if (isNaN(inicioDate) || isNaN(fimDate)) return;

        const diarias = calcularDiarias(inicioDate, fimDate);
        resumoDiarias.textContent = diarias + (diarias === 1 ? ' diária' : ' diárias');
        resumoTotal.textContent = 'R$ ' + (diarias * valorDiaria).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    inicio.addEventListener('change', () => {
        fim.min = inicio.value;
        if (fim.value < inicio.value) fim.value = inicio.value;
        atualizarResumo();
    });
    fim.addEventListener('change', atualizarResumo);
    atualizarResumo();
</script>
</body>
</html>

