<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
require_once "config/conexao.php";
require_once "includes/funcoes.php";
require_once "class/Cliente.php";


// ! Retorna Verdadeiro se for Falso || Retorna Falso se for Verdadeiro
// Verifica se o usuário está logado e se é do tipo cliente = 2
if(!isset($_SESSION['usuario_id']) || $_SESSION['tipo']!=2){
  header("location: login.php");
}

$cliente = new Cliente;

// Busca os dados do cliente usando o id do usuário logado
if(!$cliente->buscarPorId($_SESSION["usuario_id"])){
  die ("Cliente não encontrado");
}
 
$sql = 'SELECT s.id, s.status, s.data_cad, GROUP_CONCAT(se.nome SEPARADOR ".")
AS servicos FROM solicitacoes s 
INNER JOIN servico_solicitacao ss ON ss.solicitacao_id
WHERE s.cliente_id=?
GROUP BY s.id, s.status, s.data_cad
    ORDER BY s.data_cad DESC';


// prepare a consulta
$cmd = obterPdo()->prepare($sql);
// execute 
$cmd->execute([$cliente["id"]]);
// buscas todas as solicitações  encontradas no banco
$solicitacoes = $cmd->fetchALL(PDO::FETCH_ASSOC);


include "includes/header.php";
include "includes/menu.php";
?>

<main class="container mt-5">
  <h2>Bem-vindo, <strong><?= $_SESSION['nome'] ?></strong></h2>
  <p><a href="logout.php" class="btn btn-danger btn-sm">Sair</a></p>
  <a href="cliente_perfil.php" class="btn btn-warning btn-sm">Meu Perfil</a>
  <h4 class="mt-4">Minhas Solicitações</h4>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Data</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <td><?= $s["id"] ?></td>
      <?php foreach ($solicitacoes as $s);
      $lista = explode(",", $s["servicos"]);
      foreach ($lista as $nomeservico) : {
        echo '<span class="badge bg-primary me-1 mb-1">' . 
        htmlspecialchars($nomeservico) . '</span>';
      }
      ?>

          </td>
            <!-- Exibe o status em formato de texto usando função -->
              <?php statusTexto($s['status'])?>
            <td>
            <!-- Formata data para o padrão brasileiro -->
              <?= date("d/m/Y H:i", strtotime($s["data_cad"])) ?>
          </td>

          <td>
          <!-- Link para ver os detalhes da solicitação -->
            <a href="cliente_detalhes.php?id=<?= $s["id"]?>"
          </td>

          <td>
            <a href="cliente_detalhes.php?id=" class="btn btn-primary btn-sm">Detalhes</a>
          </td>
        </tr>
        <?php endforeach;?>
    </tbody>
  </table>
<?php include "includes/footer.php"?>
</main>