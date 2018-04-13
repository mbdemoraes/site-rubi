<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {

     $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $myusername = $_POST['username'];
     $mypassword = $_POST['password'];

     $stmt = $conn->prepare("SELECT password_var FROM tbl_users WHERE username_var=:field1");
     $stmt->execute(array(
      ':field1' => $myusername));
     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

     foreach ($results as $result) {
      $dbUser = $result;
     }

     if(!empty($results) && password_verify($mypassword,$dbUser['password_var'])) {
         $_SESSION['login_user'] = $_POST['username'];
         header("location: index.php");
     } else {
      if(!empty($myusername) && !empty($mypassword)) {
           $error = "Usuário ou senha inválidos. Por favor, tente novamente.";
         } else {
           $error = "";
         }
     }

   }

/*
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);

      $sql = "SELECT id FROM tbl_users WHERE username_var = '$myusername' and password_var = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         header("location: index.php");
      }else {
         if(!empty($myusername) && !empty($mypassword)) {
           $error = "Usuário ou senha inválidos. Por favor, tente novamente.";
         } else {
           $error = "";
         }

      }
   }*/
?>


<link rel="stylesheet" href="css/styleLogin.css">
<link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'>

<div class="container">
    <div class="row login_box">
        <div class="col-md-6 col-xs-6" align="center">
            <div class="line"><h3><?php date_default_timezone_set('America/Sao_Paulo'); echo date("H:i"); ?></h3></div>
            <div class="outter"><img src="imgs/logo.jpg" class="image-circle"/></div>
            <h1>Seja bem vindo (a)</h1>
            <span>Mansão Rubi - Crescimento Humano e Sustentável</span>
        </div>

        <div class="col-md-12 col-xs-12 login_control">
            <form role="form" action="" method="post">
                <div class="control">
                    <div class="label">Usuário</div>
                    <input type="text" class="form-control" name="username"/>
                </div>

                <div class="control">
                     <div class="label">Senha</div>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div align="center">
                     <button class="btn btn-orange">LOGIN</button>
                </div>
            </form>
            <div style = "font-size:14px; color:#cc0000; margin-top:10px"><?php if(isset($error)) echo $error; ?></div>
        </div>



    </div>
</div>