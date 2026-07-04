<?php
session_start();

<<<<<<< HEAD
require_once '../dao/conexao.inc.php';
$acao = $_REQUEST['acao'] ?? '';

// Ações restritas ao cliente autenticado, sobre o próprio cadastro
$acoesProprias = ['editarProprio', 'excluirProprio'];

if (!isset($_SESSION['usuarioLogado'])) {
    header("Location: ../views/login.php");
    exit;
}

if (in_array($acao, $acoesProprias)) {
    // Cliente só pode mexer no próprio cadastro
    if ($_SESSION['perfil'] != 'C') {
        header("Location: ../views/dashboard.php");
        exit;
    }
} else {
    // Demais ações (novo/editar/excluir de qualquer cliente) são só do Admin
    if ($_SESSION['perfil'] != 'A') {
        header("Location: ../views/dashboard.php");
        exit;
    }
}
=======
// Trava de segurança
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: ../views/dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$acao = $_REQUEST['acao'] ?? '';
>>>>>>> 9bbff463848663aae26627f0d89f6e3eb91cf90c

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
        $stmtUser = $pdo->prepare("INSERT INTO usuarios (user, senha, perfil) VALUES (:email, :senha, 'C')");
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
        // O "CASCADE" do banco vai alterar na tabela clientes.
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

<<<<<<< HEAD
    // =======================================================
    // AÇÃO 4: CLIENTE ATUALIZA O PRÓPRIO CADASTRO
    // =======================================================
    elseif ($acao == 'editarProprio') {
        $emailSessao = $_SESSION['usuarioLogado']['email'];

        $nome = trim($_POST['nome']);
        $rg = trim($_POST['rg']);
        $endereco = trim($_POST['endereco']);
        $telefone = trim($_POST['telefone']);
        $novoEmail = trim($_POST['email']);

        // Se o cliente alterou o próprio e-mail, atualiza também o login (chave em 'usuarios')
        if ($emailSessao != $novoEmail) {
            $stmtUpdateUser = $pdo->prepare("UPDATE usuarios SET user = :novoEmail WHERE user = :emailAntigo");
            $stmtUpdateUser->execute(['novoEmail' => $novoEmail, 'emailAntigo' => $emailSessao]);
        }

        $stmt = $pdo->prepare("UPDATE clientes SET nome = :nome, rg = :rg, endereco = :endereco, telefone = :telefone WHERE email = :emailAntigo");
        $stmt->execute([
            'nome' => $nome,
            'rg' => $rg,
            'endereco' => $endereco,
            'telefone' => $telefone,
            'emailAntigo' => $emailSessao
        ]);

        // Mantém a sessão consistente com o nome/e-mail atualizados
        $_SESSION['usuarioLogado']['user'] = $nome;
        $_SESSION['usuarioLogado']['email'] = $novoEmail;

        header("Location: ../views/meuCadastro.php?sucesso=1");
        exit;
    }

    // =======================================================
    // AÇÃO 5: CLIENTE EXCLUI O PRÓPRIO CADASTRO
    // =======================================================
    elseif ($acao == 'excluirProprio') {
        $emailSessao = $_SESSION['usuarioLogado']['email'];

        $stmtCpf = $pdo->prepare("SELECT cpf FROM clientes WHERE email = :email");
        $stmtCpf->execute(['email' => $emailSessao]);
        $cliente = $stmtCpf->fetch(PDO::FETCH_ASSOC);

        // Não permite excluir o cadastro se houver locação em aberto
        if ($cliente) {
            $stmtLoc = $pdo->prepare("SELECT COUNT(*) AS total FROM locacao WHERE cpf_socio = :cpf AND devolvida = 0");
            $stmtLoc->execute(['cpf' => $cliente['cpf']]);
            if ($stmtLoc->fetch(PDO::FETCH_ASSOC)['total'] > 0) {
                header("Location: ../views/meuCadastro.php?erro=locacaoAberta");
                exit;
            }

            $stmtDel = $pdo->prepare("DELETE FROM clientes WHERE cpf = :cpf");
            $stmtDel->execute(['cpf' => $cliente['cpf']]);
        }

        $stmtUser = $pdo->prepare("DELETE FROM usuarios WHERE user = :email");
        $stmtUser->execute(['email' => $emailSessao]);

        session_destroy();
        header("Location: ../views/index.php?contaExcluida=1");
        exit;
    }

=======
>>>>>>> 9bbff463848663aae26627f0d89f6e3eb91cf90c
} catch (PDOException $e) {
    echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h3>Erro ao processar a solicitação no Banco de Dados.</h3>";
    echo "<p>Detalhes: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='../views/clientes.php'>Voltar para a tela de Clientes</a>";
    echo "</div>";
}
?>