
<?php 
class locacao {
    private $id_locacao;
    private $data;
    private $data_fim;
    private $valor_total;
    private $cpf_socio;
    private $id_veiculo;

    public function __construct($id_locacao, $data, $data_fim, $valor_total, $cpf_socio, $id_veiculo) {
        $this->id_locacao = $id_locacao;
        $this->data = $data;
        $this->data_fim = $data_fim;
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

    public function getDataFim() {
        return $this->data_fim;
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

    public function setDataFim($data_fim) {
        $this->data_fim = $data_fim;
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