<?php
require_once "config/conexao.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['txtnome'];
    $descricao = $_POST['txtdescricao'];
    $preco = $_POST['txtpreco'];


    // ==== Inserindo Serviços ==== 
    $sql = "INSERT servicos (nome, descricao, preco) VALUES(:nome, :descricao, :preco)";
    $cmd = obterPdo()->prepare($sql);
    $cmd->execute([':nome' => $nome, ':descricao' => $descricao, ':preco' => $preco]);
    $id = $pdo->lastInsertId();     //Armazena o ID do serviço que acabou de ser inserido

    if (isset($id))/*SE valor associado em $ID?*/ {
        echo "Serviço cadastrado com sucesso, com id " . $id;
    } else {
        echo "Falha ao cadastrar o serviço!!";
    }

    $name = $_POST['nomeAluno'];
    $data_nasc = $_POST['data_nasc'];
    $email = $_POST['emailAluno'];
    $telefone = $_POST['telAluno'];

    $sql = "INSERT alunos (nome, data_nasc, email, telefone) VALUES(:nome, :data_nasc, :email, :telefone)";
    $cmd = obterPdo()->prepare($sql);
    $cmd->execute([':nome' => $name, ':data_nasc' => $data_nasc, ':email' => $email, ':telefone' => $telefone]);
}
?>





<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Formulário de Serviços</title>
</head>

<body>
    <form action="formservico.php" method="post">
        <input type="number" name="txtid" id="" hidden>
        <label for="txtnome">Nome</label>
        <input type="text" name="txtnome" id="">
        <label for="txtdescricao">Descrição</label>
        <input type="text" name="txtdescricao">
        <label for="txtpreco">Preço</label>
        <input type="text" name="txtpreco">
        <button type="submit">Gravar</button>
        <br>
        <hr> <br>
        <!-- =================== Form ALUNO ===================== -->
        <form action="formservico.php" method="post">
            <input type="number" name="txtid" id="" hidden>

            <label for="txtnome">Nome do Aluno</label>
            <input type="text" name="nomeAluno" id="">

            <label for="txtpreco">Data de Nascimento</label>
            <input type="date" name="dataNasc">

            <label for="txtdescricao">Email</label>
            <input type="email" name="emailAluno">

            <label for="txtdescricao">Telefone</label>
            <input type="tel" name="tellAluno">

            <button type="submit">Inserir</button>


        </form>
</body>

</html>