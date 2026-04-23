<!-- 

Atributos esperados:

id
cliente_id
descricao_problema
data_preferida
status
data_cad
data_atualizacao
data_resposta
resposta_admin
endereco

-->



<?php 
 include_once "config/conexao.php";

 class Solicitacao
 {
    private $id;
    private $cliente_id;
    private $descricao_problema;
    private $data_preferida;
    private $status;
    private $data_cad;
    private $data_atualizacao;
    private $data_resposta;
    private $resposta_admin;
    private $endereco;

// ======================================================================================

public function getId()
{
    return $this->id;
}
public function setId(int $id)
{
    $this->id=$id;
}

public function getClienteId()
{
    return $this->cliente_id;
}
public function setClienteId(int $cliente_id)
{
    $this->cliente_id=$cliente_id;
}

public function getDescricaoProblema()
{
    return $this->descricao_problema;
}
public function setDescricaoProblema(string $descricao_problema)
{
    $this->descricao_problema=$descricao_problema;
}

public function getDataPreferida()
{
    return $this->data_preferida;
}
public function setDataPreferida(int $data_preferida)
{
    $this->data_preferida=$data_preferida;
}

public function getStatus()
{
    return $this->status;
}
public function setStatus(int $status)
{
    $this->status=$status;
}

public function getDataCad()
{
    return $this->data_cad;
}
public function setDataCad(int $data_cad)
{
    $this->data_cad=$data_cad;
}

public function getDataAtualizacao()
{
    return $this->data_atualizacao;
}
public function setDataAtualizacao(int $data_atualizacao)
{
    $this->data_atualizacao=$data_atualizacao;
}

public function getDataReposta()
{
    return $this->data_resposta;
}
public function setDataResposta(int $data_resposta)
{
    $this->data_resposta =$data_resposta;
}

public function getRespostaAdmin()
{
    return $this->resposta_admin;
}
public function setRespostaAdmin(int $resposta_admin)
{
    $this->resposta_admin =$resposta_admin;
}

public function getEndereco()
{
    return $this->endereco;
}
public function set(int $endereco)
{
    $this->endereco=$endereco;
}

// PDO pendente

/*
inserir(): bool
listar(): array
listarPorCliente(int $cliente_id): array
buscarPorId(int $id): bool
responder(string $resposta, int $status): bool
atualizarStatus(int $status): bool
*/ 

/*
id
cliente_id
descricao_problema
data_preferida
status
data_cad
data_atualizacao
data_resposta
resposta_admin
endereco
*/

public function inserir(): bool
{
    $sql = "INSERT solicitacoes (cliente_id, descricao_problema, data_preferida, status, data_cad
    data_atualizacao, data_resposta, resposta_admin, endereco) VALUES (:cliente_id, :descricao_problema, :data_preferida, :status, :data_cad
    :data_atualizacao, :data_resposta, :resposta_admin, :endereco)";
    $cmd = $this->pdo->prepare($sql);
    // $cmd->bindValue("", $this->);
    $cmd->bindValue("cliente_id", $this->cliente_id);
    $cmd->bindValue("descricao_problema", $this->descricao_problema);
    $cmd->bindValue("data_preferida", $this->data_preferida);
    $cmd->bindValue("status", $this->status);
    $cmd->bindValue("data_cad", $this->data_cad);
    $cmd->bindValue("data_atualizacao", $this->data_atualizacao);
    $cmd->bindValue("data_resposta", $this->data_resposta);
    $cmd->bindValue("resposta_admin", $this->resposta_admin);
    $cmd->bindValue("endereco", $this->endereco);   
    if ($cmd->execute()){
        $this->id =$this->pdo->lastInsertId();
        return true;
    }
    return false;
}


// Método LISTAR
public static function listar(): array
{
    $cmd = obterPdo()->query("SELECT * FROM solicitacoes ORDER BY id desc");
    return $cmd->fetchALL(PDO::FETCH_ASSOC);
}



// Método LISTARCLIENTE
public static function listarPorCliente(int $cliente_id): array
{
    $cmd = obterPdo()->query("SELECT * FROM cliente ORDER BY  desc");
    return $cmd->fetchALL(PDO::FETCH_ASSOC);
}




 }




?>