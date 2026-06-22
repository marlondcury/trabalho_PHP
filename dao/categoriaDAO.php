<?php
require_once 'conexao.inc.php';

class categoriaDao{
    private $con;

    function __construct(){
        $conexao = new Conexao();
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