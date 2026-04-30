<!-- 
 Arquivo:
classes/Servico.php

Atributos esperados:

id

nome

descricao

preco

descontinuado 
-->

<?php 
include_once "config/conexao.php";
class Servico
{
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $descontinuado;
    private $pdo;

// ======================================================================================

public function __construct()
{
    $this->pdo = obterPdo();
}

// ID
public function getId()
{
    return $this->id;
}
public function setId (int $id)
{
    $this->id = $id;
}

// NOME
public function getNome()
{
    return $this->nome;
}
public function setNome(string $nome)
{
    $this->nome = $nome;
}

// DESCRIÇÃO
public function getDescricao()
{
    return $this->descricao;
}
public function setDescricao(string $descricao)
{
    $this->descricao = $descricao;
}

// DESCONTINUADO
public function getDescontinuado()
{
    return $this->descontinuado;
}
public function setDescontinuado(string $descontinuado)
{
    $this->descontinuado = $descontinuado;
}

public function getPreco()
{
    return $this->preco;
}

public function setPreco(int $preco)
{
    $this->preco = $preco;
}

// ======================================================================================

// INSERIR
public function inserir(): bool
{
    $sql = "INSERT servicos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)";
    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":nome", $this->nome);
    $cmd->bindValue(":descricao", $this->descricao);
    $cmd->bindValue(":preco", $this->preco);
    if ($cmd->execute()){
        $this->id = $this->pdo->lastInsertId();
        return true;
        }
        return false;
        }

        
        public function atualizar(): bool {
            if(!$this->id) return false;
            $sql = "UPDATE servicos SET nome = :nome, descricao = :descricao, descontinuado = :descontinuado WHERE id = :id";
            $cmd = $this->pdo->prepare($sql);
            $cmd->bindValue(":nome", $this->nome);
    $cmd->bindValue(":descricao", $this->descricao);
    $cmd->bindValue(":preco", $this->preco);
    $cmd->bindValue(":id", $this->id);
        return $cmd->execute();
}

public function listar(): array
{
    $cmd = obterPdo()->query("SELECT * FROM servicos ORDER BY id desc");
    return $cmd->fetchAll(PDO::FETCH_ASSOC);    
}

public static function listarAtivos(): array
{
    $cmd = obterPdo()->query("SELECT * FROM servicos WHERE descontinuado = 0");
    return $cmd->fetchAll(PDO::FETCH_ASSOC);    
    }
    
    // Buscar por ID
    public function buscarAtivos(int $id): bool
    {
    $sql = "SELECT * FROM servicos WHERE id = :id";
    $cmd = obterPdo()->prepare($sql);
    $cmd->bindValue(":id",$id);
    $cmd->execute();
    if($cmd->rowCount()>0){
      $dados = $cmd->fetch(PDO::FETCH_ASSOC);
    $this->setId($dados['id']);
    $this->setNome($dados['nome']);
    $this->setDescricao($dados['descricao']);
    $this->setDescontinuado($dados['descontinuado']);
        return true;
        }
        return false;
        }
        
    public function excluir(int $id): bool
    {
        $sql = "UPDAE servicOs SET descontinuado = 1 WHERE id - :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id",$id);
        return $cmd->execute();
    }

    }
// EXCLUIR
// Pendente


/*
Métodos obrigatórios:

inserir(): bool

atualizar(): bool

listar(): array

listarAtivos(): array

buscarPorId(int $id): bool

excluir(int $id): bool (pode ser exclusão lógica usando descontinuado)
*/


?>