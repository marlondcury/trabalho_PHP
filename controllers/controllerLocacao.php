<?php
session_start();

if (!isset($_SESSION['usuarioLogado'])) {
    header("Location: ../views/dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$acao = $_REQUEST['acao'] ?? '';

try {
    $conexao = new ConexaoDao();
    $pdo = $conexao->getConexao();

    // =======================================================
    // A�?�fO 1: CADASTRAR NOVA LOCA�?�fO (admin)
    // =======================================================
    if ($acao == 'novo') {
        if ($_SESSION['perfil'] != 'A') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $data       = $_POST['data'];
        $valorTotal = $_POST['valor_total'];
        $cpfSocio   = trim($_POST['cpf_socio']);
        $idVeiculo  = trim($_POST['id_veiculo']);

        $stmt = $pdo->prepare("INSERT INTO locacao (data, valor_total, cpf_socio, id_veiculo)
                               VALUES (:data, :valor_total, :cpf_socio, :id_veiculo)");
        $stmt->execute([
            'data'        => $data,
            'valor_total' => $valorTotal,
            'cpf_socio'   => $cpfSocio,
            'id_veiculo'  => $idVeiculo
        ]);

        header("Location: ../views/locacoes.php");
        exit;
    }

    // =======================================================
    // A�?�fO 2: ATUALIZAR LOCA�?�fO EXISTENTE (admin)
    // =======================================================
    elseif ($acao == 'editar') {
        if ($_SESSION['perfil'] != 'A') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $idLocacao  = $_POST['id_locacao'];
        $data       = $_POST['data'];
        $valorTotal = $_POST['valor_total'];
        $cpfSocio   = trim($_POST['cpf_socio']);
        $idVeiculo  = trim($_POST['id_veiculo']);

        $stmt = $pdo->prepare("UPDATE locacao
                               SET data = :data, valor_total = :valor_total,
                                   cpf_socio = :cpf_socio, id_veiculo = :id_veiculo
                               WHERE id_locacao = :id_locacao");
        $stmt->execute([
            'data'        => $data,
            'valor_total' => $valorTotal,
            'cpf_socio'   => $cpfSocio,
            'id_veiculo'  => $idVeiculo,
            'id_locacao'  => $idLocacao
        ]);

        header("Location: ../views/locacoes.php");
        exit;
    }

    // =======================================================
    // A�?�fO 3: EXCLUIR LOCA�?�fO (admin)
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
    // A�?�fO 4: Nova locação (cliente)
    // =======================================================
    elseif ($acao == 'alugarCliente') {
        if ($_SESSION['perfil'] != 'C') {
            header("Location: ../views/dashboard.php");
            exit;
        }

        $data      = $_POST['data'];
        $dataFim   = $_POST['data_fim'];
        $idVeiculo = trim($_POST['id_veiculo']);
        $email     = $_SESSION['usuarioLogado']['email'];

        // Buscar CPF do cliente pelo email da sessão
        $stmtCpf = $pdo->prepare("SELECT cpf FROM clientes WHERE email = :email");
        $stmtCpf->execute(['email' => $email]);
        $cliente = $stmtCpf->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            header("Location: ../views/dashboard.php");
            exit;
        }

        // Verificar sobreposição de datas: novo período não pode cruzar com locação existente
        $stmtVerifica = $pdo->prepare("
            SELECT COUNT(*) FROM locacao
            WHERE id_veiculo = :id_veiculo
              AND :data_inicio <= COALESCE(data_fim, data)
              AND :data_fim    >= data
        ");
        $stmtVerifica->execute([
            'id_veiculo'  => $idVeiculo,
            'data_inicio' => $data,
            'data_fim'    => $dataFim
        ]);
        if ($stmtVerifica->fetchColumn() > 0) {
            header("Location: ../views/alugarVeiculo.php?placa=" . urlencode($idVeiculo) . "&erro=indisponivel");
            exit;
        }

        // Calcular valor total: valorBase do veículo + valor da categoria
        $stmtValor = $pdo->prepare("
            SELECT (v.valorBase + c.valor) AS valor_total
            FROM veiculos v
            JOIN categoria c ON v.id_categoria = c.id_categoria
            WHERE v.placa = :placa
        ");
        $stmtValor->execute(['placa' => $idVeiculo]);
        $calculo = $stmtValor->fetch(PDO::FETCH_ASSOC);
        $valorTotal = $calculo ? $calculo['valor_total'] : 0;

        $stmt = $pdo->prepare("INSERT INTO locacao (data, data_fim, valor_total, cpf_socio, id_veiculo)
                               VALUES (:data, :data_fim, :valor_total, :cpf_socio, :id_veiculo)");
        $stmt->execute([
            'data'        => $data,
            'data_fim'    => $dataFim,
            'valor_total' => $valorTotal,
            'cpf_socio'   => $cliente['cpf'],
            'id_veiculo'  => $idVeiculo
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

