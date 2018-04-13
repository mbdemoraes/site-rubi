<?php
require_once('functions.php');
require_once DBAPI;

if (isset($_GET['term'])){
	$return_arr = searchCustomersNameSearch($_GET['term']);
    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}


?>