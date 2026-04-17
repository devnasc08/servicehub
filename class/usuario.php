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

        public function setId(int $id)
    {
        $this->id = $id;
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
    public static function efetuarLogin(string $email, string $senha): array
    {
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
    // Inserir 
    public function inserir(): bool
    {

        $sql = "INSERT usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)"; // : Váriavel SQL
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":email", $this->email);
        $cmd->bindValue(":senha", password_hash($this->senha, PASSWORD_DEFAULT));
        $cmd->bindValue(":tipo", $this->tipo);
        if ($cmd->execute()) {
            $this->id = $this->pdo->lastInsertId();
            return true;
        }


        return false;
    }

    // Listar 
    public static function listar(): array
    {
        $cmd = obterPdo()->query("SELECT * FROM usuarios ORDER BY id desc");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por ID
    public function buscarPorId(int $id):bool
    {
        $sql = "SELECT * FROM usuarios WHERE id=:id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        if($cmd->rowCount()>0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        $this->setId($dados['id']);
        $this->setNome($dados['nome']);
        $this->setEmail($dados['email']);
        $this->setSenha($dados['senha']);
        $this->setTipo($dados['tipo']);
        $this->setAtivo($dados['ativo']);
        $this->primeiro_login = $dados['primeiro_login'];
            return true;
    
    }
        return false;
    }

    //Atualizar
    public function atualizar():bool{
        
        if(!$this->id)return false;
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo, ativo = :ativo, primeiro_login = :primeiro_login WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":email", $this->email);
        $cmd->bindValue(":senha", $this->senha);
        $cmd->bindValue(":tipo", $this->tipo);
        $cmd->bindValue(":ativo", $this->ativo, PDO::PARAM_BOOL);
        $cmd->bindValue(":primeiro_login", $this->primeiro_login,PDO::PARAM_BOOL);
        return $cmd->execute();
    }

    //Atualizar Senha (Já deve vir com password_hash)
    public function atualizarSenha (string $senhaHash):bool{
        if(!$this->id) return false;

        $sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":senha", $senhaHash,PDO::PARAM_INT);
        $cmd->bindValue(":id",$this->id);

        return $cmd->execute();
    }

}
