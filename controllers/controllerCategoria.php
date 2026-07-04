<?php
session_start();

// Apenas administrador pode gerenciar categorias
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: ../views/dashboard.php");
    exit;
}

require_once '../dao/categoriaDAO.php';

$acao = $_REQUEST['acao'] ?? '';
$categoriaDao = new categoriaDao();

try {

    if ($acao == 'novo') {
        $descricao = trim($_POST['descricao']);
        $valor = $_POST['valor'];
        $categoriaDao->inserir($descricao, $valor);
        header("Location: ../views/categorias.php");
        exit;
    }

    elseif ($acao == 'editar') {
        $id = $_POST['id_categoria'];
        $descricao = trim($_POST['descricao']);
        $valor = $_POST['valor'];
        $categoriaDao->atualizar($id, $descricao, $valor);
        header("Location: ../views/categorias.php");
        exit;
    }

    elseif ($acao == 'excluir') {
        $id = $_GET['id_categoria'];

        if ($categoriaDao->estaEmUso($id)) {
            $_SESSION['erroCategoria'] = "Não é possível excluir: existem veículos cadastrados nessa categoria.";
            header("Location: ../views/categorias.php");
            exit;
        }

        $categoriaDao->excluir($id);
        header("Location: ../views/categorias.php");
        exit;
    }

    else {
        header("Location: ../views/categorias.php");
        exit;
    }

} catch (PDOException $e) {
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h3>Erro ao processar a solicitação no Banco de Dados.</h3>";
    echo "<p>Detalhes: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='../views/categorias.php'>Voltar</a>";
    echo "</div>";
}
?>
