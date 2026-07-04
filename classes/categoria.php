<<<<<<< HEAD
<?php 
class categoria {
    private $id_categoria;
    private $descricao;
    private $valor;

    public function __construct($id_categoria, $descricao, $valor) {
        $this->id_categoria = $id_categoria;
        $this->descricao = $descricao;
        $this->valor = $valor;
    }
    public function getIdCategoria() {
        return $this->id_categoria;
    }
    public function getDescricao() {
        return $this->descricao;
    }
    public function getValor() {
        return $this->valor;
    }
    public function setIdCategoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }
}
=======
<?php 
class categoria {
    private $id_categoria;
    private $descricao;
    private $valor;

    public function __construct($id_categoria, $descricao, $valor) {
        $this->id_categoria = $id_categoria;
        $this->descricao = $descricao;
        $this->valor = $valor;
    }
    public function getIdCategoria() {
        return $this->id_categoria;
    }
    public function getDescricao() {
        return $this->descricao;
    }
    public function getValor() {
        return $this->valor;
    }
    public function setIdCategoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }
}
>>>>>>> 9bbff463848663aae26627f0d89f6e3eb91cf90c
?>