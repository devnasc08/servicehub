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
class Servico
{
    private $id;
    private $nome;
    private $descricao;
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

// ======================================================================================

// INSERIR
public function inserir(): bool
{
    $sql = "INSERT servico (nome, descricao, descontinuado) VALUES (:nome, :descricao, :descontinuado)";
    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":nome", $this->nome);
    $cmd->bindValue(":descricao", $this->descricao);
    $cmd->bindValue(":descontinuado", $this->descontinuado);
    if ($cmd->execute()){
        $this->id = $this->pdo->lastInsertId();
        return true;
    }
    return false;
}

public function atualizar(): bool {
    if(!$this->id) return false;
    $sql = "UPDATE servico SET nome = :nome, descricao = :descricao, descontinuado = :descontinuado";
    $cmd = $this->pdo->prepare($sql);
    $cmd->bindValue(":nome", $this->nome);
    $cmd->bindValue(":descricao", $this->descricao);
    $cmd->bindValue(":descontinuado", $this->descontinuado);
        return $cmd->execute();
}

public function listar(): array
{
    $cmd = obterPdo()->query("SELECT * FROM servicos ORDER BY id desc");
    return $cmd->fetchAll(PDO::FETCH_ASSOC);    
}

public function listarAtivos(): array
{
    $cmd = obterPdo()->query("SELECT * FROM servicos ORDER BY descontinuado desc");
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
        $cmd->fetch(PDO::FETCH_ASSOC);
    $this->setId($cmd['id']);
    $this->setNome($cmd['nome']);
    $this->setDescricao($cmd['descricao']);
    $this->setDescontinuado($cmd['descontinuado']);
        return true;
    }
    return false;
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

}
?>