<?php
include('../session.php');
?>
<?php
  require_once('functions.php');
  edit();
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
                            <h4>Cadastro de Despesa</h4>
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

                                    <form role="form" action="edit_cost.php?id=<?php echo $cost['id']; ?>"  data-toggle="validator" method="post">

                                       <div class="form-group">

                                          <label for="sel1">Selecione o tipo de despesa:</label>
                                          <select class="form-control " id="costType" name="cost['type_var']" value="<?php echo $cost['type_var']; ?>">
                                            <option value="Professor"  <?php if($cost['type_var']=="Professor") echo 'selected="selected"'; ?> >Pagamento de Professor</option>
                                            <option value="Materiais" <?php if($cost['type_var']=="Materiais") echo 'selected="selected"'; ?> >Materiais de Construção</option>
                                            <option value="Energia"<?php if($cost['type_var']=="Energia") echo 'selected="selected"'; ?> >Luz e Energia </option>
                                            <option value="Agua"<?php if($cost['type_var']=="Agua") echo 'selected="selected"'; ?> > Água </option>
                                          </select>

                                         </div>

                                          <div class="form-group">

                                          <label for="sel1">Depesa paga:</label>
                                          <select class="form-control " id="payment" name="cost['payment_tni']" value="<?php echo $cost['payment_tni']; ?>">
                                            <option value="1" <?php if($cost['payment_tni']==1) echo 'selected="selected"'; ?>>Pagamento Realizado</option>
                                            <option value="0" <?php if($cost['payment_tni']==0) echo 'selected="selected"'; ?>>Aguardando Pagamento</option>
                                          </select>

                                         </div>

                                         <div class="form-group">
                                            <label>Valor da Despesa</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-usd"></span></span>
                                            <input type="text" class="form-control" autocomplete="off" name="cost['value_dec']" value="<?php echo $cost['value_dec']; ?>" placeholder="Digite o valor da despesa..." type="text"
                                                  data-error="Por favor, informe um valor da despesa válido." required>
                                             </div>
                                             <p class="help-block">Valores permitidos: entre 1 e 3000. Para adicionar casas decimais, utilizar o ponto (.) Ex: O valor "3.000,70"  deve ser inserido como "3000.70" (sem as aspas).</p>
                                             <div class="help-block with-errors"></div>
                                         </div>

                                         <div class="form-group" >
                                        <label>Vencimento da Despesa</label>

                                        <div class="input-group input-append date" id="datePicker">
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input type="text" id="deadline" autocomplete="off" class="form-control" name="cost['deadline_dt']" value="<?php echo date('d/m/Y', strtotime($cost['deadline_dt']));  ?>" />

                                        </div>
                                        <br>
                                         <button type="submit" class="btn btn-primary">Atualizar</button>
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

<script>
$(document).ready(function() {
    $('#datePicker')
        .datepicker({
            format: 'dd/mm/yyyy'
        })
        .on('changeDate', function(e) {
            // Revalidate the date field
            $('#eventForm').formValidation('revalidateField', 'date');
        });
});

jQuery(function($){

   $("#deadline").mask("99/99/9999");

});
</script>
        <?php include(FOOTER_TEMPLATE); ?>