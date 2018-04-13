<?php
  require_once('functions.php');
  require_once('../session.php');
  if (isset($_GET['id'])){
    delete($_GET['id']);
     #$_SESSION['message'] = "Cliente excluído com sucesso!";
     #$_SESSION['type'] = 'success';
  } else {
    die("ERRO: ID não definido.");
  }
?>