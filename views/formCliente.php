<?php
session_start();

// Trava de segurança: Apenas Administrador ('a') acessa
if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'A') {
    header("Location: dashboard.php");
    exit;
}

// Variáveis padrão para "Novo Cliente"
$modoEdicao = false;
$cliente = [
    'cpf' => '',
    'nome' => '',
    'rg' => '',
    'endereco' => '',
    'telefone' => '',
    'email' => ''
];

// Se existir um CPF na URL, significa que estamos no modo "Editar"
if (isset($_GET['cpf'])) {
    $modoEdicao = true;
    
    require_once '../dao/conexao.inc.php';
    $conexao = new conexaoDao();
    $pdo = $conexao->getConexao();

    // Busca os dados atuais do cliente no banco
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE cpf = :cpf");
    $stmt->execute(['cpf' => $_GET['cpf']]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $cliente = $resultado; // Sobrescreve as variáveis vazias com os dados do banco
    } else {
        // Se tentou editar um CPF que não existe, devolve pra lista
        header("Location: clientes.php");
        exit;
    }
}

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $modoEdicao ? 'Editar Cliente' : 'Novo Cliente' ?> | Locadora Web</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/LocadoraWeb/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0"><?= $modoEdicao ? 'Editar Cliente' : 'Cadastrar Novo Cliente' ?></h1>
        <p class="opacity-75">Preencha os dados abaixo com atenção.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-moderno p-4 p-md-5">
                
                <form action="../controllers/controllerCliente.php" method="POST">
                    
                    <input type="hidden" name="acao" value="<?= $modoEdicao ? 'editar' : 'novo' ?>">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CPF</label>
                            <input type="text" name="cpf" class="form-control" placeholder="Apenas números" 
                                   value="<?= htmlspecialchars($cliente['cpf']) ?>" 
                                   <?= $modoEdicao ? 'readonly style="background-color: #e9ecef;"' : 'required' ?>>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">RG</label>
                            <input type="text" name="rg" class="form-control" placeholder="Apenas números" 
                                   value="<?= htmlspecialchars($cliente['rg']) ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" placeholder="Digite o nome completo" 
                                   value="<?= htmlspecialchars($cliente['nome']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="exemplo@email.com" 
                                   value="<?= htmlspecialchars($cliente['email']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="telefone" class="form-control" placeholder="(00) 00000-0000" 
                                   value="<?= htmlspecialchars($cliente['telefone']) ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Endereço Completo</label>
                            <input type="text" name="endereco" class="form-control" placeholder="Rua, Número, Bairro, Cidade" 
                                   value="<?= htmlspecialchars($cliente['endereco']) ?>" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="clientes.php" class="btn btn-outline-secondary btn-acao px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-acao px-4">
                            <?= $modoEdicao ? 'Salvar Alterações' : 'Cadastrar Cliente' ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>