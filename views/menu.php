<?php
// Garante que a sessão está iniciada para ler o perfil
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica quem está acessando e chama o arquivo correspondente da pasta 'includes'
if (!isset($_SESSION['usuarioLogado'])) {
    // Se não tem ninguém logado, mostra o menu de visitante
    include 'includes/menu.inc.php';
} else {
    // Se está logado, verifica a letra do perfil (a = adm, c = cliente)
    if ($_SESSION['perfil'] == 'A') {
        include 'includes/menuA.inc.php';
    } else {
        // Crie o arquivo menuC.inc.php na pasta includes para o cliente!
        include 'includes/menuC.inc.php';
    }
}
?>