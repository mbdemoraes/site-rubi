<?php
include('../session.php');
?>
<?php
    require_once('functions.php');
    //indexCourseCustomers('tbl_courses_id', $_GET['id']);
    searchCustomersByCourseId($_GET['id']);
    search($_GET['id']);
    calculateNumSlotsTaken($_GET['id']);
    searchWaitingListByCourseId($_GET['id']);
?>
<?php include(HEADER_TEMPLATE); ?>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {

  //autocomplete
  $(".auto").autocomplete({
    source: "search.php",
    minLength: 1
  });

});
</script>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            <h4>Inscrições para o curso de <?php If(!empty($courses['name_var'])) echo $courses['name_var']; ?> </h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                              <div class="col-lg-12" align="right">
                               <a class="btn btn-default" href="view_course_customers.php?id=<?php echo $_GET['id']; ?>"><i class="fa fa-refresh"></i> Atualizar</a>
                        <a href="<?php echo BASEURL; ?>download/download.php?courseId=<?php $aux; $aux = $courseCustomers[0]; echo $aux['tbl_courses_id']; ?>" class="btn  btn-primary"><i class="fa fa-download"></i> Download Inscritos</a>
                    </div>
                            <?php if (!empty($_SESSION['message'])) : ?>
                              <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $_SESSION['message']; ?>
                              </div>
                              <?php unset($_SESSION['message']); ?>
                            <?php endif; ?>
                                <div class="col-lg-4">
                                        <form action='include_customer.php' method='post'>
                                          <label>Incluir Cliente:</label>
                                          <div class="form-group input-group" >
                                           <input type="hidden" name="courseId" class="form-control" value="<?php echo $_GET['id']; ?>">
                                            <input type="text" name='includeCustomer' value='' class='auto form-control' placeholder="Pesquise um cliente (por nome)...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit" <?php if($courses['status_var']!='Aberto') echo "disabled"; ?>><i class="fa fa-check"></i>
                                                </button>
                                            </span>
                                        </div>

                                        </form>
                                         <div class="form-group">
                                            <label>Quantidade de Vagas</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-tasks"></span></span>
                                            <input type="text" class="form-control" name="courses['numSlots_int']" value="<?php echo $courses['numSlots_int']; ?>" disabled>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                            <label>Quantidade de Vagas Preenchidas</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-tasks"></span></span>
                                            <input type="text" class="form-control" name="courses['numSlotsTaken_int']" value="<?php echo $courses['numSlotsTaken_int']; ?>" disabled>
                                             </div>
                                         </div>
                                          <div class="form-group">
                                            <label>Quantidade de Clientes na Lista de Espera</label>
                                            <div class="input-group input-append">
                                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-tasks"></span></span>
                                            <input type="text" class="form-control" name="numCustomersWaitingList" value="<?php if(isset($customersWaiting)) echo count($customersWaiting); ?>" disabled>
                                             </div>
                                         </div>
                                        </div>


                                        <div class="container">
                                        <br>
        <div class="row">
            <div class="col-lg-12" style="border: 1px solid;border-color: #ddd">
            <div align="center"> <h4> Clientes Inscritos </h4> </div>

<table id="tableCourseCustomers" class="table table-striped table-bordered" cellspacing="0" width="100%" >
       <thead>
    <tr>
        <th>Nome do Inscrito</th>
        <th>Situação de Pagamento</th>
        <th>Tipo de Pagamento</th>
        <th>Info. de Pagamento</th>
        <th>Incluído em</th>
        <th>Opções</th>
    </tr>
</thead>
<tbody>

