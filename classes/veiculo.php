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

   public function __construct($placa, $nome, $anoFabricacao, $fabricante, $opcionais, $motorizacao, $valorBase, $id_categoria) {
        $this->placa = $placa;
        $this->nome = $nome;
        $this->anoFabricacao = $anoFabricacao;
        $this->fabricante = $fabricante;
        $this->opcionais = $opcionais;
        $this->motorizacao = $motorizacao;
        $this->valorBase = $valorBase;
        $this->id_categoria = $id_categoria;
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

    public function getMotorizacao() {
        return $this->motorizacao;
    }

    public function getValorBase() {
        return $this->valorBase;
    }

    public function getIdCategoria() {
        return $this->id_categoria;
    
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

}