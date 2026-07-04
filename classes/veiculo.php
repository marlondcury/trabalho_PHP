<?php 
class Veiculo{
  private $placa;
  private $nome;
  private $anoFabricacao;
  private $fabricante;
  private $opcionais;
  private $motorizacao;
  private $valorBase;
  private $id_categoria;
  private $veiculo_id;
  private $disponivel;



  function __construct() {
    // Construtor vazio
  }

   public function setVeiculo($placa, $nome, $anoFabricacao, $fabricante, $opcionais, $motorizacao, $valorBase, $id_categoria, $veiculo_id){
        $this->placa = $placa;
        $this->nome = $nome;
        $this->anoFabricacao = $anoFabricacao;
        $this->fabricante = $fabricante;
        $this->opcionais = $opcionais;
        $this->motorizacao = $motorizacao;
        $this->valorBase = $valorBase;
        $this->id_categoria = $id_categoria;
        $this->veiculo_id = $veiculo_id;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getAnoFabricacao() {
        return $this->anoFabricacao;
    }

    public function getFabricante() {
        return $this->fabricante;
    }

    public function getOpcionais() {
        return $this->opcionais;
    }

    public function getMotorizacao(){ 
        return $this->motorizacao;
    }

    public function getValorBase() {
        return $this->valorBase;
    
  }

    public function getIdCategoria() {
        return $this->id_categoria;
    
  }
    public function getVeiculoId() {
        return $this->veiculo_id;
    }

    public function setVeiculoId($veiculo_id) {
        $this->veiculo_id = $veiculo_id;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function setIdCategoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function setAnoFabricacao($anoFabricacao) {
        $this->anoFabricacao = $anoFabricacao;
    }
    public function setFabricante($fabricante) {
        $this->fabricante = $fabricante;
    }
    public function setOpcionais($opcionais) {
        $this->opcionais = $opcionais;
    }
    public function setMotorizacao($motorizacao) {
        $this->motorizacao = $motorizacao;
    }
    public function setValorBase($valorBase) {
        $this->valorBase = $valorBase;
    }
   
    public function getDisponivel() {
    return $this->disponivel;
    }

    public function setDisponivel($disponivel) {
    $this->disponivel = $disponivel;
    }
}