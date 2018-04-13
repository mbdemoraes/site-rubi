<?php
include('../session.php');
?>
<?php
  require_once('functions.php');
  editPayment();
?>
<?php require_once DBAPI; ?>

<?php include(HEADER_TEMPLATE); ?>

<!-- Include Bootstrap Datepicker -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<style type="text/css">
/**
 * Override feedback icon position
 * See http://formvalidation.io/examples/adjusting-feedback-icon-position/
 */
#eventForm .form-control-feedback {
    top: 0;
    right: -15px;
}
</style>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            <h4>Opções de Pagamento</h4>
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

                                    <form role="form" action="edit_payment.php?id=<?php echo $courseCustomer['id']; ?>" data-toggle="validator" method="post">
                                      <div class="form-group">
                                            <label>Curso</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-book"></span></span>
                                            <input type="text" class="form-control" name="courseCustomer['tbl_courses_name_var']" data-error="Por favor, informe um nome de curso válido." value="<?php echo $courseCustomer['tbl_courses_name_var']; ?>" disabled required >
                                             </div>
                                              <div class="help-block with-errors"></div>
                                         </div>
                                         <div class="form-group">
                                            <label>Nome do Cliente</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-book"></span></span>
                                            <input type="text" class="form-control" name="courseCustomer['tbl_customers_name_var']" data-error="Por favor, informe um nome de curso válido." value="<?php echo $courseCustomer['tbl_customers_name_var']; ?>" disabled required >
                                             </div>
                                              <div class="help-block with-errors"></div>
                                         </div>
                                           <div class="form-group" >

                                          <label for="sel1">Selecione a situação de pagamento:</label>
                                          <select class="form-control " name="courseCustomer['payment_tni']" value="<?php echo $courseCustomer['payment_tni']; ?>" id="paymentSituation">
                                           <option value="0"  <?php if($courseCustomer['payment_tni']==0) echo 'selected="selected"'; ?>>Vaga Reservada</option>
                                           <option value="1"  <?php if($courseCustomer['payment_tni']==1) echo 'selected="selected"'; ?>>Pagamento Realizado</option>
                                          </select>
                                          </div>
                                          <div class="form-group" id="paymentType" style="<?php if($courseCustomer['payment_tni']==0) echo "display: none;"; ?>">
                                          <label for="sel1">Selecione o tipo de pagamento:</label>
                                          <select class="form-control " name="courseCustomer['payment_type_var']" id="selectPaymentType" >
                                           <option value="none" <?php if($courseCustomer['payment_type_var']=="none") echo 'selected="selected"'; ?> >Não aplicável</option>
                                           <option value="check" <?php if($courseCustomer['payment_type_var']=="check") echo 'selected="selected"'; ?>>Cheque</option>
                                            <option value="bankslip" <?php if($courseCustomer['payment_type_var']=="bankslip") echo 'selected="selected"'; ?>>Boleto</option>
                                            <option value="credit" <?php if($courseCustomer['payment_type_var']=="credit") echo 'selected="selected"'; ?>>Cartão de Crédito</option>
                                            <option value="money"  <?php if($courseCustomer['payment_type_var']=="money") echo 'selected="selected"'; ?>>Dinheiro</option>
                                            <option value="debit"  <?php if($courseCustomer['payment_type_var']=="debit") echo 'selected="selected"'; ?>>Cartão de Débito</option>
                                          </select>
                                           <p class="help-block"> Caso seja uma reserva ou promoção, selecionar a opção "Não aplicável". </p>

                                         </div>


                                          <div class="form-group">
                                            <label>Informação de Pagamento/Reserva</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-book"></span></span>
                                            <input type="text" class="form-control" autocomplete="off" name="courseCustomer['payment_info_var']" data-error="Por favor, informe uma informação válida." value="<?php echo $courseCustomer['payment_info_var']; ?>" required>
                                             </div>
                                              <div class="help-block with-errors"></div>
                                               <p class="help-block"> Campo para preenchimento de informações adicionais de pagamento. Se for uma reserva ou promoção, informar aqui o motivo. Se o pagamento for via Cartão, informar o número da fatura. Se o pagamento for via Boleto, informar o número do mesmo. Se for via Cheque, informar o número do cheque.</p>
                                         </div>

                                           <div class="form-group" id="divPaymentDate" style="<?php if($courseCustomer['payment_tni']==0) echo "display: none;"; ?>">
                                        <label>Data de Pagamento</label>

                                        <div class="input-group input-append date" id="datePicker">
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input type="text" id="payment_date" autocomplete="off" class="form-control" name="courseCustomer['payment_date_dt']" value="<?php if($courseCustomer['payment_date_dt']==NULL || $courseCustomer['payment_date_dt']=='1970-01-01') { echo ""; } else { echo date('d/m/Y', strtotime($courseCustomer['payment_date_dt'])); }  ?>" placeholder="Informe o vencimento da despesa..." data-error="Por favor, informe uma data de vencimento válida."/>

                                        </div>
                                        <div class="help-block with-errors"></div>

                                    </div>



                                         <button type="submit" class="btn btn-primary">Atualizar</button>
                                        <button type="reset" class="btn btn-warning">Desfazer</button>


                                    </div>
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

   $("#payment_date").mask("99/99/9999");

});

$('#paymentSituation').on('change',function(){
    if( $(this).val()==="1"){
    $("#paymentType").show()
    $("#divPaymentDate").show()
    $('#selectPaymentType').prop('required',true);
    $('#payment_date').prop('required',true);
    }
    else{
    $("#paymentType").hide()
    $("#divPaymentDate").hide()
    }
});
</script>