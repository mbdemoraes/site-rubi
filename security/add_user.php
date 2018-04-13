<?php
include('../session.php');
?>
<?php
  require_once('functions.php');
  add();
?>

<?php require_once DBAPI; ?>

<?php include(HEADER_TEMPLATE); ?>


<!-- Include Bootstrap Datepicker -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>



 <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            <h4>Cadastro de Usuário</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                              <?php if (!empty($_SESSION['message'])) : ?>
                              <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $_SESSION['message']; ?>
                              </div>
                              <?php unset($_SESSION['message']); ?>
                            <?php endif; ?>
                                <div class="col-lg-6">

                                    <form role="form" action="add_user.php" data-toggle="validator" method="post">

                                       <div class="form-group">

                                          <label for="sel1">Selecione o tipo de usuário:</label>
                                          <select class="form-control " name="user['userType_var']">
                                            <option value="operator">Operador</option>
                                             <option value="admin">Administrador</option>
                                          </select>

                                         </div>
                                           <div class="form-group">
                                            <label>Nome do Usuário</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-eye-open"></span></span>
                                            <input type="text" minlength="10" max="100" class="form-control" autocomplete="off" maxlength="30" name="user['name_var']" placeholder="Digite o nome do usuário..." type="text"
                                                  data-error="Por favor, informe um nome válido. Mínimo de 10 e máximo de 100 caracteres." required>
                                             </div>
                                             <div class="help-block with-errors"></div>
                                         </div>

                                         <div class="form-group">
                                            <label>Login</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-eye-open"></span></span>
                                            <input type="text" minlength="10" maxlength="20" class="form-control" autocomplete="off" minlength="5" maxlength="30" name="user['username_var']" placeholder="Digite o login do usuário..." type="text"
                                                  data-error="Por favor, informe um login válido. Mínimo de 10 e máximo de 20 caracteres." required>
                                             </div>
                                             <div class="help-block with-errors"></div>
                                         </div>

                                          <div class="form-group" >
                                        <label>Senha</label>

                                        <div class="input-group input-append date" >
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-qrcode"></span></span>
                                            <input type="password" autocomplete="off" minlength="4" maxlength="20" class="form-control" name="user['password_var']" placeholder="Informe a senha do usuário..." data-error="Por favor, informe uma senha válida. Mínimo de 4 e máximo de 20 caracteres." required/>

                                        </div>
                                        <div class="help-block with-errors"></div>

                                    </div>


                                        <button type="submit" class="btn btn-success">Cadastrar</button>
                                        <button type="reset" class="btn btn-warning">Desfazer</button>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->


                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>


        <?php include(FOOTER_TEMPLATE); ?>