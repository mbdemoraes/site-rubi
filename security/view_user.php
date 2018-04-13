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
            <h2>Busca e edição de Usuários</h2>
        </div>
        <div class="col-sm-6 text-right h2">
            <a class="btn btn-primary" href="add_user.php"><i class="fa fa-plus"></i> Novo Usuário</a>
            <a class="btn btn-default" href="view_user.php"><i class="fa fa-refresh"></i> Atualizar</a>
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

                            <?php endif; ?>
            <div class="col-lg-12">

<table id="tableCustomers" class="table table-striped table-bordered" cellspacing="0" width="100%">
       <thead>
    <tr>
        <th>ID</th>
        <th width="30%">Nome do Usuário</th>
        <th width="30%">Login</th>
        <th>Tipo de Usuário</th>
        <th>Opções</th>
    </tr>
</thead>
<tbody>
<?php if ($users) : ?>
<?php foreach ($users as $user) : ?>
    <tr>
        <td><?php if(isset($user['id'])) { echo $user['id']; }  ?></td>
        <td><?php echo $user['name_var']; ?></td>
        <td><?php echo $user['username_var']; ?></td>
        <td><?php if($user['userType_var']=="admin") { echo "Administrador";} else { echo "Operador";} ?></td>
        <td class="actions text-right">
            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Editar</a>
            <a href="#" class="btn btn-sm btn-danger <?php if ($_SESSION['usertype']!='admin') echo "disabled"; ?>" data-toggle="modal" data-target="#delete-modal" data-customer="<?php echo $user['id']; ?>">
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
  $('#tableCustomers').dataTable( {
    "oLanguage": {
      "sSearch": "Buscar clientes:",
      "sLengthMenu": "Mostrar _MENU_ clientes",
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

