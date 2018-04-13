<?php
require_once('functions.php');
require_once('../financial/functions.php');
$all_cashflow = getAllFlows();


if (!empty($all_cashflow)) {
    $headings = array('Balanco_ID', 'Mes', 'Ano', 'Despesas', 'Receitas', 'Balanco');
    echo outputCSV($all_cashflow, $headings);
    die();
} else {

}

?>