
<?php 
class locacao {
    private $id_locacao;
    private $data;
    private $valor_total;
    private $cpf_socio;
    private $id_veiculo;

    public function __construct($id_locacao, $data, $valor_total, $cpf_socio, $id_veiculo) {
        $this->id_locacao = $id_locacao;
        $this->data = $data;
        $this->valor_total = $valor_total;
        $this->cpf_socio = $cpf_socio;
        $this->id_veiculo = $id_veiculo;
    }

    // Getters
    public function getIdLocacao() {
        return $this->id_locacao;
    }

    public function getData() {
        return $this->data;
    }

    public function getValorTotal() {
        return $this->valor_total;
    }

    public function getCpfSocio() {
        return $this->cpf_socio;
    }

    public function getIdVeiculo() {
        return $this->id_veiculo;
    }

    // Setters
    public function setIdLocacao($id_locacao) {
        $this->id_locacao = $id_locacao;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setValorTotal($valor_total) {
        $this->valor_total = $valor_total;
    }

    public function setCpfSocio($cpf_socio) {
        $this->cpf_socio = $cpf_socio;
    }

    public function setIdVeiculo($id_veiculo) {
        $this->id_veiculo = $id_veiculo;
    }
}
?>