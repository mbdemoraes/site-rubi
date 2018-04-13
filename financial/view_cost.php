<?php
include('../session.php');
?>
<?php
    require_once('functions.php');
    index();
?>

<?php include(HEADER_TEMPLATE); ?>

<header>
    <div class="row">
        <div class="col-sm-6">
            <h2>Busca e edição de Despesas</h2>
        </div>
        <div class="col-sm-6 text-right h2">
            <a class="btn btn-primary" href="add_cost.php"><i class="fa fa-plus"></i> Nova Despesa</a>
            <a class="btn btn-default" href="view_cost.php"><i class="fa fa-refresh"></i> Atualizar</a>
        </div>

    </div>
</header>
<br><br><br>
<div class="container">
        <div class="row">
               <?php if (!empty($_SESSION['message'])) : ?>
                              <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $_SESSION['message']; ?>
                              </div>
                              <?php unset($_SESSION['message']); ?>
                            <?php endif; ?>
            <div class="col-lg-12">

<table id="tableCourses" class="table table-striped table-bordered" cellspacing="0" width="100%">
       <thead>
    <tr>
        <th>ID</th>
        <th width="30%">Tipo</th>
        <th> Valor </th>
        <th> Pagamento</th>
        <th> Vencimento</th>
        <th>Opções</th>
    </tr>
</thead>
<tbody>
<?php if ($costs) : ?>
<?php foreach ($costs as $cost) : ?>
    <tr>
        <td><?php if(isset($cost['id'])) { echo $cost['id']; }  ?></td>
        <td><?php echo $cost['type_var']; ?></td>
        <td><?php echo $cost['value_dec']; ?></td>
        <td><?php if($cost['payment_tni']==1) { echo "Pagamento Realizado"; } else { echo "Aguardando Pagamento"; } ?></td>
        <td><?php $date = date_create($cost['deadline_dt']); echo date_format($date, 'd/m/Y'); ?></td>
        <td class="actions text-right">
            <a href="edit_cost.php?id=<?php echo $cost['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Editar</a>
             <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" data-customer="<?php echo $cost['id']; ?>">
                <i class="fa fa-trash"></i> Excluir
            </a>
        </td>
    </tr>
<?php endforeach; ?>

<?php else : ?>
    <tr>
        <td colspan="6">Nenhum registro encontrado.</td>
    </tr>
<?php endif; ?>
</tbody>
</table>
</div>

                </div>
            </div>

<script type="text/javascript">
$(document).ready( function() {
  $('#tableCourses').dataTable( {
    "oLanguage": {
      "sSearch": "Buscar despesas:",
      "sLengthMenu": "Mostrar _MENU_ despesas",
      "sInfo": "Mostrando _START_ até _END_ em um total de _TOTAL_ registros.",
      "sEmptyTable": "Nenhum registro encontrado.",
      "sInfoEmpty": "Nenhum registro para ser mostrado.",
      "sInfoFiltered": " - filtrado de um total de _MAX_ registros",
      "sZeroRecords": "Nenhum registro encontrado.",
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

