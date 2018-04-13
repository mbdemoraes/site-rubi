<?php
require_once('functions.php');
require_once('../courses/functions.php');
#findElementByColumnNumber('tbl_course_customers', 'tbl_courses_id', $_GET['courseId']);
searchCustomersByCourseId($_GET['courseId']);

if ($courseCustomers) {
    $headings = array('ID da Inscricao', 'IDdoCurso', 'NomeDoCurso', 'IDdoCliente', 'NomeDoCliente', 'SituacaoPagamento', 'TipoPagamento', 'InformacoesPagamento', 'DataPagamento', 'DataCriacao', 'DatadeModificacao');
    echo outputCSV($courseCustomers, $headings);
    die();
} else {

}

?>