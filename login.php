<?php

// Inicia a Sessão
// A sessão permite guardar dados do usuários logado | entre uma página e outra 
session_start();  //

// Importando dependências
include "includes/menu.php";
require_once "class/usuario.php";

//var_dump(usuario::efetuarLogin('admin@servicehub.com', 'admin123'));

$msg = "";

// Verifica se o form foi enviado | Só executa a lógica de login quando clicar em "entrar"
if ($_SERVER['REQUEST_METHOD'] === "POST") {

  // Validar email | filter_input filtra que o email seja válido
  $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

  // Pegar senha 
  $senha = $_POST['senha'] ?? null; //operado de coalecência | se não existir, recebe null
 
 // VALIDAR DADOS
 //se email inválido ou senha vazia
  if (!$email || !$senha) {  //   || = OU
    $msg = "Preencha os dados corretamente";
  }
 else{
  
  // Tentar Login | chama a RN da class usuario
  $usuario = Usuario::efetuarLogin($email, $senha);
 }
}

// Verifica Login
if (count($usuario) > 0) {
  // Salva dados na sessão
  $_SESSION['usuario_id'] = $usuario['id'];
      $_SESSION['nome'] = $usuario['nome'];
          $_SESSION['tipo'] = $usuario['tipo'];

// Verificar Primeiro Login | se for primeiro acesso, obriga trocar de senha
if($usuario['primeiro_login'] == 1){
  header('location: primeiro_login.php');
exit;

// Passo 3: Redirecionar pelo tipo de usuário
if($usuario['tipo']==1){
header('location:admin_dashboard.php');
}
else{
  header('location: cliente_dashboard.php');
  }
 }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow p-4 col-md-5 mx-auto">
      <h3 class="text-center">Área Restrita</h3>


      <form method="POST">
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Senha</label>
          <input type="password" name="senha" class="form-control" required>
        </div>

        <button class="btn btn-dark w-100">Entrar</button>
      </form>

      <p class="text-center mt-3">
        <a href="index.php">Voltar ao site</a>
      </p>
    </div>
  </div>
</body>

</html>