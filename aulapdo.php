<?php
//include_onde: conexão com o script
include_once "config/conexao.php";

$sql = "select * from servicos where id = :id";
$cmd = $pdo->prepare($sql);
$cmd->execute(["id"=>$id]);
$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC); // Me retornará uma matriz associativa
//var_dump($servicos); // Impressão na tela

$sql = "select * from clientes";
$cmd = $pdo->prepare($sql);
$cmd->execute();
$clientes = $cmd->fetchAll(PDO::FETCH_ASSOC);

$sql = "select * from usuarios";
$cmd = $pdo->prepare($sql);
$cmd->execute();
$usuarios = $cmd->fetchAll(PDO::FETCH_ASSOC);




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
                <td> <?= $servico['id']; ?> </td>
                <td> <?= $servico['nome']; ?> </td>
                <td> <?= $servico['descricao']; ?> </td>
                <td> <?= $servico['preco']; ?> </td>
                <td> <?= $servico['descontinuado'] ? "Sim" : "Não"    ?></td>

            <?php endforeach; ?>
            </tr>
    </table>
    <!-- ============================================================================================= -->

    <!-- id, nome, email, senha, tipo, ativo, primeiro_login -->
    <h2>Lista de Usuários</h2>

    <table border=1 collpadding=10>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Senha</th>
            <th>Tipo</th>
            <th>Ativo</th>
            <th>Primeiro Login</th>
        </tr>

        <?php foreach ($usuarios as $usuario): ?>

            <tr>
                <td> <?= $usuario['id']; ?> </td>
                <td> <?= $usuario['nome']; ?> </td>
                <td> <?= $usuario['email']; ?> </td>
                <td> <?= $usuario['senha']; ?> </td>
                <td> <?= $usuario['tipo']? "Administrador":"Usuário"?> </td>
                <td> <?= $usuario['ativo']? "Sim":"Não"?> </td>
                <td> <?= $usuario['primeiro_login']; ?> </td>

            <?php endforeach; ?>
            </tr>
    </table>

<!-- ============================================================================================ -->

        <h2>Lista de Clientes</h2>

    <table border=1 collpadding=10>
        <tr>
            <th>ID</th>
            <th>Usuario_ID</th>
            <th>Telefone</th>
            <th>CPF</th>
        </tr>

        <?php foreach ($clientes as $cliente): ?>

            <tr>
                <td> <?= $clientes['id']; ?> </td>
                <td> <?= $cliente['usuario_id']; ?> </td>
                <td> <?= $cliente['telefone']; ?> </td>
                <td> <?= $cliente['cpf']; ?> </td>

            <?php endforeach; ?>
            </tr>
    </table>
</body>