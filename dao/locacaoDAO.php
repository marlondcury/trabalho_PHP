<?php
require_once 'conexao.inc.php';

class locacaoDao {
    private $con;

    function __construct() {
        $conexao = new ConexaoDao();
        $this->con = $conexao->getConexao();
    }

    public function getLocacoes() {
        $rs = $this->con->query("SELECT * FROM locacao ORDER BY id_locacao DESC");
        return $rs->fetchAll(PDO::FETCH_ASSOC);
    }

    // Um cliente só pode ter uma locação por vez: bloqueia se já existir
    // alguma locação dele ainda não devolvida (marcada pelo admin), independente
    // das datas da nova locação.
    public function possuiLocacaoAtiva($cpf, $id_locacao_ignorar = null) {
        $sql = "SELECT * FROM locacao
                WHERE cpf_socio = :cpf
                  AND devolvida = 0";
        if ($id_locacao_ignorar !== null) {
            $sql .= " AND id_locacao != :id_locacao_ignorar";
        }

        $rs = $this->con->prepare($sql);
        $params = [':cpf' => $cpf];
        if ($id_locacao_ignorar !== null) {
            $params[':id_locacao_ignorar'] = $id_locacao_ignorar;
        }
        $rs->execute($params);
        return $rs->fetchAll(PDO::FETCH_ASSOC);
    }

    public function veiculoIndisponivel($id_veiculo, $data, $data_fim, $id_locacao_ignorar = null) {
        $sql = "SELECT COUNT(*) FROM locacao
                WHERE id_veiculo = :id_veiculo
                  AND :data_inicio <= COALESCE(data_fim, data)
                  AND :data_fim >= data";
        if ($id_locacao_ignorar !== null) {
            $sql .= " AND id_locacao != :id_locacao_ignorar";
        }

        $rs = $this->con->prepare($sql);
        $params = [
            ':id_veiculo' => $id_veiculo,
            ':data_inicio' => $data,
            ':data_fim' => $data_fim
        ];
        if ($id_locacao_ignorar !== null) {
            $params[':id_locacao_ignorar'] = $id_locacao_ignorar;
        }
        $rs->execute($params);
        return $rs->fetchColumn() > 0;
    }
}
?>

