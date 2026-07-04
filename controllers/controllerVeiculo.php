<?php

require_once '../classes/veiculo.php';
require_once '../dao/veiculoDAO.php';

session_start();

$op = $_REQUEST['op'] ?? 0;

if($op == 1){ // inserir veículo

    $veiculo = new Veiculo();

    $veiculo->setVeiculo(
        $_REQUEST['placa'],
        $_REQUEST['nome'],
        $_REQUEST['anoFabricacao'],
        $_REQUEST['fabricante'],
        $_REQUEST['opcionais'],
        $_REQUEST['motorizacao'],
        $_REQUEST['valorBase'],
        $_REQUEST['id_categoria'],
        null
    );

    $veiculoDao = new VeiculoDAO();
    $veiculoDao->inserir($veiculo);

    header("Location: controllerVeiculo.php?op=2");
}
else{

    if($op == 2){ // listar todos

        $veiculoDao = new VeiculoDAO();

        $lista = $veiculoDao->getVeiculos();

        //session_start();
        $_SESSION['veiculos'] = $lista;

        header("Location: ../views/exibirBuscaVeiculo.php");

    }
    else{

        if($op == 3){ // excluir

            $id = $_REQUEST['id'];

            $veiculoDao = new VeiculoDAO();

            $veiculoDao->excluirVeiculo($id);

            header("Location: controllerVeiculo.php?op=2");

        }
        else{

            if($op == 4){ // buscar por ID (para alterar)

                $id = $_REQUEST['id'];

                $veiculoDao = new VeiculoDAO();

                $veiculo = $veiculoDao->buscarVeiculoPorId($id);

                //session_start();
                $_SESSION['veiculo'] = $veiculo;

                header("Location: ../views/formVeiculoAtualizar.php");

            }
            else{

                if($op == 5){ // alterar

                    $veiculo = new Veiculo();

                    $veiculo->setVeiculo(
                        $_REQUEST['placa'],
                        $_REQUEST['nome'],
                        $_REQUEST['anoFabricacao'],
                        $_REQUEST['fabricante'],
                        $_REQUEST['opcionais'],
                        $_REQUEST['motorizacao'],
                        $_REQUEST['valorBase'],
                        $_REQUEST['id_categoria'],
                        $_REQUEST['veiculo_id']
                    );

                    $veiculoDao = new VeiculoDAO();

                    $veiculoDao->atualizar($veiculo);

                    header("Location: controllerVeiculo.php?op=2");

                }
                else{

                    if($op == 6){ // busca com filtros
   
                        $filtros = [
                            'placa'       => $_REQUEST['placa']       ?? '',
                            'nome'        => $_REQUEST['nome']         ?? '',
                            'fabricante'  => $_REQUEST['fabricante']   ?? '',
                            'motorizacao' => $_REQUEST['motorizacao']  ?? '',
                        ];

                            $veiculoDao = new VeiculoDAO();
                            $lista = $veiculoDao->buscarComFiltros($filtros);
                            $_SESSION['veiculos'] = $lista;

                            header("Location: ../views/exibirBuscaVeiculo.php");

                       /* $placa = $_REQUEST['placa'] ?? "";
                        $nome = $_REQUEST['nome'] ?? "";
                        $fabricante = $_REQUEST['fabricante'] ?? "";
                        $motorizacao = $_REQUEST['motorizacao'] ?? "";

                        $veiculoDao = new VeiculoDAO();

                        $lista = $veiculoDao->buscar(
                            $placa,
                            $nome,
                            $fabricante,
                            $motorizacao
                        );

                        session_start();
                        $_SESSION['veiculos'] = $lista;

                        header("Location: ../views/exibirBuscaVeiculo.php");*/

                    }

                    }

            }

        }

    }

}

?>