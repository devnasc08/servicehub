<?php 
// incluir conexão
include_once "config/conexao.php";


// declarar classe
class usuario {
    //atributos
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo;
    private $ativo;
    private $primeiro_login;
    private $pdo;





    //construtor
    public function __construct()
    {
        $this -> pdo = obterPdo(); //quando utilizar    
    }
    
    
    //getters / setters

    //ID
    public function getId(){
        return $this->id;
    } 
    //Nome
    public function getNome (){
        return $this->nome;
    }

    public function setNome (string $nome){
        $this->nome = $nome;
    }

    //Email
     public function getEmail(){
        return $this->email;
    } 

    public function setEmail (string $email){
        $this->email = $email;
    }

    //Senha
     public function getSenha(){
        return $this->senha;
    } 

    public function setSenha (string $senha){  //Risco de Segurança
        $this->senha = $senha;
    }

    //Tipo
    public function getTipo(){
        return $this->tipo;
    } 

    public function setTipo (string $tipo){
        $this->tipo = $tipo;
    }    

    //Ativo
    public function getAtivo(){
        return $this->ativo;
    } 

    public function setAtivo (string $ativo){
        $this->ativo = $ativo;
    }

    //Primeiro Login
    public function getPrimeiroLogin(){
        return $this->primeiro_login;
    } 

    public function setPrimeiroLogin (string $primeiro_login){
        $this->ativo = $primeiro_login;
    }




    //metodo (functions) - Representar RFs
    
    
    
}




?>