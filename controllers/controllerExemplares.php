<?php
session_start();

if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: ../views/dashboard.php");
    exit;
}

require_once '../dao/exemplaresDAO.php';

$acao = $_REQUEST['acao'] ?? '';
$exemplaresDao = new exemplaresDao();

try {

    if ($acao == 'novo') {
        $placa = trim($_POST['placa_veiculo']);
        $idLocacao = $_POST['id_locacao'] !== '' ? $_POST['id_locacao'] : 0;
        $locado = isset($_POST['locado']) ? 1 : 0;
        $exemplaresDao->inserir($placa, $idLocacao, $locado);
        header("Location: ../views/exemplares.php");
        exit;
    }

    elseif ($acao == 'editar') {
        $id = $_POST['id_exemplar'];
        $placa = trim($_POST['placa_veiculo']);
        $idLocacao = $_POST['id_locacao'] !== '' ? $_POST['id_locacao'] : 0;
        $locado = isset($_POST['locado']) ? 1 : 0;
        $exemplaresDao->atualizar($id, $placa, $idLocacao, $locado);
        header("Location: ../views/exemplares.php");
        exit;
    }

    elseif ($acao == 'excluir') {
        $id = $_GET['id_exemplar'];
        $exemplaresDao->excluir($id);
        header("Location: ../views/exemplares.php");
        exit;
    }

    else {
        header("Location: ../views/exemplares.php");
        exit;
    }

} catch (PDOException $e) {
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h3>Erro ao processar a solicitação no Banco de Dados.</h3>";
    echo "<p>Detalhes: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='../views/exemplares.php'>Voltar</a>";
    echo "</div>";
}
?>
