<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Mansão Rubi</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-2.2.4/dt-1.10.15/af-2.2.0/b-1.3.1/cr-1.3.3/fc-3.2.2/fh-3.1.2/kt-2.2.1/r-2.1.1/rg-1.0.0/rr-1.2.0/sc-1.4.2/se-1.2.2/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jq-2.2.4/dt-1.10.15/af-2.2.0/b-1.3.1/cr-1.3.3/fc-3.2.2/fh-3.1.2/kt-2.2.1/r-2.1.1/rg-1.0.0/rr-1.2.0/sc-1.4.2/se-1.2.2/datatables.min.js"></script>
  <script src="<?php echo BASEURL; ?>js/jquery.maskedinput.min.js"></script>


</head>
<body>

<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
    <!-- Navigation -->
    <!-- style="background-color: #e3f2fd;" -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://cijulenlinea.ucr.ac.cr/dev-users/">
                <img src="<?php echo BASEURL; ?>imgs/logoIndex.jpg" alt="LOGO"">
            </a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Opções <b class="fa fa-angle-down"></b></a>
                <ul class="dropdown-menu">
                    <li align="center">Info. do Usuário </li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-fw fa-user"></i> <?php echo $_SESSION['username'];?></a></li>
                    <li><a href="#"><i class="fa fa-fw fa-lock"></i> <?php if($_SESSION['usertype']=="admin") { echo "Administrador"; } else { echo "Operador"; }?></a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo BASEURL; ?>logout.php"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                 <li>
                 <!-- <a href="<?php ?>index.php"><i class="fa fa-fw fa-bar-chart" style="color:green">-->
                    <a href="<?php echo BASEURL; ?>index.php"><i class="fa fa-fw fa-bar-chart"></i> Dashboard </a>
                </li>
                <li>
                    <a href="#" data-toggle="collapse" data-target="#submenu-1"><i class="fa fa-fw fa-graduation-cap"></i> Cursos <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-1" class="collapse">
                        <li><a href="<?php echo BASEURL; ?>courses/add_course.php"><i class="fa fa-angle-double-right"></i> Cadastrar curso</a></li>
                        <li><a href="<?php echo BASEURL; ?>courses/view_course.php"><i class="fa fa-angle-double-right"></i> Visualizar curso</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="collapse" data-target="#submenu-2"><i class="fa fa-fw fa-group"></i>  Clientes <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-2" class="collapse">
                        <li><a href="<?php echo BASEURL; ?>customers/add_customer.php"><i class="fa fa-angle-double-right"></i> Cadastrar cliente</a></li>
                        <li><a href="<?php echo BASEURL; ?>customers/view_customer.php"><i class="fa fa-angle-double-right"></i> Visualizar cliente</a></li>
                    </ul>
                </li>
                 <li style="<?php if ($_SESSION['usertype']!='admin') echo "display:none;"; ?>">
                    <a href="#" data-toggle="collapse" data-target="#submenu-3"><i class="fa fa-fw fa-dollar"></i>  Financeiro <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-3" class="collapse">
                        <li><a href="<?php echo BASEURL; ?>financial/view_cash_flow.php"><i class="fa fa-angle-double-right"></i> Fluxo de Caixa</a></li>
                        <li><a href="<?php echo BASEURL; ?>financial/add_cost.php"><i class="fa fa-angle-double-right"></i> Cadastrar despesa</a></li>
                         <li><a href="<?php echo BASEURL; ?>financial/view_cost.php"><i class="fa fa-angle-double-right"></i> Visualizar despesa</a></li>
                    </ul>
                </li>
                 <li style="<?php if ($_SESSION['usertype']!='admin') echo "display:none;"; ?>">
                    <a href="#" data-toggle="collapse" data-target="#submenu-4"><i class="fa fa-fw fa-lock"></i>  Segurança <i class="fa fa-fw fa-angle-down pull-right"></i></a>
                    <ul id="submenu-4" class="collapse">
                        <li><a href="<?php echo BASEURL; ?>security/add_user.php"><i class="fa fa-angle-double-right"></i> Cadastrar Usuário</a></li>
                         <li><a href="<?php echo BASEURL; ?>security/view_user.php"><i class="fa fa-angle-double-right"></i> Visualizar Usuário</a></li>
                    </ul>
                </li>

                 <li>
                    <a href="https://mailchimp.com/" target="_blank"><i class="fa fa-fw fa-envelope"></i>  MailChimp</a>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>