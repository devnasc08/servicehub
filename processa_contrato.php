<?php 
session_start();

require_once "class/Cliente.php";
require_once "class/Usuario.php";
require_once "class/Servico.php";
require_once "class/Solicitacao.php";
require_once "class/ServicoSolicitacao.php";



if ($_SERVER['REQUEST_METHOD']!=="POST"){
    header("location: contratar.php?erro=Invalid Request.");
    exit();
}

// Verificação de Segurança (Se quem está logado tem direito de carregar esta página)
// CSRF

$token = $_POST['csfr_token']?? "";
if(!$token || !isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token'])
{
    header("location: contratar.php?erro=Falha de segurança CSFR detectada");
    exit();
}

// inputs (São os campos do formulário)


$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); // Impossibilita Burlamento

$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);

$endereco = filter_input(INPUT_POST, 'endereco', FILTER_UNSAFE_RAW); // Precisa que seja um texto

$descricao = filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW); // Precisa que seja um texto

$data_preferida = filter_input(INPUT_POST, 'data_preferida', FILTER_SANITIZE_SPECIAL_CHARS);
//Estrutura de expressão regular 
$cpf = preg_replace('/\D/','',$_POST['cpf'] ?? "");

$servicos_ids = $_POST['servicos_id'] ?? []; // Array de servicos

//Vaçidação dos servicos
if (!is_array($servicos_ids)){
header("location: contratar.php?erro=Selecione ao menos um serviço");
exit();
}
$servicos_validos = [];
foreach($servicos_ids as $id){
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $servicos_validos[] = $id;
}

// Validações Gerais
if ($nome || strlen($nome) < 3){
    header("location: contartar.php?erro=Nome Inválido.");
    exit();
}

if ($email){
    header("location: contartar.php?erro=Email Inválido.");
    exit();
}

if ($telefone || strlen($telefone) < 8){
    header("location: contartar.php?erro=Telefone Inválido.");
    exit();
}

if ($endereco || strlen($endereco) < 5){
    header("location: contartar.php?erro=Endereço Inválido.");
    exit();
}

if ($descricao || strlen($descricao) < 3){
    header("location: contartar.php?erro=Descreva melhor o problema (Minímo 10 caracteres.) ");
    exit();
}


if ($cpf && strlen($cpf) != 11){
    header("location: contartar.php?erro=Cpf Inválido. Digite 11 números. ");
    exit();
}

if(count($servicos_validos)< 1) {
    header("location: contartar.php?erro=Selecione ao menos um servico válido.");
    exit();
}

if($data_preferida){
    $ts = strtotime($data_preferida);
    if ($ts === false){
        header("location: contartar.php?erro=Data Inválida");
        exit();
    }
       if($ts < strtotime(date('Y-m-d'))){
        header("location: contartar.php?erro=A data não pode ser anterior a de hoje");
        exit();
    } 
}


//Verificar se o usuario existe
$usuarioBanco = new Usuario();

if($usuarioBanco->buscarPorEmail($email) == false){
$usuario = new Usuario();
$usuario->setNome($nome);
$usuario->setEmail($email);
$usuario->setSenha("123456");
$usuario->setTipo(2);
$usuario->setAtivo(true);
$usuario->setPrimeiroLogin(true);
if (!$usuario->inserir()){
    header("location: contartar.php?erro=Erro ao Cadastrar o Usuário");
    exit();
}

$usuario_id = $usuario->getId();
} else{
    $usuario_id = $usuarioBanco->getId();
}


//Verificar se o Cliente existe
$cliente = new Cliente();
if($cliente->buscarPorUsuario($usuario_id)==false){
//Gravando Cliente
$cliente->setUsuario_id($usuario_id);
$cliente->setTelefone($telefone);
$cliente->setCpf($cpf);
if(!$cliente->inserir()){
    header("location: contartar.php?erro=Erro ao Cadastrar o Cliente");
    exit();
    }

}
$cliente_id = $cliente->getId();
//Cadastrar Solicitação
$solicitacao = new Solicitacao();
$solicitacao->setClienteId($cliente_id);
$solicitacao->setDescricaoProblema($descricao);
$solicitacao->setDataPreferida($data_preferida?: null);
$solicitacao->setEndereco($endereco);

if(!$solicitacao->inserir()){
    header("location: contartar.php?erro=Erro ao Cadastrar a Solicitação");
    exit();
}
$solicitacao_id = $solicitacao->getId();
// Associar os serviços à solicitação.



?>