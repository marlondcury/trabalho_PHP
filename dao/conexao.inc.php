<<<<<<< HEAD
<?php
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



=======
<?php
class Conexao {
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



>>>>>>> 9bbff463848663aae26627f0d89f6e3eb91cf90c
