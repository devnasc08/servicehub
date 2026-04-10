<?php

include_once "config/conexao.php";


var_dump($_SERVER);

$id = $_POST['txtid']; // Get aparece na URL, POST não
$sql = "select nome from servicos where id = :id";
$cmd = $pdo->prepare($sql);
$cmd->execute([":id"=>$id]);
$serv = $cmd->fetch(PDO::FETCH_ASSOC);

?>

<h2>Nome do Serviços: <?= $serv['nome']?></h2>


