<?php

class usuariosDao {
    
    private $conexao;

    public function __construct() {
        $host = 'localhost';
        $db   = 'locadora_veiculos'; // Seu banco de dados
        $user = 'root';
        $pass = 'root'; 

        try {
            $this->conexao = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function autenticar($email, $senha) {
        try {
            $sql = "SELECT * FROM usuarios WHERE user = :user AND senha = :senha";
            $stmt = $this->conexao->prepare($sql);
            
            $stmt->bindValue(':user', $email);
            $stmt->bindValue(':senha', $senha);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }

        } catch(PDOException $e) {
            die("Erro ao autenticar usuário: " . $e->getMessage());
        }
    }
}
?>
