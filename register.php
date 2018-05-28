


<!DOCTYPE html>
<html>
<head>
  <title>Registrar-se</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="bootstrap/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
</head>


<body>
  <div class="jumbotron text-center">
    <h1 class="display-4">Registre-se</h1>

  </div>

  <div class="container">



    <div class="row">
      <div class="col-md-4">

      </div>
      <div class="col-md-4">

        <br />

        <?php


        if(isset($_GET["sucesso"]))
        {
          if($_GET["sucesso"] == 1)
          {
            echo "<div class=\"alert alert-success\" role=\"alert\">
                    Cadastro efetuado com sucesso!
                  </div>";
          }
          else {
            session_start();
            $error_code = '';
            if($_GET["sucesso"] == 3)
            {
              $error_code .= "Senhas não conferem!";
            }
            else
            {
              $error_code .= $_SESSION["register_error"];
            }

            echo "<div class=\"alert alert-danger\" role=\"alert\">
                    Cadastro não efetuado, verifique!
                    ".$error_code."
                  </div>";
          }
        }

         ?>

        <form method="post" action="service.php?param=registrar" onsubmit="return testar_senhas();">

          <div class="form-group">
            <label for="nome">Nome Completo*</label>
            <input required name="nome" type="text" id="nome"  class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label for="email">Email*</label>
            <input required name="email" type="email" id="email"  class="form-control" aria-describedby="emailHelp" placeholder="">
          </div>

          <div class="form-group">
            <label for="cpf">CPF*</label>
            <input name="cpf" type="text" id="cpf"  class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label for="usuario">Usuario*</label>
            <input required name="usuario" type="text" id="usuario"  class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label for="senha">Senha*</label>
            <input required name="senha" type="password" id="senha"  class="form-control" placeholder="">
          </div>

          <div class="form-group">
            <label for="confirmar_senha">Confirmar Senha*</label>
            <input required name="confirmar_senha" type="password" id="confirmar_senha"  class="form-control" placeholder="">
          </div>

          <div class="form-horizontal">
              <div class="form-group">
                  <label for="data_nascimento">Data de Nascimento*</label>
                  <input required type="date" class="form-control" id="data_nascimento" name="data_nascimento"/>
              </div>
          </div>

          <br />
          <a href="login.php" class="btn btn-danger">Voltar</a>
          <button type="submit" class="btn btn-success">Enviar</button>

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
