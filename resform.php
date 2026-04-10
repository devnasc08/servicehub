<?php

// var_dump($_SERVER['REQUEST_METHOD']);
include_once "config/conexao.php";
    if ($_SERVER['REQUEST_METHOD']=="POST") {
        echo "<h3>Chamado pela ação do formulário (POST)</h3>";
        $id = $_POST['txtid'];      // Get aparece na URL, POST não
        $sql = "select id, nome servicos where id = :id";
        $cmd = $pdo->prepare($sql);
        $cmd->execute(["id" => $id]);
        $serv = $cmd->fetchAll(PDO::FETCH_ASSOC);
        var_dump($servicos);
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
        echo "<h3>Chamado pela ação da URL ou formulário METHOD = 'GET'</h3>";
        $idViaGet = $_GET['txtid'];
        $sql = "select * from servicos where id = :id";
        $cmd = $pdo->prepare($sql);
        $cmd->execute([":id" => $idViaGet]);
        $serv = $cmd->fetchAll(PDO::FETCH_ASSOC);
        var_dump($servicos);
}


?>

<h2>Nome do Serviço: <?= $servico['nome'] ?></h2>