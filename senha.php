<?php 

// $senha = password_hash("123456", PASSWORD_DEFAULT);
// echo $senha;

require_once "class/usuario.php";

// $usuario ->setNome('Milharino Santos');
// $usuario ->setEmail('mil@harino.sa');
// $usuario ->setSenha('mi2026@TV');
// $usuario ->setTipo(2);

// // if($usuario->inserir()){
//     //     echo "Usuario".$usuario->getNome()."Inserido com o ID".$usuario->getId();
//     // }
//     // echo "<prev>";
//     // print_r($usuario->listar());
    


     echo "<prev>";
     foreach(Usuario::listar() as $user){
     echo $user ['id']."-".$user['nome']."<br>";
     }



$usuario = new Usuario();
if($usuario->buscarPorId(62)){
    echo"<prev>";
    echo $usuario->getId()."-".$usuario->getNome()."<br>";
}
else{
    echo "Usuário não encontrado";
}




?>