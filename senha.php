<?php 

// $senha = password_hash("123456", PASSWORD_DEFAULT);
// echo $senha;

require_once "class/usuario.php";

$usuario = new Usuario();
$usuario ->setNome('Milharino Santos');
$usuario ->setEmail('mil@harino.sa');
$usuario ->setSenha('mi2026@TV');
$usuario ->setTipo(2);

if($usuario->inserir()){
    echo "Usuario".$usuario->getNome()."Inserido com o ID".$usuario->getId();
}





?>