<?php
  require_once('functions.php');
  require_once('../session.php');
  if (isset($_GET['id']) && isset($_GET['courseId'])){
    deleteCustomerFromWaitingList($_GET['id'],$_GET['courseId']);
  } else {
    die("ERRO: ID não definido.");
  }
?>