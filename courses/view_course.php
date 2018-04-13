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
            <h2>Busca e edição de Cursos</h2>
        </div>
        <div class="col-sm-6 text-right h2">
            <a class="btn btn-primary" href="add_course.php"><i class="fa fa-plus"></i> Novo Curso</a>
            <a class="btn btn-default" href="view_course.php"><i class="fa fa-refresh"></i> Atualizar</a>
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
        <th width="30%">Nome</th>
        <th> Status </th>
        <th>Qtd. Vagas</th>
        <th>Qtd. Preenchidas</th>
        <th>Data do Evento</th>
        <th>Opções</th>
    </tr>
</thead>
<tbody>
<?php if ($courses) : ?>
<?php foreach ($courses as $course) : ?>
    <tr>
        <td><?php if(isset($course['id'])) { echo $course['id']; }  ?></td>
        <td><?php echo $course['name_var']; ?></td>
        <td><?php echo $course['status_var']; ?></td>
        <td><?php echo $course['numSlots_int']; ?></td>
        <td><?php echo $course['numSlotsTaken_int']; ?></td>
        <td><?php $date = date_create($course['event_date_dt']); echo date_format($date, 'd/m/Y'); ?></td>
        <td class="actions text-right">
            <a href="view_course_customers.php?id=<?php echo $course['id']; ?>" class="btn btn-sm btn-primary" ><i class="fa fa-user-plus"></i> Inscrições</a>
            <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Editar</a>
             <a href="#" class="btn btn-sm btn-danger <?php if ($_SESSION['usertype']!='admin') echo "disabled"; ?>" data-toggle="modal" data-target="#delete-modal" data-customer="<?php echo $course['id']; ?>">
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

