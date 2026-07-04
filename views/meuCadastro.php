<?php
session_start();

if (!isset($_SESSION['usuarioLogado']) || $_SESSION['perfil'] != 'C') {
    header("Location: dashboard.php");
    exit;
}

require_once '../dao/conexao.inc.php';
$conexao = new ConexaoDao();
$pdo = $conexao->getConexao();

$email = $_SESSION['usuarioLogado']['email'];

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = :email");
$stmt->execute(['email' => $email]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    include("menu.php");
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meu Cadastro | Locadora Web</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
    </head>
    <body>
    <div class="container py-5">
        <div class="alert alert-danger">
            Não encontramos um cadastro de cliente vinculado ao seu login (<strong><?= htmlspecialchars($email) ?></strong>).
            Procure o administrador do sistema para regularizar seu cadastro.
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary">Voltar ao Painel</a>
    </div>
    <?php
    require_once "includes/rodape.inc.php";
    exit;
}

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Cadastro | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header py-5">
    <div class="container">
        <h1 class="fw-bold mb-0">Meu Cadastro</h1>
        <p class="opacity-75">Consulte e atualize seus próprios dados.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">Seus dados foram atualizados com sucesso.</div>
            <?php endif; ?>

            <?php if (isset($_GET['erro']) && $_GET['erro'] == 'locacaoAberta'): ?>
            <div class="alert alert-danger">
                Não é possível excluir seu cadastro enquanto houver uma locação em aberto. Conclua a devolução do veículo primeiro.
            </div>
            <?php endif; ?>

            <div class="card card-moderno p-4 p-md-5 mb-4">
                <form action="../controllers/controllerCliente.php" method="POST">
                    <input type="hidden" name="acao" value="editarProprio">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CPF</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cliente['cpf']) ?>" readonly style="background-color: #e9ecef;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">RG</label>
                            <input type="text" name="rg" class="form-control" value="<?= htmlspecialchars($cliente['rg']) ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Endereço</label>
                            <input type="text" name="endereco" class="form-control" value="<?= htmlspecialchars($cliente['endereco']) ?>" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-acao px-4">Salvar Alterações</button>
                    </div>
                </form>
            </div>

            <div class="card card-moderno p-4 border border-danger-subtle">
                <h5 class="fw-bold text-danger mb-2">Excluir minha conta</h5>
                <p class="text-muted mb-3">
                    Esta ação é permanente. Seu cadastro e seu acesso ao sistema serão removidos.
                    Não é possível excluir a conta enquanto houver uma locação em aberto.
                </p>
                <form action="../controllers/controllerCliente.php" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.');">
                    <input type="hidden" name="acao" value="excluirProprio">
                    <button type="submit" class="btn btn-outline-danger">Excluir minha conta</button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
