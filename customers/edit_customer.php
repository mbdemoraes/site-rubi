<?php
include('../session.php');
?>
<?php
  require_once('functions.php');
  edit();
  getInterests();
?>
<?php require_once DBAPI; ?>

<?php include(HEADER_TEMPLATE); ?>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default" align="center">
                        <div class="panel-heading">
                            <h4>Edição de Cliente</h4>
                        </div>
                        <div class="panel-body" align="left">
                            <div class="row">
                            <?php if (!empty($_SESSION['message'])) : ?>
                              <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $_SESSION['message']; ?>
                              </div>
                              <?php unset($_SESSION['message']); ?>
                            <?php endif; ?>
                                <div class="col-lg-6">
                                <form role="form" action="edit_customer.php?id=<?php echo $customer['id']; ?>" data-toggle="validator" method="post">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" minlength="10" maxlength="70" class="form-control" name="customer['name_var']" value="<?php echo $customer['name_var']; ?>" data-error="Por favor, informe um nome válido. Mínimo de 10 e máximo de 70 caracteres." autocomplete="off" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                         <label>Gênero</label> <br>
                                         <label class="radio-inline"><input type="radio" value="1" <?php if($customer['gender_tni']==1) echo 'checked'; ?> name="customer['gender_tni']" data-error="Por favor, selecione um gênero." required>
                                       Masculino</label>

                                         <label class="radio-inline"><input type="radio" value="0" <?php if($customer['gender_tni']==0) echo 'checked'; ?> required name="customer['gender_tni']"> Feminino</label>
                                          <div class="help-block with-errors"></div>
                                        </div>
                                 <div class="form-group">
                                    <label>Endereço</label>
                                    <input type="text" class="form-control" minlength="10" maxlength="100" name="customer['address_var']" value="<?php echo $customer['address_var']; ?>" data-error="Por favor, informe um endereço válido. Mínimo de 10 e máximo de 100 caracteres."  autocomplete="off" required>
                                    <div class="help-block with-errors"></div>

                                </div>
                                <div class="form-group">
                                    <label>RG</label>
                                    <input type="text" id="rg" class="form-control" name="customer['rg_var']" value="<?php echo $customer['rg_var']; ?>" data-error="Por favor, informe um RG válido." autocomplete="off" required>
                                    <div class="help-block with-errors"></div>
                                    <p class="help-block">Apenas números</p>
                                </div>
                                <div class="form-group">
                                    <label>CPF</label>
                                    <input type="text" id="cpf" class="form-control" name="customer['cpf_var']" value="<?php echo $customer['cpf_var']; ?>" data-error="Por favor, informe um CPF válido"  autocomplete="off" required>
                                    <div class="help-block with-errors"></div>
                                    <p class="help-block">Apenas números.</p>
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" minlength="5" maxlength="30" name="customer['email_var']" value="<?php echo $customer['email_var']; ?>" placeholder="Digite um e-mail válido..." data-error="Por favor, informe um e-mail válido. Mínimo de 5 e máximo de 30 caracteres."  autocomplete="off" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label>Telefone</label>

                                    <input type="text" id="phone" class="form-control" name="customer['phone_var']" value="<?php echo $customer['phone_var']; ?>" data-error="Por favor, informe um telefone válido."  autocomplete="off" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                 <div class="form-group">
                                            <label>Data de Nascimento</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input type="text" id="birthday" class="form-control" name="customer['birthday_dt']" value="<?php echo date('d/m/Y', strtotime($customer['birthday_dt']));  ?>" autocomplete="off" placeholder="Digite a data de nascimento do cliente..." type="text"
                                                  data-error="Por favor, informe uma data de nascimento válido." required>
                                             </div>
                                             <div class="help-block with-errors"></div>
                                         </div>

                                <div class="form-group">
                                    <label>Interesses</label>
                                            <?php if ($customerInterests) : ?>
                                                <?php foreach ($customerInterests as $value) : ?>

                                                    <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="interest['<?php echo $value['tbl_interests_id']; ?>']" value="0">
                                                    <input type="checkbox" value="1" <?php if($value['isinterest_tni']==1) echo "checked"; ?> name="interest['<?php echo $value['tbl_interests_id']; ?>']"><?php echo $value['name_var']; ?>
                                                </label>
                                            </div>

                                                <?php endforeach; ?>
                                            <?php endif; ?>



                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <button type="reset" class="btn btn-warning">Desfazer</button>

                            <a href="#" class="btn btn-danger <?php if ($_SESSION['usertype']!='admin') echo "disabled"; ?>" data-toggle="modal" data-target="#delete-modal" data-customer="<?php echo $customer['id']; ?>">
                                <i class="fa fa-trash"></i> Excluir
                            </a>

                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->

                </form>
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
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>

        <script type="text/javascript">
            jQuery(function($){

   $("#phone").mask("(99) 99999-9999");
    $("#rg").mask("99.999.999-9");
     $("#cpf").mask("999.999.999-99");
      $("#birthday").mask("99/99/9999");

});
        </script>