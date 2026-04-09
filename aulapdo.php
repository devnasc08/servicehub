<?php
//include_onde: conexão com o script
include_once "config/conexao.php";

$sql = "select * from servicos";
$cmd = $pdo->prepare($sql);

$cmd->execute();

$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC); // Me retornará uma matriz associativa
//var_dump($servicos); // Impressão na tela

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Aula PDO PHP</title>
</head>

<body>
    <h2>Lista de Serviços</h2>

    <table border=1 collpadding=10>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descriçãp</th>
            <th>Preço</th>
            <th>Descontinuado</th>
        </tr>

        <?php foreach ($servicos as $servico): ?>

            <tr>
                <td> <?php echo $servico['id']; ?> </td>
                <td> <?= $servico['nome']; ?> </td>
                <td> <?= $servico['descricao']; ?> </td>
                <td> <?= $servico['preco']; ?> </td>
                <td> <?= $servico['descontinuado'] ? "Sim" : "Não"    ?></td>

            <?php endforeach; ?>


            </tr>
    </table>

</body>