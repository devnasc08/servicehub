<?php
// incluir conexão
include_once "config/conexao.php";


// declarar classe
class Usuario
{
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
        $this->pdo = obterPdo(); //quando utilizar    
    }


    //getters / setters

    // GET = pegar valor
    // SET = definir valor

    //ID
    public function getId()
    {
        return $this->id;
    }
    //Nome
    public function getNome()
    {
        return $this->nome;
    }

    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    //Email
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    //Senha
    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha(string $senha)
    {  //Risco de Segurança
        $this->senha = $senha;
    }

    //Tipo
    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo)
    {
        $this->tipo = $tipo;
    }

    //Ativo
    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setAtivo(string $ativo)
    {
        $this->ativo = $ativo;
    }

    //Primeiro Login
    public function getPrimeiroLogin()
    {
        return $this->primeiro_login;
    }

    public function setPrimeiroLogin(string $primeiro_login)
    {
        $this->primeiro_login = $primeiro_login;
    }




    //metodo (functions) - Representar RFs
    public static function efetuarLogin(string $email, string $senha)/*Espera Email e Senha*/:array{
        $sql = "SELECT * FROM usuarios WHERE email = :email AND ativo = b'1'";
        $cmd = obterPdo()->prepare($sql);
        //$cmd = $this->pdo->prepare($sql); //Atributo da classe usuário (private $pdo) Linha 16
        $cmd->bindValue(":email", $email);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if ($dados && password_verify($senha, $dados['senha'])) {
            return $dados;
        } else {
            return $dados = [];  //ou somente []
        }
    }
}
