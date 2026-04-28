<!-- Arquivo:
classes/Cliente.php (ou conforme estrutura do projeto)

Atributos esperados:

id

usuario_id

telefone

cpf

Métodos obrigatórios:

inserir(): bool

atualizar(): bool

listar(): array

buscarPorId(int $id): bool

buscarPorUsuario(int $usuario_id): bool -->

<?php 
include_once "config/conexao.php";

class Cliente
{
    private $id;
    private $usuario_id;
    private $telefone;
    private $cpf;
    private $pdo;
    public function __construct()
    {
        $this->pdo = obterPdo();
    }

    
// ======================================================================================

/*
SET -> DEFINE o valor

GET -> RETORNA o valor
*/


    // ID
    public function getId()
    {
        return $this->id; 
    }


    // usuario_id
    public function getUsuario_id()
    {
        return $this->usuario_id; 
    }

        public function setUsuario_id(int $usuario_id)
        {
            $this->usuario_id =$usuario_id;
        }

    //Telefone
    public function getTelefone()
    {
        return $this->telefone; 
    }

        public function setTelefone(string $telefone)
        {
            $this->telefone =$telefone;
        }

    // CPF
    public function getCpf()
    {
        return $this->cpf; 
    }

        public function setCpf(int $cpf)
        {
            $this->cpf = $cpf;
        }


// ======================================================================================


// Método Login

// public static function efetuarLogin (int $id, int $usuario_id, int $telefone, int $cpf): array 


// ======================================================================================

//Método INSERIR
public function inserir(): bool
{
    $sql = "INSERT clientes (usuario_id, telefone, cpf) VALUES (:usuario_id, :telefone, :cpf)";
    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":usuario_id", $this->usuario_id, PDO::PARAM_INT);
    $cmd->bindValue(":telefone", $this->telefone);
    $cmd->bindValue(":cpf", $this->cpf);    
    if ($cmd->execute()){
        $this->id = $this->pdo->lastInsertId();
        return true;
    }
    return false;
}

// Método ATUALIZAR
    public function atualizar():bool{
        if (!$this->id) return false;
        $sql = "UPDATE clientes SET telefone = :telefone, cpf = :cpf WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue("usuario_id", $this->usuario_id, PDO::PARAM_INT);
        $cmd->bindValue("telefone", $this->telefone);
        $cmd->bindValue("cpf", $this->cpf);
        return $cmd->execute();
    }

// Método LISTAR
public static function listar(): array
{
    $cmd = obterPdo()->query("SELECT * FROM clientes ORDER BY id desc");
    return $cmd->fetchALL(PDO::FETCH_ASSOC);
}

// Bucar por ID
public function buscarPorId(int $id): bool
{
    $sql = "SELECT * FROM clientes WHERE id=:id";
    $cmd = obterPdo()->prepare($sql);
    $cmd->bindValue(":id",$id);
    $cmd->execute();
    if($cmd->rowCount()>0){
    $dados = $cmd->fetch(PDO::FETCH_ASSOC);
    $this->id = $dados["id"];
    $this->usuario_id = $dados["usuario_id"];
    $this->telefone = $dados["telefone"];
    $this->cpf = $ $dados["cpf"];
    return true;
    }
    return false;
}

// Buscar por USUARIO   
public function buscarPorUsuario(int $usuario_id): bool
{
    $sql = "SELECT * FROM clientes WHERE usuario_id=:usuario_id";
    $cmd = obterPdo()->prepare($sql);
    $cmd->bindValue(":usuario_id",$usuario_id);
    $cmd->execute();
    if($cmd->rowCount()>0){
    $dados = $cmd->fetch(PDO::FETCH_ASSOC);
    $this->id = $dados["id"];
    $this->usuario_id = $dados["usuario_id"];
    $this->telefone = $dados["telefone"];
    $this->cpf = $dados["cpf"];
    return true;
        }
    return false;
    }
// ======================================================================================
}

?>