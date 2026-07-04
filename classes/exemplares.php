
<?php
class exemplares {
    private $id_exemplar;
    private $placa_veiculo;
    private $id_locacao;
    private $locado;

    public function __construct($id_exemplar, $placa_veiculo, $id_locacao, $locado) {
        $this->id_exemplar = $id_exemplar;
        $this->placa_veiculo = $placa_veiculo;
        $this->id_locacao = $id_locacao;
        $this->locado = $locado;
    }

    // Getters
    public function getIdExemplar() {
        return $this->id_exemplar;
    }

    public function getPlacaVeiculo() {
        return $this->placa_veiculo;
    }

    public function getIdLocacao() {
        return $this->id_locacao;
    }

    public function getLocado() {
        return $this->locado;
    }

    // Setters
    public function setIdExemplar($id_exemplar) {
        $this->id_exemplar = $id_exemplar;
    }

    public function setPlacaVeiculo($placa_veiculo) {
        $this->placa_veiculo = $placa_veiculo;
    }

    public function setIdLocacao($id_locacao) {
        $this->id_locacao = $id_locacao;
    }

    public function setLocado($locado) {
        $this->locado = $locado;
    }
}
?>