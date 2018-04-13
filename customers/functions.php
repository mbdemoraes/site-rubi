<?php
require_once('../config.php');
require_once(DBAPI);
$customers = null;
$customer = null;
$interests = null;
$customerInterests = null;
/**
 *  Listagem de Clientes
 */
function index() {
    global $customers;
    //$customers = find_all('tbl_customers');
    $customers = find_customer_all();
}

function search($id = null) {
    global $customers;
    $customers = find_customer_by_id($id);
}

function getInterests() {
   global $interests;
   //$interests = find('tbl_interests');
   $interests = find_interest_all();
}

/**
 *  Cadastro de Clientes
 */
function add() {
  if (!empty($_POST['customer']) && !empty($_POST['interest'])) {

      try {
        $today =
        date_create('now', new DateTimeZone('America/Sao_Paulo'));
      $customer = $_POST['customer'];
      $customer['modification_date_dt'] = $customer['creation_date_dt'] = $today->format("Y-m-d H:i:s");
      $interest = $_POST['interest'];
      //$interest['modification_date_dt'] = $interest['creation_date_dt'] = $today->format("Y-m-d H:i:s");

      //Formatando a data para insercao no banco
      foreach ($customer as $key => $value) {
        if($key=="'birthday_dt'") {
           $valueReplace = str_replace('/', '-', $value);
           $date = strtotime($valueReplace);
           $customer["'birthday_dt'"] = date('Y-m-d',$date);
        }
      }

      //save('tbl_customers', $customer);
      insert_customer($customer);
      //reset($customer) retorna o primeiro valor do array, no caso o nome do cliente
      //$savedCustomer = findByColumn('tbl_customers', 'name_var', reset($customer));
      $results = find_customer_by_name(reset($customer));

      foreach($results as $result) {
        $savedCustomer = $result;
      }


      foreach($interest as $key => $value)
      {
        $mykey = $key;
        $keyInt = str_replace("'", "", $mykey);
        $customerInterest = array(
        'tbl_customers_id' => $savedCustomer["id"],
        'tbl_interests_id' =>  intval($keyInt),
        'isinterest_tni' => intval($value),
        'creation_date_dt' => $today->format("Y-m-d H:i:s"),
        'modification_date_dt' => $today->format("Y-m-d H:i:s"),
        );
        //save('tbl_customer_interests', $customerInterest);
        insert_customer_interests($customerInterest);
      }

      $_SESSION['message'] = "Cliente cadastrado com sucesso!";
      $_SESSION['type'] = 'success';

      //save('tbl_customer_interests', $interest);
      header('location: add_customer.php');
      die();
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível adicionar o cliente. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível adicionar o cliente. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }
  }
}

/**
 *  Atualizacao/Edicao de Cliente
 */
function edit() {
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['customer']) && !empty($_POST['interest'])) {

      try {

         $customer = $_POST['customer'];
          $customer['modification_date_dt'] = $now->format("Y-m-d H:i:s");
          $interest = $_POST['interest'];

          //Formatando a data para insercao no banco
      foreach ($customer as $key => $value) {
        if($key=="'birthday_dt'") {
           $valueReplace = str_replace('/', '-', $value);
           $date = strtotime($valueReplace);
           $customer["'birthday_dt'"] = date('Y-m-d',$date);
        }
      }
          //update('tbl_customers', $id, $customer);
          update_customer($id, $customer);

          remove_interests($id);

          foreach($interest as $key => $value)
          {
            $mykey = $key;
            $keyInt = str_replace("'", "", $mykey);
            $customerInterest = array(
            'tbl_customers_id' => $id,
            'tbl_interests_id' =>  intval($keyInt),
            'isinterest_tni' => intval($value),
            'creation_date_dt' => $now->format("Y-m-d H:i:s"),
            'modification_date_dt' => $now->format("Y-m-d H:i:s"),
            );
            insert_customer_interests($customerInterest);
          }

          $_SESSION['message'] = "Cliente atualizado com sucesso!";
          $_SESSION['type'] = 'success';

          //header('location: add_customer.php');
          header('location: edit_customer.php?id=' . $id);
          die();

      } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível atualizar o cliente. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível atualizar o cliente. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

    } else {
      global $customer, $interests, $customerInterests;
      $results = find_customer_by_id($id);

      foreach ($results as $result) {
        $customer = $result;
      }

      $interests = find_interest_all('tbl_interests');
      $localInterests = find_customer_interests($id);

      $customerInterests = array();
      $foundInterest = false;

      foreach($interests as $globalInt) {
        $foundInterest = false;
        foreach($localInterests as $localInt) {

        //Caso o interesse ja esteja na tabela tbl_customer_interests, apenas copia todos os valores de
         if($globalInt['id']==$localInt['tbl_interests_id']) {
            $auxArray = array(
                'tbl_customers_id' => $localInt['tbl_customers_id'],
                'tbl_interests_id' =>  $localInt['tbl_interests_id'],
                'isinterest_tni' => $localInt['isinterest_tni'],
                'creation_date_dt' => $localInt['creation_date_dt'],
                'modification_date_dt' => $localInt['modification_date_dt'],
                'name_var' => $globalInt['name_var'],
              );
            $customerInterests[] = $auxArray;
            //Se encontrar o registro, ja sai do segundo foreach
            $foundInterest = true;
         }
      }

      //Caso nao tenha encontrado o interesse na tabela de interesses do cliente, indica que o interesse foi adicionado
      //posteriormente a adicao do cliente na base. Entao, basta adicionar o interesse com o valor zero no array
      if($foundInterest==false) {
          $auxArray = array(
                'tbl_customers_id' => $id,
                'tbl_interests_id' =>  $globalInt['id'],
                'isinterest_tni' => 0,
                'creation_date_dt' => $now->format("Y-m-d H:i:s"),
                'modification_date_dt' => $now->format("Y-m-d H:i:s"),
                'name_var' => $globalInt['name_var'],
              );
         $customerInterests[] = $auxArray;
      }
    }
  }
}

}

/**
 *  Exclusão de um Cliente
 */
function delete($id = null) {
  try {

     global $customer;
     $customer = remove_customer($id);
     $_SESSION['message'] = "Cliente excluído com sucesso!";
     $_SESSION['type'] = 'success';
     header('location: view_customer.php');
     //die();
  } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível excluir o cliente. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível excluir o cliente. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }
}