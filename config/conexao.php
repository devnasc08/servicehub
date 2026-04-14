<?php
function obterPdo():PDO{

$host = "10.91.47.129"; //IP Server
$db = "servicehubdb01"; //Nome DB
$user = "root";         //Usuário
$pass = "202720";     //Senha
static $pdo;

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo "Sucess";
    // var_dump($pdo);
}catch(PDOException $e){
    // var_dump($e->getMessage());
    die("Erro na conexão: ".$e->getMessage());
}

return $pdo;


}


?>