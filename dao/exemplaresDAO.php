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