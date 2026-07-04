<?php 
		
    class usuario{
        private $user;
        private $senha;

        public function __construct($user, $senha){
            $this->user = $user;
            $this->senha = $senha;
        }
        public function getUsuario(){
            return $this->user;
        }
        public function getSenha(){
            return $this->senha;
        }

    }
?>