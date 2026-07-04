<?php 
require_once 'conexao.inc.php';
require_once '../classes/veiculo.php';

class VeiculoDAO
{
    private $con;

    public function __construct(){
        $conexao = new ConexaoDao();
        $this->con = $conexao->getConexao();
    }

    public function inserir(Veiculo $veiculo)
    {
        $sql = $this->con->prepare("INSERT INTO veiculos (placa, nome, anoFabricacao, fabricante, opcionais, motorizacao, 
        valorBase, id_categoria, veiculo_id, disponivel) VALUES (:placa, :nome, :anoFabricacao, :fabricante, :opcionais, :motorizacao, :valorBase, :id_categoria, :veiculo_id, 1)");
        $sql->bindValue(':placa', $veiculo->getPlaca());
        $sql->bindValue(':nome', $veiculo->getNome());
        $sql->bindValue(':anoFabricacao', $veiculo->getAnoFabricacao());
        $sql->bindValue(':fabricante', $veiculo->getFabricante());
        $sql->bindValue(':opcionais', $veiculo->getOpcionais());
        $sql->bindValue(':motorizacao', $veiculo->getMotorizacao());
        $sql->bindValue(':valorBase', $veiculo->getValorBase());
        $sql->bindValue(':id_categoria', $veiculo->getIdCategoria());
        $sql->bindValue(':veiculo_id', $veiculo->getVeiculoId());
        //$sql->bindValue(1, 1);
        $sql->execute();
        
    }


   /* public function listar()
    {
        $sql = $this->con->prepare("SELECT * FROM veiculos");
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_OBJ);
    }*/


public function getVeiculos() {
    $rs = $this->con->query("SELECT * FROM veiculos");

    $lista = array();
    while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
        $veiculo = new Veiculo();
        $veiculo->setPlaca($row->placa);
        $veiculo->setNome($row->nome);
        $veiculo->setAnoFabricacao($row->anoFabricacao);
        $veiculo->setFabricante($row->fabricante);
        $veiculo->setOpcionais($row->opcionais);
        $veiculo->setMotorizacao($row->motorizacao);
        $veiculo->setValorBase($row->valorBase);
        $veiculo->setIdCategoria($row->id_categoria);
        $veiculo->setVeiculoId($row->veiculo_id);
        $veiculo->setDisponivel($row->disponivel);
        $lista[] = $veiculo;
    }

    return $lista;
}  
public function excluirVeiculo($id)
    {
        $sql = $this->con->prepare("DELETE FROM veiculos WHERE veiculo_id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function buscarVeiculoPorId($id)
    {
        $sql = $this->con->prepare("SELECT * FROM veiculos WHERE veiculo_id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        

            $row = $sql->fetch(PDO::FETCH_OBJ);
            $veiculo = new Veiculo();
            $veiculo->setPlaca($row->placa);
            $veiculo->setNome($row->nome);
            $veiculo->setAnoFabricacao($row->anoFabricacao);
            $veiculo->setFabricante($row->fabricante);
            $veiculo->setOpcionais($row->opcionais);
            $veiculo->setMotorizacao($row->motorizacao);
            $veiculo->setValorBase($row->valorBase);
            $veiculo->setIdCategoria($row->id_categoria);
            $veiculo->setVeiculoId($row->veiculo_id);
            $veiculo->setDisponivel($row->disponivel);
    
          return $veiculo;
    }


    public function atualizar(Veiculo $veiculo)
    {
        $sql = $this->con->prepare("UPDATE veiculos SET nome = :nome, anoFabricacao = :anoFabricacao, fabricante = :fabricante, opcionais = :opcionais, 
        motorizacao = :motorizacao, valorBase = :valorBase, id_categoria = :id_categoria WHERE veiculo_id = :veiculo_id");
        $sql->bindValue(':veiculo_id', $veiculo->getVeiculoId());
        $sql->bindValue(':nome', $veiculo->getNome());
        $sql->bindValue(':anoFabricacao', $veiculo->getAnoFabricacao());
        $sql->bindValue(':fabricante', $veiculo->getFabricante());
        $sql->bindValue(':opcionais', $veiculo->getOpcionais());
        $sql->bindValue(':motorizacao', $veiculo->getMotorizacao());
        $sql->bindValue(':valorBase', $veiculo->getValorBase());
        $sql->bindValue(':id_categoria', $veiculo->getIdCategoria());
        $sql->execute();
    }


    public function buscarComFiltros($filtros){
    $sql = "SELECT * FROM veiculos WHERE 1=1";
    $params = [];

    if (!empty($filtros['placa'])) {
        $sql .= " AND placa LIKE :placa";
        $params[':placa'] = "%" . $filtros['placa'] . "%";
    }
    if (!empty($filtros['nome'])) {
        $sql .= " AND nome LIKE :nome";
        $params[':nome'] = "%" . $filtros['nome'] . "%";
    }
    if (!empty($filtros['fabricante'])) {
        $sql .= " AND fabricante LIKE :fabricante";
        $params[':fabricante'] = "%" . $filtros['fabricante'] . "%";
    }
    if (!empty($filtros['motorizacao'])) {
        $sql .= " AND motorizacao LIKE :motorizacao";
        $params[':motorizacao'] = "%" . $filtros['motorizacao'] . "%";
    }

    $sql = $this->con->prepare($sql);
    foreach ($params as $key => $value) {
        $sql->bindValue($key, $value);
    }
    $sql->execute();

    $lista = array();
    while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
        $veiculo = new Veiculo();
        $veiculo->setPlaca($row->placa);
        $veiculo->setNome($row->nome);
        $veiculo->setAnoFabricacao($row->anoFabricacao);
        $veiculo->setFabricante($row->fabricante);
        $veiculo->setOpcionais($row->opcionais);
        $veiculo->setMotorizacao($row->motorizacao);
        $veiculo->setValorBase($row->valorBase);
        $veiculo->setIdCategoria($row->id_categoria);
        $veiculo->setVeiculoId($row->veiculo_id);
        $veiculo->setDisponivel($row->disponivel);
        $lista[] = $veiculo;
    }
    return $lista;
}






}


?>