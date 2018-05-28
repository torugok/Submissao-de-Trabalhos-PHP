<?php

class DB
{

  public static function conecta()
  {
    $server_name = "mysql";
    $db_nome = "trabalhos_metro";
    $host = "localhost";
    $usuario = "root";
    $senha = "";

    $pdo = new PDO("".$server_name.":host=".$host.";dbname=".$db_nome."",$usuario,$senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query("SET NAMES UTF8");

    return $pdo;
  }
}

 ?>
