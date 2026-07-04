<?php
// Inicia a sessão e faz a trava de segurança
session_start();
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

// Conecta ao banco de dados usando a sua classe Conexao
require_once '../dao/conexao.inc.php';
$conexao = new conexaoDao();;
$pdo = $conexao->getConexao();

// Busca todos os clientes cadastrados na tabela
$stmt = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inclui o menu 
include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Clientes | Locadora Web</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Clientes Cadastrados</h1>
        <p class="opacity-75">Gerencie os usuários da locadora.</p>
    </div>
</section>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark">Lista de Clientes</h3>
        <a href="formCliente.php" class="btn btn-primary btn-acao">
            + Novo Cliente
        </a>
    </div>

    <div class="card card-moderno p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary py-3">CPF</th>
                        <th class="text-secondary py-3">Nome</th>
                        <th class="text-secondary py-3">Telefone</th>
                        <th class="text-secondary py-3">Email</th>
                        <th class="text-secondary text-center py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cli): ?>
                        <tr>
                            <td class="py-3"><?= htmlspecialchars($cli['cpf']) ?></td>
                            <td class="py-3 fw-semibold text-dark"><?= htmlspecialchars($cli['nome']) ?></td>
                            <td class="py-3"><?= htmlspecialchars($cli['telefone']) ?></td>
                            <td class="py-3"><?= htmlspecialchars($cli['email']) ?></td>
                            <td class="py-3 text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="formCliente.php?cpf=<?= urlencode($cli['cpf']) ?>" class="btn btn-sm btn-outline-primary px-3">Editar</a>
                                    
                                    <a href="../controllers/controllerCliente.php?acao=excluir&cpf=<?= urlencode($cli['cpf']) ?>" 
                                       class="btn btn-sm btn-outline-danger px-3"
                                       onclick="return confirm('Tem certeza que deseja apagar o cliente <?= htmlspecialchars($cli['nome']) ?>? Esta ação não pode ser desfeita.');">
                                       Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Nenhum cliente cadastrado no banco de dados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>