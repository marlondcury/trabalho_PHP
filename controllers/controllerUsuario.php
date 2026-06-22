<?php

// Agora o nome bate 100% com o arquivo que acabamos de criar!
require_once(__DIR__ . '/../dao/usuariosDAO.php');

if (isset($_POST['entrar'])) { 
    $email = $_POST['login']; 
    $senha = $_POST['senha'];

    $usuariosDao = new usuariosDao();
    $usuarios = null;

    if (method_exists($usuariosDao, 'autenticar')) {
        $usuarios = $usuariosDao->autenticar($email, $senha);
    }

    if ($usuarios != NULL) { 
        session_start();
        $_SESSION['usuario'] = $usuarios;
        header('Location: controllerDashboard.php');   
        exit;
    } else { 
        header('Location: ../views/login.php?erro=1');
        exit;
    }
}

if (isset($_REQUEST['opcao']) && $_REQUEST['opcao'] == 2) { 
    session_start();
    unset($_SESSION['usuario']);
    header('Location: /LocadoraWeb/index.php');
    exit;
}

?>