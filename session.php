<?php
   include('config.php');
   session_start();

   $user_check = $_SESSION['login_user'];


   $ses_sql = mysqli_query($db,"select username_var, userType_var from tbl_users where username_var = '$user_check' ");


   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['username_var'];
   $_SESSION['username'] = $row['username_var'];
   $_SESSION['usertype'] = $row['userType_var'];


   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>