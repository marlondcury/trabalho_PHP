<?php include("menu.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato | Locadora Web</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="header-contato">
    <div class="container">
        <h1 class="fw-bold">Fale Conosco</h1>
        <p class="mb-0 opacity-75">Envie sua mensagem para nossa equipe.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-contato p-4 p-md-5">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nome</label>
                            <input type="text" class="form-control" placeholder="Seu nome">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" placeholder="seuemail@exemplo.com">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Assunto</label>
                            <input type="text" class="form-control" placeholder="Sobre o que deseja falar?">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Mensagem</label>
                            <textarea class="form-control" rows="6" placeholder="Digite sua mensagem..."></textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-enviar">
                            Enviar mensagem
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-contato p-4 h-100">
                <h4 class="fw-bold mb-3">Informações</h4>
                <p class="text-muted mb-2">📍 Endereço: Rua dos bobos, 0</p>
                <p class="text-muted mb-2">📞 Telefone: (27) 99999-9999</p>
                <p class="text-muted mb-2">✉️ Email: contato@locadoraweb.com</p>
                <hr>
                <p class="text-muted mb-0">
                    Atendimento de segunda a sexta, das 8h às 18h.
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
