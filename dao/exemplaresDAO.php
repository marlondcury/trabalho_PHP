<<<<<<< HEAD
<?php
require_once 'conexao.inc.php';

class exemplaresDao{
    private $con;

    function __construct(){
        $conexao = new ConexaoDao();
        $this->con = $conexao->getConexao();
    }

    public function getExemplares(){
        $rs = $this->con->query("
            SELECT e.*, v.nome AS nome_veiculo
            FROM exemplares e
            LEFT JOIN veiculos v ON e.placa_veiculo = v.placa
            ORDER BY e.id_exemplar
        ");

        $lista = array();
        while($registro = $rs->fetch(PDO::FETCH_OBJ)){
            $lista[] = $registro;
        }
        return $lista;
    }

    public function buscarPorId($id){
        $sql = $this->con->prepare("SELECT * FROM exemplares WHERE id_exemplar = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function inserir($placaVeiculo, $idLocacao, $locado){
        $rs = $this->con->query("SELECT COALESCE(MAX(id_exemplar), 0) + 1 AS proximo_id FROM exemplares");
        $proximoId = $rs->fetch(PDO::FETCH_OBJ)->proximo_id;

        $sql = $this->con->prepare("INSERT INTO exemplares (id_exemplar, placa_veiculo, id_locacao, locado) VALUES (:id, :placa, :id_locacao, :locado)");
        $sql->bindValue(':id', $proximoId);
        $sql->bindValue(':placa', $placaVeiculo);
        $sql->bindValue(':id_locacao', $idLocacao);
        $sql->bindValue(':locado', $locado);
        $sql->execute();
    }

    public function atualizar($id, $placaVeiculo, $idLocacao, $locado){
        $sql = $this->con->prepare("UPDATE exemplares SET placa_veiculo = :placa, id_locacao = :id_locacao, locado = :locado WHERE id_exemplar = :id");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':placa', $placaVeiculo);
        $sql->bindValue(':id_locacao', $idLocacao);
        $sql->bindValue(':locado', $locado);
        $sql->execute();
    }

    public function excluir($id){
        $sql = $this->con->prepare("DELETE FROM exemplares WHERE id_exemplar = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}
?>
=======
<?php
require_once 'conexao.inc.php';

class exemplaresDao{
    private $con;

    function __construct(){
        $conexao = new ConexaoDao();
        $this->con = $conexao->getConexao();
    }

    public function getExemplares(){
        $rs = $this->con->query("select * from exemplares");

        $lista = array();        
        while($registro = $rs->fetch(PDO::FETCH_OBJ)){
                
            $lista[] = $registro;
        }
        return $lista;
    }

}


?>
>>>>>>> 9bbff463848663aae26627f0d89f6e3eb91cf90c
