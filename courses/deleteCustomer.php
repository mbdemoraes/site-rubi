<?php
  require_once('functions.php');
  require_once('../session.php');
  if (isset($_GET['id']) && isset($_GET['courseId'])){
    search($_GET['courseId']);
    $course = $courses;
    $newSlots = intval($courses['numSlotsTaken_int'])-1;
    $course['numSlotsTaken_int'] = $newSlots;
    editNumSlots($course);
    deleteCustomer($_GET['id'],$_GET['courseId']);
  } else {
    die("ERRO: ID não definido.");
  }
?>