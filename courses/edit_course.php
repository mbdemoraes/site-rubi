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
                            <h4>Edição de Curso</h4>
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

                                    <form role="form" action="edit_course.php?id=<?php echo $course['id']; ?>" data-toggle="validator" method="post">
                                         <div class="form-group">
                                            <label>Nome do Curso</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-book"></span></span>
                                            <input type="text" minlength="10" maxlength="100" class="form-control" autocomplete="off" name="course['name_var']" data-error="Por favor, informe um nome de curso válido. Mínimo de 10 e máximo de 100 caracteres." value="<?php echo $course['name_var']; ?>" required <?php if($course['status_var']=='Fechado' || $course['status_var']=='Cancelado') echo "disabled"; ?> >
                                             </div>
                                              <div class="help-block with-errors"></div>
                                         </div>

                                         <div class="form-group">

                                          <label for="sel1">Status</label>
                                          <select class="form-control " id="status" name="course['status_var']" <?php if($course['status_var']=='Fechado' || $course['status_var']=='Cancelado') echo "disabled"; ?> >
                                            <option value="Aberto"  <?php if($course['status_var']=="Aberto") echo 'selected="selected"'; ?> >Aberto</option>
                                            <option value="Fechado" <?php if($course['status_var']=="Fechado") echo 'selected="selected"'; ?> >Fechado</option>
                                            <option value="Cancelado"<?php if($course['status_var']=="Cancelado") echo 'selected="selected"'; ?> > Cancelado </option>
                                          </select>

                                         </div>
                                        <div class="form-group">
                                            <label>Nome do Professor/Palestrante</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-user"></span></span>
                                            <input type="text" class="form-control" data-error="Por favor, informe um nome válido. Mínimo de 10 e máximo de 100 caracteres." autocomplete="off" name="course['professor_var']" value="<?php echo $course['professor_var']; ?>" required <?php if($course['status_var']=='Fechado' || $course['status_var']=='Cancelado') echo "disabled"; ?> >
                                             </div>
                                              <div class="help-block with-errors"></div>
                                         </div>
                                         <div class="form-group">
                                            <label>Quantidade de Vagas</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-tasks"></span></span>
                                            <input type="number" min="1" max="100" autocomplete="off" class="form-control" name="course['numSlots_int']" data-error="Por favor, informe uma quantidade válida. Mínimo de 1 e máximo de 100 vagas." value="<?php echo $course['numSlots_int']; ?>" required <?php if($course['status_var']=='Fechado' || $course['status_var']=='Cancelado') echo "disabled"; ?> >
                                             </div>
                                             <p class="help-block">Valores permitidos: entre 1 e 100. </p>
                                              <div class="help-block with-errors"></div>
                                         </div>


                                         <div class="form-group">
                                            <label>Quantidade de Vagas Preenchidas</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-tasks"></span></span>
                                             <input type="hidden" name="course['numSlotsTaken_int']" value="<?php echo $course['numSlotsTaken_int']; ?>">
                                            <input type="text" class="form-control" name="course['numSlotsTaken_int']" value="<?php echo $course['numSlotsTaken_int']; ?>" disabled>
                                             </div>
                                         </div>

                                         <div class="form-group">
                                            <label>Valor do Curso</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-usd"></span></span>
                                            <input type="number" min="1" max="3000" step="0.1" autocomplete="off" class="form-control" name="course['price_dec']" data-error="Por favor, informe um valor válido." value="<?php echo $course['price_dec']; ?>" data-error="Por favor, informe um CPF válido"  required <?php if($course['status_var']=='Fechado' || $course['status_var']=='Cancelado') echo "disabled"; ?> >
                                             </div>
                                              <p class="help-block">Valores permitidos: entre 1 e 3000. Para adicionar casas decimais, utilizar o ponto (.) Ex: O valor "3.000,70"  deve ser inserido como "3000.70" (sem as aspas).</p>
                                             <div class="help-block with-errors"></div>
                                         </div>


                                        <div class="form-group" >
                                        <label>Data do Curso</label>

                                        <div class="input-group input-append date" id="datePicker">
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input type="text" id="event_date" class="form-control" autocomplete="off" required name="course['event_date_dt']" data-error="Por favor, informe uma data válida." value="<?php echo date('d/m/Y', strtotime($course['event_date_dt']));  ?>"  <?php if($course['status_var']=='Fechado' || $course['status_var']=='Cancelado') echo "disabled"; ?> />

                                        </div>
                                         <div class="help-block with-errors"></div>

                                    </div>
                                      <div class="form-group">
                                            <label>Horário do Curso</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-usd"></span></span>
                                            <input type="text" id="event_hour" autocomplete="off" class="form-control" name="course['event_hour_var']" data-error="Por favor, informe um horário válido." required value="<?php echo $course['event_hour_var']; ?>" placeholder="Digite o horário do curso ..."  data-error="Por favor, informe um horário válido." required <?php if($course['status_var']=='Fechado' || $course['status_var']=='Cancelado') echo "disabled"; ?> >
                                             </div>
                                              <div class="help-block with-errors"></div>
                                         </div>
                                          <div class="form-group" id="justification" style="<?php if($course['status_var']=='Aberto') echo "display: none;"; ?>">
                                            <label>Justificativa de Cancelamento</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-usd"></span></span>
                                            <input type="text" minlength="10" maxlength="90" autocomplete="off" class="form-control" id="inputJustification" name="course['justification_var']" data-error="Por favor, informe uma justificativa válida." placeholder="Digite a justificativa de cancelamento."  value="<?php echo $course['justification_var']; ?>" >
                                             </div>
                                              <div class="help-block with-errors"></div>
                                         </div>
                                          <div class="help-block with-errors"></div>


                                         <button type="submit" class="btn btn-primary">Atualizar</button>
                                        <button type="reset" class="btn btn-warning">Desfazer</button>

                                        <a href="#" class="btn btn-danger <?php if ($_SESSION['usertype']!='admin') echo "disabled"; ?>" <?php if($course['status_var']=='Fechado') echo "disabled"; ?> data-toggle="modal" data-target="#delete-modal" data-customer="<?php echo $course['id']; ?>">
                                            <i class="fa fa-trash"></i> Excluir
                                        </a>
                                        <a href="#" class="btn btn-danger <?php if ($_SESSION['usertype']!='admin') echo "disabled"; ?>" <?php if($course['status_var']=='Aberto') echo "disabled"; ?> data-toggle="modal" data-target="#open-modal" data-customer="<?php echo $course['id']; ?>">
                                            <i class="fa fa-folder-open-o"></i> Reabrir Curso
                                        </a>

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

   $("#event_hour").mask("99:99");
    $("#event_date").mask("99/99/9999");


});

$('#status').on('change',function(){
    if( $(this).val()==="Cancelado"){
    $("#justification").show()
    $('#inputJustification').prop('required',true);
    }
    else{
    $("#justification").hide()
    }
});



</script>
<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>