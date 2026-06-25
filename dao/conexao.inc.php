<?php

class ConexaoDao
{
      private $servidor_mysql = '127.0.0.1;port=8889';
      private $nome_banco = 'locadoraVeiculos';
      private $usuario = 'root';
      private $senha = 'root'; 
      private $con;

      public function getConexao()
      {
            $this->con = new PDO("mysql:host=$this->servidor_mysql;dbname=$this->nome_banco","$this->usuario","$this->senha");
            return $this->con;
      }
}

?>