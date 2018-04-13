<?php
require_once('../config.php');
require_once(DBAPI);

$jsonTable = null;

function getMostWantedCourses() {

    try {
        $results = find_most_wanted_courses();
        global $jsonTable;
         $table = array();
        $table['cols'] = array(
        //Labels for the chart, these represent the column titles
        array('id' => '', 'label' => 'Nome do Curso', 'type' => 'string'),
        array('id' => '', 'label' => 'Quantidade de Inscritos', 'type' => 'number')
    );

        $rows = array();
        foreach($results as $row){
            $temp = array();

            //Values
            $temp[] = array('v' => (string) $row['name_var']);
            $temp[] = array('v' => (float) $row['counter']);
            $rows[] = array('c' => $temp);
         }

        $table['rows'] = $rows;

        $jsonTable = json_encode($table, true);

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível recuperar os dados do gráfico de cursos mais procurados. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

}

function getBetterCustomers() {

    try {
        $results = find_better_customers();
        global $jsonTable;
         $table = array();
        $table['cols'] = array(
        //Labels for the chart, these represent the column titles
        array('id' => '', 'label' => 'Nome do Cliente', 'type' => 'string'),
        array('id' => '', 'label' => 'Quantidade de cursos inscritos', 'type' => 'number')
    );

        $rows = array();
        foreach($results as $row){
            $temp = array();

            //Values
            $temp[] = array('v' => (string) $row['name']);
            $temp[] = array('v' => (float) $row['counter']);
            $rows[] = array('c' => $temp);
         }

        $table['rows'] = $rows;

        $jsonTable = json_encode($table, true);

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível recuperar os dados do gráfico de cursos mais procurados. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

}

function getCompanyPerformance() {

     try {
        $results = find_cash_flow_performance();
        global $jsonTable;
         $table = array();
        $table['cols'] = array(
        //Labels for the chart, these represent the column titles
        array('id' => '', 'label' => 'Ano', 'type' => 'string'),
        array('id' => '', 'label' => 'Receitas', 'type' => 'number'),
        array('id' => '', 'label' => 'Despesas', 'type' => 'number')
    );

        $rows = array();
        foreach($results as $row){
            $temp = array();
            //Values
            $temp[] = array('v' => (string) $row['year_int']);
            $temp[] = array('v' => (string) $row['income_dec']);
            $temp[] = array('v' => (float) $row['costs_dec']);
            $rows[] = array('c' => $temp);
         }

        $table['rows'] = $rows;

        $jsonTable = json_encode($table, true);

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível recuperar os dados do gráfico de cursos mais procurados. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }
}

function getGender() {
     try {
        $results = find_gender_quantity();
        global $jsonTable;
         $table = array();
        $table['cols'] = array(
        //Labels for the chart, these represent the column titles
        array('label' => 'Genero', 'type' => 'string'),
        array('label' => 'Quantidade', 'type' => 'number')
    );

        $rows = array();
        foreach($results as $row){
            $temp = array();
            //Values
            $temp[] = array('v' => (string) $row['gender']);
            $temp[] = array('v' => (string) $row['counter']);
            $rows[] = array('c' => $temp);
         }

        $table['rows'] = $rows;

        $jsonTable = json_encode($table, JSON_NUMERIC_CHECK);

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível recuperar os dados do gráfico de cursos mais procurados. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }
}

?>