<?php if ($courseCustomers) : ?>
<?php foreach ($courseCustomers as $courseCustomer) : ?>
    <tr>
        <td><?php echo $courseCustomer['tbl_customers_name_var']; ?></td>
        <td><?php if($courseCustomer['payment_tni']==0) { echo "Vaga Reservada"; } else { echo "Pagamento Realizado"; } ?></td>
        <td>
        <?php

            switch($courseCustomer['payment_type_var']) {
              case "none":
                echo "";
                break;
              case "check":
                echo "Cheque";
                break;
              case "debit":
                echo "Cartão de Débito";
                break;
              case "credit":
                echo "Cartão de Crédito";
                break;
              case "bankslip":
                echo "Boleto Bancário";
                break;
              case "money":
                echo "Dinheiro";
                break;
              default:
                echo "";
                break;
            }

        ?>

        </td>
        <td><?php echo $courseCustomer['payment_info_var']; ?></td>
        <td><?php $date = date_create($courseCustomer['creation_date_dt']); echo date_format($date, 'd/m/Y'); ?></td>
        <td>
              <a href="edit_payment.php?id=<?php echo $courseCustomer['id']; ?>"  target="_blank" class="btn btn-success"><i class="fa fa-dollar"></i> Pagamento</a>
        <a href="#" class="btn btn-danger <?php if($courses['status_var']!='Aberto') echo "disabled"; ?> <?php if ($_SESSION['usertype']!='admin') echo "disabled"; ?>"" data-toggle="modal" data-target="#delete-modal-customer" data-course="<?php echo $courseCustomer['tbl_courses_id']; ?>" data-customer="<?php echo $courseCustomer['id']; ?>">
                                            <i class="fa fa-trash"></i> Excluir
                                        </a>


        </td>
    </tr>

<?php endforeach; ?>

<?php else : ?>
    <tr>
        <td colspan="6"> Nenhum registro encontrado.</td>
    </tr>
<?php endif; ?>

</tbody>
</table>


</div>

                                        </div>
                                        <br><br>
<div class="row" align="center" style="border: 1px solid;border-color: #ddd">
                <div class="col-lg-12" align="center">
                 <div align="center"> <h4> Lista de Espera </h4> </div>
                        <br>
<table id="tableWaitingList" class="table table-striped table-bordered"  align="center" cellspacing="0" width="100%">
       <thead>
    <tr>
        <th>ID da Espera</th>
        <th>Nome do Cliente</th>
        <th>Data de Inclusão na Lista</th>
        <th>Opções</th>
    </tr>
</thead>
<tbody>

<?php if ($customersWaiting) : ?>
<?php foreach ($customersWaiting as $waiting) : ?>
    <tr>
        <td><?php echo $waiting['id']; ?></td>
        <td><?php echo $waiting['tbl_customers_name_var']; ?></td>
         <td><?php $date = date_create($waiting['creation_date_dt']); echo date_format($date, 'd/m/Y'); ?></td>
        <td>
              <a href="include_customer_fromlist.php?idCustomer=<?php echo $waiting['tbl_customers_id']; ?>&courseId=<?php echo $waiting['tbl_courses_id']; ?>" class="btn btn-primary <?php if($courses['status_var']!='Aberto') echo "disabled"; ?>" ><i class="fa fa-user"></i> Adicionar ao Curso</a>
        <a href="#" class="btn btn-danger <?php if($courses['status_var']!='Aberto') echo "disabled"; ?> <?php if ($_SESSION['usertype']!='admin') echo "disabled"; ?>"" data-toggle="modal" data-target="#delete-modal-customer-waiting" data-course="<?php echo $waiting['tbl_courses_id']; ?>" data-customer="<?php echo $waiting['tbl_customers_id']; ?>" >
                                            <i class="fa fa-trash"></i> Excluir
                                        </a>


        </td>
    </tr>

<?php endforeach; ?>

<?php else : ?>
    <tr>
        <td colspan="6"> Não existem clientes na lista de espera para este curso.</td>
    </tr>
<?php endif; ?>

</tbody>
</table>

</div>
</div>

                                        </div>

                                        </div>
                                        </div>
<script type="text/javascript">
$(document).ready( function() {
  $('#tableCourseCustomers').dataTable( {
    "oLanguage": {
      "sSearch": "Buscar clientes:",
      "sLengthMenu": "Mostrar _MENU_ clientes",
      "sInfo": "Mostrando _START_ até _END_ em um total de _TOTAL_ registros.",
      "sEmptyTable": "Nenhum registro encontrado.",
      "sInfoEmpty": "Nenhum registro para ser mostrado.",
      "sInfoFiltered": " - filtrado de um total de _MAX_ registros",
      "sZeroRecords": "Nenhum cliente inscrito.",
      "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior"
      }
    }
  } );


} );

</script>
<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>

