<?php
//sistema de envio de arquivo: https://www.w3schools.com/php/php_file_upload.asp

include 'connection.php';
include 'utils.php';

if(isset($_GET["param"]))
{

  if($_GET["param"] == "registrar")
  {
    try
    {
      if($_POST["senha"] != $_POST["confirmar_senha"])
      {
        header('location:register.php?sucesso=3');
        exit();
      }

      $con = DB::conecta();
      $registrar_query = $con->prepare("INSERT INTO `usuarios`(`id`, `CPF`, `nome`, `usuario`, `senha`, `data_nascimento`,salt) VALUES (default,:cpf,:nome,:usuario,:senha,:data_nascimento,:salt)");
      $registrar_query->bindValue(":cpf",$_POST["cpf"]);
      $registrar_query->bindValue(":nome",$_POST["nome"]);
      $registrar_query->bindValue(":usuario",$_POST["usuario"]);
      $registrar_query->bindValue(":data_nascimento",$_POST["data_nascimento"]);

      $salt = $_POST["usuario"].(string)rand();
      $senha = sha1($salt.$_POST["senha"]);
      $registrar_query->bindValue(":senha",$senha);
      $registrar_query->bindValue(":salt",$salt);

      $registrar_execute = $registrar_query->execute();


      mkdir("uploads/".$_POST["usuario"]);
        header('location:register.php?sucesso=1');

    }
    catch(PDOException $e)
    {
      session_start();
      $_SESSION["register_error"] = $e->getMessage();
      header('location:register.php?sucesso=0');
      exit();
    }

  }
  else if($_GET["param"] == "login")
  {
    session_start();
    $con = DB::conecta();

    $login_query = $con->prepare("SELECT * from usuarios where usuario = :usuario");
    $login_query->bindValue(":usuario",$_POST["usuario"]);
    $login_execute = $login_query->execute();

    if($login_execute)
    {
      $login_data = $login_query->fetchAll(PDO::FETCH_OBJ);

      if (count($login_data) <= 0)
      {
        $con = NULL;
        session_finish();
        header('location:login.php?erro=1');
        exit();
      }
      else
      {
        if(sha1($login_data[0]->salt.$_POST["senha"]) == $login_data[0]->senha)
        {
    	   $con = NULL;
         $_SESSION["usuario"] = $login_data[0]->usuario;
         $_SESSION["senha"] = $login_data[0]->senha;
         $_SESSION["usuario_id"] = $login_data[0]->id;
         header('location:enviar_trabalhos.php?logado=1');
         exit();
        }
        else
        {
          session_finish();
          header('location:login.php?erro=1');
          exit();
        }
      }

     }
  }
  else if($_GET["param"] == "enviar_trabalho")
  {
    session_start();
    $_SESSION["usuario_id"];

    $target_dir = "uploads/".$_SESSION["usuario"];
    $target_file = $target_dir ."/". basename($_FILES["file_arquivo"]["name"]);
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (file_exists($target_file))
    {
      $_SESSION["file_error"] = "Desculpe, o arquivo já existe.";
      $uploadOk = 0;
      header('location:enviar_trabalhos.php?sucesso=0');
      exit();
    }
    if($pdfFileType != "pdf" ) {
        $_SESSION["file_error"] = "Apenas arquivos .pdf são permitidos!";
        $uploadOk = 0;
        header('location:enviar_trabalhos.php?sucesso=0');
        exit();
    }
    if ($uploadOk == 0) {
      $_SESSION["file_error"] = "Erro ao fazer upload!";
      header('location:enviar_trabalhos.php?sucesso=0');
      exit();
    } else {
        if (move_uploaded_file($_FILES["file_arquivo"]["tmp_name"], $target_file))
        {
            $con = DB::conecta();
            $trabalho_query = $con->prepare("INSERT INTO `trabalhos_submetidos`(`id`, `titulo_trabalho`, `caminho`, `usuario_id`) VALUES (default,:titulo_trabalho,:path,:usuario_id)");
            $trabalho_query->bindValue(":titulo_trabalho",$_POST["titulo_trabalho"]);
            $trabalho_query->bindValue(":path",$target_file);
            $trabalho_query->bindValue(":usuario_id",$_SESSION["usuario_id"]);

            $trabalho_execute = $trabalho_query->execute();

            if($trabalho_execute)
            {
              $_SESSION["file_enviado"] = $_FILES["file_arquivo"]["name"];
              header('location:enviar_trabalhos.php?sucesso=1');
              exit();
            }
        }
        else
        {
          $_SESSION["file_error"] = "Erro ao fazer upload!";
          header('location:enviar_trabalhos.php?sucesso=0');
          exit();
        }
    }
  }

  else if($_GET["param"] == "del_trabalho")
  {
    if(isLogged())
    {
      if(isset($_GET["id"]) && isset($_GET["caminho"]) )
      {
        $con = DB::conecta();
        $trabalho_query = $con->prepare("DELETE FROM `trabalhos_submetidos` WHERE id = :id AND usuario_id = :usuario_id");
        $trabalho_query->bindValue(":id",$_GET["id"]);
        $trabalho_query->bindValue(":usuario_id",$_SESSION["usuario_id"]);
        $trabalho_execute = $trabalho_query->execute();
        if($trabalho_execute)
        {
          $_SESSION["file_deletado"] = "Aquivo ".$_GET["caminho"]." deletado com sucesso!";
          unlink ( $_GET["caminho"] );
          header('location:enviar_trabalhos.php?deletado=1');
          exit();
        }
        else {
          $_SESSION["file_deletado"] = "Não foi possível excluir o arquivo do registro!";
          header('location:enviar_trabalhos.php?deletado=0');
          exit();
        }
      }
    }
    else {
      echo "Acesso negado!";
    }
  }

}




?>
