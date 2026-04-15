<?php
// Importando conexão
include_once "config/conexao.php";


// declarar classe
// A classe representa a estrutura lógica de um usuário | Tudo que um usuário possui e faz
class Usuario
{
    //atributos = Estado do Objeto
    // Informações internas do usuário
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo;
    private $ativo;
    private $primeiro_login;
    private $pdo;
    // Private significa que só a própria classe acessa




    //  CONSTRUTOR  = Preparação automática
    /*sempre que um objeto for criado: $user = new usuario();
    esse método roda sozinho*/
    public function __construct()
    {
        $this->pdo = obterPdo(); //quando utilizar  
        // A classe precisa acessar o banco, em vez de abrir a conexão toda hora, ela já guarda a função  
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
        //pega valor recebido e salva no atributo interno
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
    {  //Risco de Segurança | nunca salvar em texto puro | transformar a senha em hash
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
        // Define se o usuário está no primeiro acesso
        $this->primeiro_login = $primeiro_login;
    }




    // MÉTODO DE LOGIN (RN) (functions) - Representar RFs
    public static function efetuarLogin(string $email, string $senha):array{
        //Busca usuário pelo email | A senha NÃO entra no sql | primeiro busca usuário 
        $sql = "SELECT * FROM usuarios WHERE email = :email AND ativo = b'1'";
        // Prepara a consulta para segurança 
        $cmd = obterPdo()->prepare($sql);
        //$cmd = $this->pdo->prepare($sql); //Atributo da classe usuário (private $pdo) Linha 16
        // Envia Email para o parâmetro
        $cmd->bindValue(":email", $email);

        //executa busca
        $cmd->execute();

        // Pega os dados encontrados:
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);

        // 2 - VALIDAR SE O USUÁRIO EXISTE | se $dados existir, True

        //password verify compara a senha digitada com a senha criptografada no banco
        if ($dados && password_verify($senha, $dados['senha'])) {
            
            // retorna sucesso + dados
            return $dados;
        } 
        
        //login falhou | usuário não existe ou senha inválida
        else {
            return $dados = [];  //ou somente []
        }
    }
}
