<?php
  require_once('functions.php');
  if (isset($_GET['id']) && isset($_GET['payment'])){
    //searchById('tbl_course_customers', $_GET['id']);
    searchCourseCustomer($_GET['id']);
    $customer = $element;
    if($_GET['payment']==0) {
      $customer['payment_tni'] = 1;
      $today = date_create('now', new DateTimeZone('America/Sao_Paulo'));
      $customer['payment_date_dt'] = $today->format("Y-m-d");
    } else {
      $customer['payment_tni'] = 0;
      $customer['payment_date_dt'] = NULL;
    }

    editPayment($customer);
  } else {
    die("ERRO: ID não definido.");
  }
?>