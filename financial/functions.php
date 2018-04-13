<?php
require_once('../config.php');
require_once(DBAPI);

$cost = null;
$cash_flow = null;
$month_flow = null;


function index() {
    global $costs;
    //$costs = find_all('tbl_costs');
    $costs = find_cost_all();
}

function getAllFlows() {

   $all_cashflow = find_cash_flow_all();

   return $all_cashflow;
}

function getCashFlow() {
    global $cash_flow;
    global $month_flow;
    //$cash_flow = find_all('tbl_cash_flow');
    $cash_flow = find_cash_flow_all();

    $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

    foreach($cash_flow as $flow) {
       if($flow['month_int']==intval(date('m')) && $flow['year_int']==date('Y')) {
            $month_flow = $flow;
       }

    }

}

function calculate() {
    #$groupedCosts = getCosts();
    #$groupedIncomes = getIncomes();

    try {

         $groupedCosts = get_costs();
    $groupedIncomes = get_incomes();

    #deleteCashFlows();
    remove_cash_flow();

    foreach($groupedCosts as $cost) {
         $results = find_cashflow_by_month_year($cost['month'], $cost['year']);

         foreach ($results as $result) {
            $searchIncome = $result;
         }

         //Se ja existir um ganho com o mesmo mes e ano, precisa atualizar o registro
         if(!empty($searchIncome)) {

            $searchIncome['costs_dec'] += $cost['value'];
            $searchIncome['balance_dec'] -= $cost['value'];

            update_cash_flow_costs($searchIncome['id'], $searchIncome);

         } else {
              $insert = array(
                    'month_int' => $cost['month'],
                    'year_int' =>  $cost['year'],
                    'costs_dec' => $cost['value'],
                    'income_dec' => 0,
                    'balance_dec' => -(intval($cost['value'])),
                    );
              insert_cash_flow($insert);
         }
    }

    foreach($groupedIncomes as $income) {
         $results = find_cashflow_by_month_year($cost['month'], $cost['year']);

         foreach ($results as $result) {
            $searchCost = $result;
         }

         //Se ja existir um gasto com o mesmo mes e ano, precisa atualizar o registro
         if(!empty($searchCost)) {

            $searchCost['income_dec'] += $income['value'];
            $searchCost['balance_dec'] += $income['value'];

            update_cash_flow_incomes($searchCost['id'], $searchCost);

         } else {
              $insert = array(
                    'month_int' => $income['month'],
                    'year_int' =>  $income['year'],
                    'costs_dec' => 0,
                    'income_dec' => $income['value'],
                    'balance_dec' => (intval($income['value'])),
                    );
              insert_cash_flow($insert);
         }
    }

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível calcular o fluxo de caixa. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível adicionar o fluxo de caixa. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }


}

/**
 *  Cadastro de Despesa
 */
function add() {

  if (!empty($_POST['cost'])) {

    try {
         $today =
      date_create('now', new DateTimeZone('America/Sao_Paulo'));
    $cost = $_POST['cost'];
    $cost['modification_date_dt'] = $cost['creation_date_dt'] = $today->format("Y-m-d H:i:s");

     //Formatando a data para insercao no banco
      foreach ($cost as $key => $value) {
        if($key=="'deadline_dt'") {
           $valueReplace = str_replace('/', '-', $value);
           $date = strtotime($valueReplace);
           $cost["'deadline_dt'"] = date('Y-m-d',$date);
        }
      }
    //save('tbl_costs', $cost);
    insert_cost($cost);

      $_SESSION['message'] = "Despesa cadastrada com sucesso!";
      $_SESSION['type'] = 'success';
    header('location: add_cost.php');
    die();
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível inserir a despesa. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível inserir a despesa. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

  }
}

/*function addCashFlow($data = null) {

  if (!empty($data)) {
    save('tbl_cash_flow', $data);
    //header('location: add_cost.php');
    //die();
  }
}*/

/**
 *  Atualizacao/Edicao de Despesa
 */
function edit() {
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['cost'])) {
        try {
             $cost = $_POST['cost'];
              $cost['modification_date_dt'] = $now->format("Y-m-d H:i:s");
               //Formatando a data para insercao no banco
              foreach ($cost as $key => $value) {
                if($key=="'deadline_dt'") {
                   $valueReplace = str_replace('/', '-', $value);
                   $date = strtotime($valueReplace);
                   $cost["'deadline_dt'"] = date('Y-m-d',$date);
                }
              }
               //update('tbl_costs', $id, $cost);
              update_cost($id, $cost);
               $_SESSION['message'] = "Despesa atualizada com sucesso!";
               $_SESSION['type'] = 'success';
                  //header('location: edit_course.php?id=' + $id);
                  header('location: view_cost.php');
                  die();

        } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível editar a despesa. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível editar a despesa. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }



    } else {
        global $cost;
        $results = find_cost_by_id($id);

        foreach($results as $result) {
            $cost = $result;
        }

    }
  } else {

  }
}

/**
 *  Exclusão de uma Despesa
 */
function delete($id = null) {
    try {
          //$cost = remove('tbl_costs', $id);
         remove_cost($id);
            $_SESSION['message'] = "Despesa excluída com sucesso!";
            $_SESSION['type'] = 'success';
          header('location: view_cost.php');
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível excluir a despesa. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível excluir a despesa. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

}