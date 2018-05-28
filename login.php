<?php
include 'utils.php';
check_session();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="bootstrap/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">


</head>


<body>
<div class="jumbotron text-center">
  <h1 class="display-4">Submissão de Trabalhos</h1>

</div>


  <div class="container">

    <div class="row">
      <div class="col-md-4">

      </div>
      <div class="col-md-4">
        <h3 >Login</h3>
        <br />

        <?php

        if(isset($_GET["erro"]))
        {
          if($_GET["erro"]==1)
          {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
              Usuário ou senha incorretos
            </div>";
          }
        }


         ?>

        <form method="post" action="service.php?param=login">


          <div class="form-group">
            <label for="usuario">Usuário</label>
            <input required name="usuario" type="text" id="usuario"  class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label for="senha">Senha</label>
            <input required name="senha" type="password" id="senha"  class="form-control" placeholder="">
          </div>
          <small id="fileHelp" class="form-text text-muted">
          <a href="register.php">Registrar-se</a>
        </small>


          <br />
          <button type="reset" class="btn btn-primary">Redefinir</button>
          <button type="submit" class="btn btn-success">Entrar</button>

        </form>

      </div>

    </div>

  </div>

<br />
  <div class="footer navbar-fixed-bottom text-center" style="margin-bottom:0;">
    <p>Copyright &copy;2018 by <a target="_blank" href="https://www.instagram.com/torugok/">@torugok</a> - <a target="_blank" href="https://medialab.unifesspa.edu.br/">Media Lab/BR</a></p>
  </div>

  <script src="bootstrap/js/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
