<<<<<<< HEAD
<?php
require_once 'conexao.inc.php';

class categoriaDao{
    private $con;

    function __construct(){
        $conexao = new ConexaoDao();
        $this->con = $conexao->getConexao();
    }

    public function getCategorias(){
        $rs = $this->con->query("SELECT * FROM categoria ORDER BY descricao");

        $lista = array();
        while($registro = $rs->fetch(PDO::FETCH_OBJ)){
            $lista[] = $registro;
        }
        return $lista;
    }

    public function buscarPorId($id){
        $sql = $this->con->prepare("SELECT * FROM categoria WHERE id_categoria = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function inserir($descricao, $valor){
        // Como id_categoria não é AUTO_INCREMENT no banco, geramos o próximo id disponível
        $rs = $this->con->query("SELECT COALESCE(MAX(id_categoria), 0) + 1 AS proximo_id FROM categoria");
        $proximoId = $rs->fetch(PDO::FETCH_OBJ)->proximo_id;

        $sql = $this->con->prepare("INSERT INTO categoria (id_categoria, descricao, valor) VALUES (:id, :descricao, :valor)");
        $sql->bindValue(':id', $proximoId);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':valor', $valor);
        $sql->execute();
    }

    public function atualizar($id, $descricao, $valor){
        $sql = $this->con->prepare("UPDATE categoria SET descricao = :descricao, valor = :valor WHERE id_categoria = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':valor', $valor);
        $sql->execute();
    }

    public function excluir($id){
        $sql = $this->con->prepare("DELETE FROM categoria WHERE id_categoria = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    // Verifica se existe algum veículo usando essa categoria (impede exclusão indevida)
    public function estaEmUso($id){
        $sql = $this->con->prepare("SELECT COUNT(*) AS total FROM veiculos WHERE id_categoria = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ)->total > 0;
    }
}
?>
=======
<?php
require_once 'conexao.inc.php';

class categoriaDao{
    private $con;

    function __construct(){
        $conexao = new ConexaoDao();
        $this->con = $conexao->getConexao();
    }

    public function getCategorias(){
        $rs = $this->con->query("select * from categorias");

        $lista = array();        
        while($registro = $rs->fetch(PDO::FETCH_OBJ)){
                
            $lista[] = $registro;
        }
        return $lista;
    }

}


?>
>>>>>>> 9bbff463848663aae26627f0d89f6e3eb91cf90c
