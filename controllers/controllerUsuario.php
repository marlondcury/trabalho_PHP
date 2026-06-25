<?php
session_start();

// Importa a sua classe de conexão (Ajuste o caminho se a sua pasta DAO estiver em outro lugar)
require_once '../dao/conexao.inc.php'; 

// 1. Tratamento de Logout (Sair)
if (isset($_GET['acao']) && $_GET['acao'] == 'logout') {
    unset($_SESSION['usuarioLogado']);
    unset($_SESSION['perfil']);
    session_destroy();
    header("Location: ../views/index.php");
    exit;
}

// 2. Tratamento de Login (Entrar)
if (isset($_POST['entrar'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    try {
        // INSTANCIANDO O SEU DAO AQUI!
        $conexao = new ConexaoDao();
        $pdo = $conexao->getConexao();

        // PASSO 1: Verifica na tabela 'usuarios' se o login e senha batem
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE user = :login AND senha = :senha");
        $stmt->execute(['login' => $login, 'senha' => $senha]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) { 
            
                    // PASSO 2: Busca o nome na tabela 'clientes' usando o email
            $stmtCliente = $pdo->prepare("SELECT nome FROM clientes WHERE email = :login");
            $stmtCliente->execute(['login' => $login]);
            $clienteBanco = $stmtCliente->fetch(PDO::FETCH_ASSOC);

            // Se achou o cliente, usa o Nome. Se não achou, usa o próprio email.
            $nomeParaExibir = $clienteBanco ? $clienteBanco['nome'] : $usuario['user'];

            $perfil = $usuario['perfil'];
            // Salva na sessão
            $_SESSION['usuarioLogado'] = ['user' => $nomeParaExibir];
            $_SESSION['perfil'] = $perfil;

            // Redireciona para o Dashboard
            header("Location: ../views/dashboard.php");
            exit;

        } else {
            // Login ou senha incorretos, volta pra tela de login
            header("Location: ../views/login.php?erro=1");
            exit;
        }

    } catch (PDOException $e) {
        echo "Erro de conexão com o banco de dados: " . $e->getMessage();
    }
}
?>