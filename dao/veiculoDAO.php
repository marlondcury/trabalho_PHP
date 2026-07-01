<?php 
require_once 'conexao.inc.php';

class VeiculoDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = new ConexaoDao();
    }

    public function inserir($veiculo)
    {
        $stmt = $this->conexao->getConexao()->prepare("INSERT INTO veiculos (marca, modelo, ano, cor) VALUES (?, ?, ?, ?)");
        $stmt->execute([$veiculo->getMarca(), $veiculo->getModelo(), $veiculo->getAno(), $veiculo->getCor()]);
    }

    public function listar()
    {
        $stmt = $this->conexao->getConexao()->prepare("SELECT * FROM veiculos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}  
?>