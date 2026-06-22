<?php
session_start();

// 1. TRAVA DE SEGURANÇA (Regra de negócio fica no Controller)
if (!isset($_SESSION['usuario'])) {
    header('Location: ../views/login.php');
    exit;
}

// 2. PREPARAÇÃO DOS DADOS
$usuarioLogado = $_SESSION['usuario'];

// Descobre o perfil para mandar para a View
$perfil = isset($usuarioLogado['perfil']) ? $usuarioLogado['perfil'] : 'cliente'; 

/* * 💡 DICA SOBRE O DAO:
 * Se futuramente você quiser mostrar "Total de Carros Alugados" na tela, 
 * seria AQUI no Controller que você chamaria o DAO, por exemplo:
 * require_once('../dao/locacaoDAO.php');
 * $totalLocacoes = $locacaoDao->contarLocacoesAtivas();
 */

// 3. CHAMA A VIEW
// Depois de processar tudo, incluímos o arquivo visual para exibir a tela
require_once('../views/dashboard.php');
?>