<?php
require_once '../classes/veiculo.php';
session_start();

$resultados = $_SESSION['veiculos'] ?? [];

unset($_SESSION['veiculos']);

include("menu.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultados da Busca | Locadora Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/trabalho_PHP/css/style.css">
</head>
<body>

<section class="page-header bg-primary text-white py-3">
    <div class="container">
        <h1 class="fw-bold">Resultados da Pesquisa</h1>
        <p class="mb-0 opacity-75">Veículos encontrados no sistema.</p>
    </div>
</section>

<div class="container py-5">
    <div class="card p-4">
        <?php if (empty($resultados)){ ?>
            <div class="alert alert-warning mb-0">Nenhum veículo encontrado com os filtros informados.</div>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Placa</th>
                            <th>Nome</th>
                            <th>Fabricante</th>
                            <th>Motorização</th>
                            <th>Disponibilidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $v){ ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?php echo $v->getPlaca(); ?></span></td>
                                <td><strong><?php echo $v->getNome(); ?></strong></td>
                                <td><?php echo $v->getFabricante(); ?></td>
                                <td><?php echo $v->getMotorizacao(); ?></td>
                                <td>
                                    <?php if ($v->getDisponivel() == 1) { ?>
                                        <span class="badge bg-success">Disponível</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Indisponível</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="../controllers/controllerVeiculo.php?op=4&id=<?php echo $v->getVeiculoId(); ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="../controllers/controllerVeiculo.php?op=3&id=<?php echo $v->getVeiculoId(); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        
        <div class="mt-4">
            <a href="buscaVeiculo.php" class="btn btn-outline-secondary">Nova Busca</a>
        </div>
    </div>
</div>

<?php require_once "includes/rodape.inc.php" ?>
</body>
</html>