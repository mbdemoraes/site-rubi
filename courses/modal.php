<!-- Modal de Delete-->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
      </div>
      <div class="modal-body">
        Deseja realmente excluir este item?
      </div>
      <div class="modal-footer">
        <a id="confirm" class="btn btn-primary" href="#">Sim</a>
        <a id="cancel" class="btn btn-default" data-dismiss="modal">N&atilde;o</a>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->

<!-- Modal de Delete do Cliente em Curso-->
<div class="modal fade" id="delete-modal-customer" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
      </div>
      <div class="modal-body">
        Deseja realmente excluir este item?
      </div>
      <div class="modal-footer">
        <a id="confirm" class="btn btn-primary" href="#">Sim</a>
        <a id="cancel" class="btn btn-default" data-dismiss="modal">N&atilde;o</a>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->

<!-- Modal de Delete do Cliente em Curso-->
<div class="modal fade" id="delete-modal-customer-waiting" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
      </div>
      <div class="modal-body">
        Deseja realmente excluir este item?
      </div>
      <div class="modal-footer">
        <a id="confirm" class="btn btn-primary" href="#">Sim</a>
        <a id="cancel" class="btn btn-default" data-dismiss="modal">N&atilde;o</a>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->

<!-- Modal de Delete do Cliente em Curso-->
<div class="modal fade" id="payment-modal-customer" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Atualização de Pagamento</h4>
      </div>
      <div class="modal-body">
        Deseja realmente atualizar o pagamento?
      </div>
      <div class="modal-footer">
        <a id="confirm" class="btn btn-primary" href="#">Sim</a>
        <a id="cancel" class="btn btn-default" data-dismiss="modal">N&atilde;o</a>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->

<!-- Modal de Delete do Cliente em Curso-->
<div class="modal fade" id="open-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Reabertura de Curso</h4>
      </div>
      <div class="modal-body">
        Deseja realmente reabrir este curso?
      </div>
      <div class="modal-footer">
        <a id="confirm" class="btn btn-primary" href="#">Sim</a>
        <a id="cancel" class="btn btn-default" data-dismiss="modal">N&atilde;o</a>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->

<script type="text/javascript">

/**
 * Passa os dados do cliente para o Modal, e atualiza o link para exclusão
 */
$('#delete-modal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
   var id = button.data('customer');

  var modal = $(this);
  modal.find('.modal-title').text('Excluir Curso #' + id);
  modal.find('#confirm').attr('href', 'delete.php?id=' + id);
})

$('#open-modal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
   var id = button.data('customer');

  var modal = $(this);
  modal.find('.modal-title').text('Reabrir Curso #' + id);
  modal.find('#confirm').attr('href', 'open_course.php?id=' + id);
})

/**
 * Passa os dados do cliente para o Modal, e atualiza o link para exclusão
 */
$('#delete-modal-customer').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
   var id = button.data('customer');
   var courseId = button.data('course');

  var modal = $(this);
  modal.find('.modal-title').text('Excluir Inscrito #' + id);
  modal.find('#confirm').attr('href', 'deleteCustomer.php?id=' + id + '&courseId=' + courseId);
})

/**
 * Passa os dados do cliente para o Modal, e atualiza o link para exclusão
 */
$('#delete-modal-customer-waiting').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
   var id = button.data('customer');
   var courseId = button.data('course');

  var modal = $(this);
  modal.find('.modal-title').text('Excluir Cliente da Lista#' + id);
  modal.find('#confirm').attr('href', 'delete_customer_waiting.php?id=' + id + '&courseId=' + courseId );
})

/**
 * Passa os dados do cliente para o Modal, e atualiza o link para exclusão
 */
$('#payment-modal-customer').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget);
   var id = button.data('customer');
   var payment = button.data('payment');

  var modal = $(this);
  //se for cancelar o pagamento
  if(payment==1) {
    modal.find('.modal-title').text('Cancelar Pagamento #' + id);
    modal.find('#confirm').attr('href', 'payment.php?id=' + id + '&payment=' + payment);
  } else {
    modal.find('.modal-title').text('Realizar Pagamento #' + id);
    modal.find('#confirm').attr('href', 'payment.php?id=' + id + '&payment=' + payment);
  }

})


</script>