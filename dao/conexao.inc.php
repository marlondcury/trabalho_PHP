<?php
// Garante que date()/DateTime usem o horário de Brasília
date_default_timezone_set('America/Sao_Paulo');

class ConexaoDao {
    private $servidor_mysql = 'localhost';
    private $nome_banco = 'locadora_veiculos';
    private $usuario = 'root';
    private $senha = '';

    public function getConexao() {
        try {
            $con = new PDO(
                "mysql:host=$this->servidor_mysql;dbname=$this->nome_banco;charset=utf8",
                $this->usuario,
                $this->senha
            );
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}
?>

