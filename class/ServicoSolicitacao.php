<?php 

/*
Classe ServicoSolicitacao (Relacionamento N:N)
Arquivo:
classes/ServicoSolicitacao.php

Atributos esperados:

servico_id

solicitacao_id

data_assoc

Métodos obrigatórios:

associar(int $servico_id, int $solicitacao_id): bool

listarServicosDaSolicitacao(int $solicitacao_id): array
*/ 

include_once "config/conexao.php";

class ServicoSolicitacao
{
    private $servico_id;
    private $solicitacao_id;
    private $data_assoc;
    private $pdo;

    public function __construct()
    {
        $this->pdo=obterPdo();
    }



    public function getServicoId()
    {
        return $this->servico_id;
    }

    
    public function setServicoId(int $servico_id)
    {
        $this->servico_id =$servico_id;
    }

    
    public function getSolicitacaoId()
    {
        return $this->solicitacao_id;
    }

    
    public function setSolicitacaoId(int $solicitacao_id)
    {
        $this->solicitacao_id =$solicitacao_id;
    }

    
    public function getDataAssoc()
    {
        return $this->data_assoc;
    }



    // Métodos

    public function associar(int $servico_id, int $solicitacao_id): bool
    {
        //$sql = "INSERT servico_solicitacao VALUES (1, 4, default)"
        $sql = "INSERT servico_solicitacao VALUES (:servico_id, :solicitacao_id default)";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":servico_id",$servico_id ,":solicitacao_id", $solicitacao_id);
        return $cmd->execute();
    }
    

    public static function listarServicosDaSolicitacao(int $solicitacao_id): array
    {
        $sql = "SELECT se.*, ss.data_assoc
        FROM servico_solicitacao ss
        INNER JOIN servicos se ON se.id = ss.servico_id
        WHERE ss.servico_id = :solicitacao_id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":solicitacao_id", $solicitacao_id, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC); 
    }




















}
?>