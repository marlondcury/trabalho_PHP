<?php
require_once 'conexao.inc.php';

class locacaoDao{
    private $con;

    function __construct(){
        $conexao = new Conexao();
        $this->con = $conexao->getConexao();
    }

    public function getLocacoes(){
        $rs = $this->con->query("select * from locacoes");

        $lista = array();        
        while($registro = $rs->fetch(PDO::FETCH_OBJ)){
                
            $lista[] = $registro;
        }
        return $lista;
    }

}


?>