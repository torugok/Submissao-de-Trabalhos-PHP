<?php
include 'utils.php';

check_session();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Enviar Trabalhos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="bootstrap/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">



</head>


<body>
<div class="jumbotron text-center" style="margin-bottom:0">
  <h1 class="display-4">Submissão de Trabalhos</h1>
</div>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">

    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="enviar_trabalhos.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Sair</a>
            </li>
        </ul>
    </div>
</nav>

<br />


  <div class="container">

    <div class="row">
      <div class="col-md-2">

      </div>
      <div class="col-md-8">
        <h2>Meus Trabalhos</h2>
        <?php
        if(isset($_GET["deletado"]))
        {
          if($_GET["deletado"]!=1)
          {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
              ".$_SESSION["file_deletado"]."
            </div>";
          }
          else {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                    ".$_SESSION["file_deletado"]."
                  </div>";
          }
        }


         ?>

        <table id="meus_trabalhos" class="display table-bordered text-center">
          <thead>
            <tr>
              <th>id</th>
              <th>Titulo</th>
              <th>Arquivo</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'connection.php';

            $con = DB::conecta();

            $select_query = $con->prepare("SELECT * from trabalhos_submetidos where usuario_id = :usuario_id");
            $select_query->bindValue(":usuario_id",$_SESSION["usuario_id"]);


            if($select_query->execute())
            {
              while($row = $select_query->fetch(PDO::FETCH_OBJ))
              {
                echo "<tr>
                <td>".$row->id."</td>
                <td>".$row->titulo_trabalho."</td>
                <td><a target=\"_blank\" href='".$row->caminho."'>$row->caminho</a></td>
                <td><a class=\"btn btn-danger\" href=\"service.php?param=del_trabalho&id=".$row->id."&caminho=".$row->caminho."\">Excluir</a></td>
                </tr>";
              }
            }

            ?>

          </tbody>

        </table>

      </div>


    </div>
    <br />

    <div class="row">
      <div class="col-md-2">

      </div>
      <div class="col-md-8">
        <h3 >Enviar Trabalho</h3>
        <?php
        if(isset($_GET["sucesso"]))
        {
          if($_GET["sucesso"]!=1)
          {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
              ".$_SESSION["file_error"]."
            </div>";
          }
          else {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                    Arquivo ".$_SESSION["file_enviado"]." enviado com sucesso!
                  </div>";
          }
        }


         ?>

        <form enctype="multipart/form-data" method="post" action="service.php?param=enviar_trabalho">
            <div class="form-group">
              <label for="nome">Titulo do trabalho*</label>
              <input required name="titulo_trabalho" type="text" id="titulo_trabalho"  class="form-control" placeholder="">
            </div>
            <div class="form-group">
              <input required class="form-control" type="file" name="file_arquivo" accept=".pdf">
            </div>
          <br />
          <button type="reset" class="btn btn-danger">Redefinir</button>
          <button type="submit" class="btn btn-success">Enviar</button>
        </form>

      </div>

    </div>
    <br />

</div>
    <div class="footer navbar-fixed-bottom text-center" style="margin-bottom:0;">
      <p>Copyright &copy;2018 by <a target="_blank" href="https://www.instagram.com/torugok/">@torugok</a> - <a target="_blank" href="https://medialab.unifesspa.edu.br/">Media Lab/BR</a></p>
    </div>







  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

  <script>
  $(document).ready( function () {
  $('#meus_trabalhos').DataTable({searching:false,
 language: {
 "sEmptyTable": "Nenhum registro encontrado",
 "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
 "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
 "sInfoFiltered": "(Filtrados de _MAX_ registros)",
 "sInfoPostFix": "",
 "sInfoThousands": ".",
 "sLengthMenu": "_MENU_ resultados por página",
 "sLoadingRecords": "Carregando...",
 "sProcessing": "Processando...",
 "sZeroRecords": "Nenhum registro encontrado",
 "sSearch": "Pesquisar",
 "oPaginate": {
     "sNext": "Próximo",
     "sPrevious": "Anterior",
     "sFirst": "Primeiro",
     "sLast": "Último"
 },
 "oAria": {
     "sSortAscending": ": Ordenar colunas de forma ascendente",
     "sSortDescending": ": Ordenar colunas de forma descendente"
 }
}
});
  } );

  </script>


</body>

</html>
