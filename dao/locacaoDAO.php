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
}
?>

