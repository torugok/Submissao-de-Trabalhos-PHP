<?php

function isLogged()
{
  if(session_status() != 2)
    session_start();
  if(isset($_SESSION["usuario"]) && isset($_SESSION["senha"]))
    return true;
  else
    return false;
}

function session_finish()
{
  session_unset();
  session_destroy();
}

function check_session()
{
    $pagina = end(explode("/", $_SERVER['PHP_SELF']));

    if(isLogged())
    {
      if($pagina != "enviar_trabalhos.php")
        header('location:enviar_trabalhos.php?logado=1');
    }
    else
    {
      session_finish();
      if($pagina != "login.php" )
        header('location:login.php');
    }

}

?>
