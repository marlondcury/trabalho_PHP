<?php
session_start();

if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();

// Carrega clientes e veículos (já com o valor da diária) para os dropdowns
$clientes = $pdo->query("SELECT cpf, nome FROM clientes ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$veiculos = $pdo->query("
    SELECT v.placa, v.nome, (v.valorBase + c.valor) AS valor_diaria
    FROM veiculos v
    JOIN categoria c ON v.id_categoria = c.id_categoria
    ORDER BY v.nome
")->fetchAll(PDO::FETCH_ASSOC);

$modoEdicao = false;
$locacao = [
    'id_locacao' => '',
    'data' => date('Y-m-d\TH:i'),
    'data_fim' => date('Y-m-d\TH:i', strtotime('+1 day')),
    'cpf_socio' => '',
    'id_veiculo' => ''
];

if (isset($_GET['id_locacao'])) {
    $modoEdicao = true;

    $stmt = $pdo->prepare("SELECT * FROM locacao WHERE id_locacao = :id");
    $stmt->execute(['id' => $_GET['id_locacao']]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $resultado['data'] = date('Y-m-d\TH:i', strtotime($resultado['data']));
        $resultado['data_fim'] = date('Y-m-d\TH:i', strtotime($resultado['data_fim']));
        $locacao = $resultado;
    } else {
        header("Location: locacoes.php");
        exit;
    }
}

$erro = $_SESSION['erro'] ?? null;
unset($_SESSION['erro']);

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
                            <label class="form-label fw-semibold">Retirada (data e hora)</label>
                            <input type="datetime-local" name="data" id="data_inicio" class="form-control"
                                   value="<?= htmlspecialchars($locacao['data']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Devolução (data e hora)</label>
                            <input type="datetime-local" name="data_fim" id="data_fim" class="form-control"
                                   value="<?= htmlspecialchars($locacao['data_fim']) ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Cliente</label>
                            <select name="cpf_socio" class="form-select" required>
                                <option value="">-- Selecione um cliente --</option>
                                <?php foreach ($clientes as $cli): ?>
                                    <option value="<?= htmlspecialchars($cli['cpf']) ?>"
                                        <?= $locacao['cpf_socio'] == $cli['cpf'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cli['nome']) ?> - <?= htmlspecialchars($cli['cpf']) ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php if (empty($clientes)): ?>
                                    <option disabled>Nenhum cliente cadastrado</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Veículo</label>
                            <select name="id_veiculo" id="id_veiculo" class="form-select" required>
                                <option value="">-- Selecione um veículo --</option>
                                <?php foreach ($veiculos as $v): ?>
                                    <option value="<?= htmlspecialchars($v['placa']) ?>"
                                        data-valor-diaria="<?= htmlspecialchars($v['valor_diaria']) ?>"
                                        <?= $locacao['id_veiculo'] == $v['placa'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($v['placa']) ?> - <?= htmlspecialchars($v['nome']) ?>
                                        (R$ <?= number_format($v['valor_diaria'], 2, ',', '.') ?>/dia)
                                    </option>
                                <?php endforeach; ?>
                                <?php if (empty($veiculos)): ?>
                                    <option disabled>Nenhum veículo cadastrado</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info d-flex justify-content-between align-items-center mb-0">
                                <span id="resumo-diarias">Selecione o veículo e as datas</span>
                                <strong id="resumo-total"></strong>
                            </div>
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
<script>
    const inicio = document.getElementById('data_inicio');
    const fim = document.getElementById('data_fim');
    const veiculoSelect = document.getElementById('id_veiculo');
    const resumoDiarias = document.getElementById('resumo-diarias');
    const resumoTotal = document.getElementById('resumo-total');

    // Mesma regra do servidor: fecha os dias completos de 24h e só soma diária
    // extra se o atraso passar da tolerância (2h). Mínimo de 1 diária.
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
        const opcao = veiculoSelect.options[veiculoSelect.selectedIndex];
        const valorDiaria = opcao ? parseFloat(opcao.dataset.valorDiaria) : NaN;
        const inicioDate = new Date(inicio.value);
        const fimDate = new Date(fim.value);

        if (!valorDiaria || isNaN(inicioDate) || isNaN(fimDate)) {
            resumoDiarias.textContent = 'Selecione o veículo e as datas';
            resumoTotal.textContent = '';
            return;
        }

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
    veiculoSelect.addEventListener('change', atualizarResumo);
    atualizarResumo();
</script>
</body>
</html>
