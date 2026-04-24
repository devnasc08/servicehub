<?php
include_once "config/conexao.php";
/*
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
class ServicoSolicitacao
{
private $servico_id;
private $solicitacao_id;
private $data_assoc;
private $pdo;

public function associar(int $servico_id, int $solicitacao_id): bool
{
    $sql = "INSERT INTO servico_solicitacao (servico_id, solicitacao_id, data_assoc)
    VALUES (:servico, :solicitacao, NOW())";

    $cmd = obterPdo()->prepare($sql);
    $cmd->bindValue(":servico", $servico_id);
    $cmd->bindValue(":solicitacao", $solicitacao_id);

    return $cmd->execute();
}

public function listarServicoDaSolicitacao (int $solicitacao_id): array
{
    $sql = "SELECT s.* FROM servicos s JOIN servico_solicitacao ss 
    ON s.id = ss.servico_id 
    WHERE ss.solicitacao_id = :id";

$cmd = obterPdo()->prepare($sql);
$cmd->bindValue(":id", $solicitacao_id);
$cmd->execute();

return $cmd->fetchAll(PDO::FETCH_ASSOC);

}























}

?>