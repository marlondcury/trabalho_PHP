<?php
session_start();

// Trava de segurança
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: ../views/dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$acao = $_REQUEST['acao'] ?? '';

try {
    $conexao = new conexaoDao(); 
    $pdo = $conexao->getConexao();

    // =======================================================
    // AÇÃO 1: CADASTRAR NOVO CLIENTE
    // =======================================================
    if ($acao == 'novo') {
        $cpf = trim($_POST['cpf']);
        $nome = trim($_POST['nome']);
        $rg = trim($_POST['rg']);
        $endereco = trim($_POST['endereco']);
        $telefone = trim($_POST['telefone']);
        $email = trim($_POST['email']);

        // PASSO 1: Cria o acesso de login do cliente PRIMEIRO
        $senhaPadrao = '123456'; // Senha inicial para todos os clientes novos
        $stmtUser = $pdo->prepare("INSERT INTO usuarios (user, senha, perfil) VALUES (:email, :senha, 'c')");
        $stmtUser->execute(['email' => $email, 'senha' => $senhaPadrao]);

        // PASSO 2: Agora sim, com o login criado, podemos cadastrar o cliente
        $stmt = $pdo->prepare("INSERT INTO clientes (cpf, nome, rg, endereco, telefone, email) VALUES (:cpf, :nome, :rg, :endereco, :telefone, :email)");
        $stmt->execute([
            'cpf' => $cpf,
            'nome' => $nome,
            'rg' => $rg,
            'endereco' => $endereco,
            'telefone' => $telefone,
            'email' => $email
        ]);

        header("Location: ../views/clientes.php");
        exit;
    }

    // =======================================================
    // AÇÃO 2: ATUALIZAR CLIENTE EXISTENTE (EDITAR)
    // =======================================================
    elseif ($acao == 'editar') {
        $cpf = trim($_POST['cpf']); 
        $nome = trim($_POST['nome']);
        $rg = trim($_POST['rg']);
        $endereco = trim($_POST['endereco']);
        $telefone = trim($_POST['telefone']);
        $novoEmail = trim($_POST['email']);

        // 1. Descobre qual era o e-mail antigo do cliente
        $stmtBusca = $pdo->prepare("SELECT email FROM clientes WHERE cpf = :cpf");
        $stmtBusca->execute(['cpf' => $cpf]);
        $clienteAntigo = $stmtBusca->fetch(PDO::FETCH_ASSOC);
        $emailAntigo = $clienteAntigo['email'];

        // 2. Se o administrador alterou o e-mail no formulário, atualiza o login!
        // O "CASCADE" do banco vai cuidar de alterar na tabela clientes para você.
        if ($emailAntigo != $novoEmail) {
            $stmtUpdateUser = $pdo->prepare("UPDATE usuarios SET user = :novoEmail WHERE user = :emailAntigo");
            $stmtUpdateUser->execute(['novoEmail' => $novoEmail, 'emailAntigo' => $emailAntigo]);
        }

        // 3. Atualiza o restante dos dados (nome, rg, endereço...)
        $stmt = $pdo->prepare("UPDATE clientes SET nome = :nome, rg = :rg, endereco = :endereco, telefone = :telefone WHERE cpf = :cpf");
        $stmt->execute([
            'nome' => $nome,
            'rg' => $rg,
            'endereco' => $endereco,
            'telefone' => $telefone,
            'cpf' => $cpf
        ]);

        header("Location: ../views/clientes.php");
        exit;
    }

    // =======================================================
    // AÇÃO 3: EXCLUIR CLIENTE
    // =======================================================
    elseif ($acao == 'excluir') {
        $cpf = $_GET['cpf'];

        // 1. Pega o email antes de excluir
        $stmtBusca = $pdo->prepare("SELECT email FROM clientes WHERE cpf = :cpf");
        $stmtBusca->execute(['cpf' => $cpf]);
        $cliente = $stmtBusca->fetch(PDO::FETCH_ASSOC);
        $email = $cliente['email'];

        // 2. Exclui o cliente (O filho)
        $stmtCli = $pdo->prepare("DELETE FROM clientes WHERE cpf = :cpf");
        $stmtCli->execute(['cpf' => $cpf]);

        // 3. Exclui a conta de acesso (O pai)
        if ($email) {
            $stmtUser = $pdo->prepare("DELETE FROM usuarios WHERE user = :email");
            $stmtUser->execute(['email' => $email]);
        }

        header("Location: ../views/clientes.php");
        exit;
    }

} catch (PDOException $e) {
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h3>Erro ao processar a solicitação no Banco de Dados.</h3>";
    echo "<p>Detalhes: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='../views/clientes.php'>Voltar para a tela de Clientes</a>";
    echo "</div>";
}
?>