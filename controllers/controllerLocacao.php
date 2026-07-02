<?php
session_start();

if (!isset($_SESSION['usuarioLogado'])) {
    header("Location: ../views/dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
require_once '../dao/locacaoDAO.php';

$acao = $_REQUEST['acao'] ?? '';

// Quantidade de diárias entre dois datetimes. Fecha os dias completos de 24h
// e só soma uma diária extra se o atraso na devolução passar da tolerância
function calcularQtdDiarias($dataInicio, $dataFim, $toleranciaHoras = 2) {
    $inicio = new DateTime($dataInicio);
    $fim = new DateTime($dataFim);
    $segundos = $fim->getTimestamp() - $inicio->getTimestamp();

    $toleranciaSegundos = $toleranciaHoras * 3600;
    $diasCompletos = intdiv($segundos, 86400);
    $resto = $segundos % 86400;

    $qtdDias = $diasCompletos + ($resto > $toleranciaSegundos ? 1 : 0);

    return max(1, $qtdDias);
}

try {
    $conexao = new ConexaoDao();
    $pdo = $conexao->getConexao();
    $locacaoDAO = new locacaoDao();

    // =======================================================
    // Ação 1: CADASTRAR NOVA LOCAÇÃO (admin)
    // =======================================================
    if ($acao == 'novo') {
        if ($_SESSION['perfil'] != 'A') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $data = $_POST['data'];
        $dataFim = $_POST['data_fim'];
        $cpfSocio = trim($_POST['cpf_socio']);
        $idVeiculo = trim($_POST['id_veiculo']);

        if (new DateTime($dataFim) < new DateTime($data)) {
            $_SESSION['erro'] = "A data/hora de devolução não pode ser anterior à de retirada.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $locacaoExitente = $locacaoDAO->possuiLocacaoAtiva($cpfSocio);
        if(!empty($locacaoExitente)) {
            $_SESSION['erro'] = "Esse cliente já possui uma locação em aberto.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($locacaoDAO->veiculoIndisponivel($idVeiculo, $data, $dataFim)) {
            $_SESSION['erro'] = "Esse veículo já está locado nesse período.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Valor total: (valorBase do veículo + valor da categoria) x quantidade de diárias
        $stmtValor = $pdo->prepare("
            SELECT (v.valorBase + c.valor) AS valor_diaria
            FROM veiculos v
            JOIN categoria c ON v.id_categoria = c.id_categoria
            WHERE v.placa = :placa
        ");
        $stmtValor->execute(['placa' => $idVeiculo]);
        $calculo = $stmtValor->fetch(PDO::FETCH_ASSOC);

        if (!$calculo) {
            $_SESSION['erro'] = "Veículo inválido.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $qtdDias = calcularQtdDiarias($data, $dataFim);
        $valorTotal = $calculo['valor_diaria'] * $qtdDias;

        $stmt = $pdo->prepare("INSERT INTO locacao (data, data_fim, valor_total, cpf_socio, id_veiculo)
                               VALUES (:data, :data_fim, :valor_total, :cpf_socio, :id_veiculo)");
        $stmt->execute([
            'data' => (new DateTime($data))->format('Y-m-d H:i:s'),
            'data_fim' => (new DateTime($dataFim))->format('Y-m-d H:i:s'),
            'valor_total' => $valorTotal,
            'cpf_socio' => $cpfSocio,
            'id_veiculo' => $idVeiculo
        ]);

        header("Location: ../views/locacoes.php");
        exit;
    }

    // =======================================================
    // Ação 2: ATUALIZAR LOCAÇÃO EXISTENTE (admin)
    // =======================================================
    elseif ($acao == 'editar') {
        if ($_SESSION['perfil'] != 'A') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $idLocacao = $_POST['id_locacao'];
        $data = $_POST['data'];
        $dataFim = $_POST['data_fim'];
        $cpfSocio = trim($_POST['cpf_socio']);
        $idVeiculo = trim($_POST['id_veiculo']);

        if (new DateTime($dataFim) < new DateTime($data)) {
            $_SESSION['erro'] = "A data/hora de devolução não pode ser anterior à de retirada.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $locacaoExitente = $locacaoDAO->possuiLocacaoAtiva($cpfSocio, $idLocacao);
        if(!empty($locacaoExitente)) {
            $_SESSION['erro'] = "Esse cliente já possui uma locação em aberto.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($locacaoDAO->veiculoIndisponivel($idVeiculo, $data, $dataFim, $idLocacao)) {
            $_SESSION['erro'] = "Esse veículo já está locado nesse período.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $stmtValor = $pdo->prepare("
            SELECT (v.valorBase + c.valor) AS valor_diaria
            FROM veiculos v
            JOIN categoria c ON v.id_categoria = c.id_categoria
            WHERE v.placa = :placa
        ");
        $stmtValor->execute(['placa' => $idVeiculo]);
        $calculo = $stmtValor->fetch(PDO::FETCH_ASSOC);

        if (!$calculo) {
            $_SESSION['erro'] = "Veículo inválido.";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $qtdDias = calcularQtdDiarias($data, $dataFim);
        $valorTotal = $calculo['valor_diaria'] * $qtdDias;

        $stmt = $pdo->prepare("UPDATE locacao
                               SET data = :data, data_fim = :data_fim, valor_total = :valor_total,
                                   cpf_socio = :cpf_socio, id_veiculo = :id_veiculo
                               WHERE id_locacao = :id_locacao");
        $stmt->execute([
            'data' => (new DateTime($data))->format('Y-m-d H:i:s'),
            'data_fim' => (new DateTime($dataFim))->format('Y-m-d H:i:s'),
            'valor_total' => $valorTotal,
            'cpf_socio' => $cpfSocio,
            'id_veiculo' => $idVeiculo,
            'id_locacao' => $idLocacao
        ]);

        header("Location: ../views/locacoes.php");
        exit;
    }

    // =======================================================
    // Ação 3: EXCLUIR LOCAÇÃO (admin)
    // =======================================================
    elseif ($acao == 'excluir') {
        if ($_SESSION['perfil'] != 'A') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $idLocacao = $_GET['id_locacao'];

        $stmt = $pdo->prepare("DELETE FROM locacao WHERE id_locacao = :id_locacao");
        $stmt->execute(['id_locacao' => $idLocacao]);

        header("Location: ../views/locacoes.php");
        exit;
    }

    // =======================================================
    // Ação 4: MARCAR DEVOLUÇÃO (admin)
    // =======================================================
    elseif ($acao == 'devolver') {
        if ($_SESSION['perfil'] != 'A') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $idLocacao = $_GET['id_locacao'];

        // Busca a locação e o valor da diária do veículo pra recalcular com base no tempo real de uso
        $stmt = $pdo->prepare("
            SELECT l.data, (v.valorBase + c.valor) AS valor_diaria
            FROM locacao l
            JOIN veiculos v ON l.id_veiculo = v.placa
            JOIN categoria c ON v.id_categoria = c.id_categoria
            WHERE l.id_locacao = :id_locacao
        ");
        $stmt->execute(['id_locacao' => $idLocacao]);
        $locacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($locacao) {
            $agora = new DateTime();
            $qtdDias = calcularQtdDiarias($locacao['data'], $agora->format('Y-m-d H:i:s'));
            $valorTotal = $locacao['valor_diaria'] * $qtdDias;

            $stmtUpdate = $pdo->prepare("UPDATE locacao
                                         SET data_fim = :data_fim, valor_total = :valor_total, devolvida = 1
                                         WHERE id_locacao = :id_locacao");
            $stmtUpdate->execute([
                'data_fim' => $agora->format('Y-m-d H:i:s'),
                'valor_total' => $valorTotal,
                'id_locacao' => $idLocacao
            ]);
        }

        header("Location: ../views/locacoes.php");
        exit;
    }

    // =======================================================
    // Ação 5: Nova locação (cliente)
    // =======================================================
    elseif ($acao == 'alugarCliente') {
        if ($_SESSION['perfil'] != 'C') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $data = $_POST['data'];
        $dataFim = $_POST['data_fim'];
        $idVeiculo = trim($_POST['id_veiculo']);
        $email = $_SESSION['usuarioLogado']['email'];

        // Buscar CPF do cliente pelo email da sessão
        $stmtCpf = $pdo->prepare("SELECT cpf FROM clientes WHERE email = :email");
        $stmtCpf->execute(['email' => $email]);
        $cliente = $stmtCpf->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            header("Location: ../views/alugarVeiculo.php?placa=" . urlencode($idVeiculo) . "&erro=cadastroIncompleto");
            exit;
        }

        $locacaoExitente = $locacaoDAO->possuiLocacaoAtiva($cliente['cpf']);
        if(!empty($locacaoExitente)) {
            header("Location: ../views/alugarVeiculo.php?placa=" . urlencode($idVeiculo) . "&erro=jaTemLocacao");
            exit;
        }

        // A devolução não pode ser anterior à retirada
        if (new DateTime($dataFim) < new DateTime($data)) {
            header("Location: ../views/alugarVeiculo.php?placa=" . urlencode($idVeiculo) . "&erro=dataInvalida");
            exit;
        }

        // Um veículo só pode ser alugado para um único cliente por período
        if ($locacaoDAO->veiculoIndisponivel($idVeiculo, $data, $dataFim)) {
            header("Location: ../views/alugarVeiculo.php?placa=" . urlencode($idVeiculo) . "&erro=indisponivel");
            exit;
        }

        // Calcular valor total: (valorBase do veículo + valor da categoria) x quantidade de diárias
        $stmtValor = $pdo->prepare("
            SELECT (v.valorBase + c.valor) AS valor_diaria
            FROM veiculos v
            JOIN categoria c ON v.id_categoria = c.id_categoria
            WHERE v.placa = :placa
        ");
        $stmtValor->execute(['placa' => $idVeiculo]);
        $calculo = $stmtValor->fetch(PDO::FETCH_ASSOC);

        if (!$calculo) {
            header("Location: ../views/alugarVeiculo.php?placa=" . urlencode($idVeiculo) . "&erro=veiculoInvalido");
            exit;
        }
        $valorDiaria = $calculo['valor_diaria'];

        $qtdDias = calcularQtdDiarias($data, $dataFim);
        $valorTotal = $valorDiaria * $qtdDias;

        $stmt = $pdo->prepare("INSERT INTO locacao (data, data_fim, valor_total, cpf_socio, id_veiculo)
                               VALUES (:data, :data_fim, :valor_total, :cpf_socio, :id_veiculo)");
        $stmt->execute([
            'data' => (new DateTime($data))->format('Y-m-d H:i:s'),
            'data_fim' => (new DateTime($dataFim))->format('Y-m-d H:i:s'),
            'valor_total' => $valorTotal,
            'cpf_socio' => $cliente['cpf'],
            'id_veiculo' => $idVeiculo
        ]);

        header("Location: ../views/minhasLocacoes.php");
        exit;
    }

} catch (PDOException $e) {
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h3>Erro ao processar a solicitação no Banco de Dados.</h3>";
    echo "<p>Detalhes: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='../views/dashboard.php'>Voltar</a>";
    echo "</div>";
}
?>
