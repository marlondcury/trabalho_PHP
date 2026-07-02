<?php 
class clientes {
    private $cpf;
    private $nome;
    private $rg;
    private $endereco;
    private $telefone;
    private $email;

    public function __construct($cpf, $nome, $rg, $endereco, $telefone, $email) {
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->rg = $rg;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    // Getters
    public function getCpf() {
        return $this->cpf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getRg() {
        return $this->rg;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    // Setters
    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setRg($rg) {
        $this->rg = $rg;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}
?>