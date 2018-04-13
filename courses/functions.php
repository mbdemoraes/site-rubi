<?php
require_once('../config.php');
require_once(DBAPI);
$courses = null;
$course = null;
$courseCustomers = null;
$courseCustomer = null;
$element = null;
$elements = null;
$customersWaiting = null;
/**
 *  Listagem de Clientes
 */
function index() {
    global $courses;
    $courses = find_course_all();
}

/*function indexCourseCustomers($column = null, $value = null) {
  global $courseCustomers;
  $courseCustomers = findByColumnNumber('tbl_course_customers', $column, $value);
}*/

function searchCustomersByCourseId($id = null) {
  global $courseCustomers;
  $results = find_course_customers_by_courseid($id);

  $courseCustomers = array();
  foreach($results as $result) {
    $courseCustomers[] = $result;
  }
}

function searchWaitingListByCourseId($id = null) {
  global $customersWaiting;
  $results = find_waitinglist_by_courseid($id);

  $customersWaiting = array();
  foreach($results as $result) {
    $customersWaiting[] = $result;
  }
}

function searchCustomersById($id = null) {
  global $courseCustomer;
  $results = find_course_customers_by_id($id);

  foreach($results as $result) {
    $courseCustomer = $result;
  }
}


function findCustomerByName($name = null) {
  global $element;
  $results = find_customer_by_name($name);

  foreach($results as $result) {
    $element = $result;
  }
}

/*function findElementByColumn($table = null , $column = null, $value = null) {
  global $element;
  $element  = findByColumn($table, $column, $value);
}

function findElementByColumnNumber($table = null , $column = null, $value = null) {
  global $elements;
  $elements  = findByColumnNumber($table, $column, $value);
}*/

function search($id = null) {
    global $courses;
    calculateNumSlotsTaken($id);
    $results = find_course_by_id($id);

    foreach($results as $result) {
        $courses = $result;
    }
}

function searchCourseCustomer($id) {
    global $element;
    $results = find_course_customers_by_id($id);

    foreach($results as $result) {
        $element = $result;
    }
}

function searchCustomerById($id) {
    global $element;
    $results = find_customer_by_id($id);

    foreach($results as $result) {
        $element = $result;
    }
}

/*function searchById($table = null, $id = null) {
   global $element;
   $element = find($table, $id);
}*/

/**
 *  Cadastro de Cursos
 */
function add() {
  if (!empty($_POST['course'])) {
    try {


    $today =
      date_create('now', new DateTimeZone('America/Sao_Paulo'));
    $course = $_POST['course'];
    $course['modification_date_dt'] = $course['creation_date_dt'] = $today->format("Y-m-d H:i:s");
    $course['numSlotsTaken_int'] = 0;
    $course['status_var'] = 'Aberto';

    //Formatando a data para insercao no banco
    foreach ($course as $key => $value) {
        if($key=="'event_date_dt'") {
           $valueReplace = str_replace('/', '-', $value);
           $date = strtotime($valueReplace);
           $course["'event_date_dt'"] = date('Y-m-d',$date);
        }
      }

    //save('tbl_courses', $course);
    insert_course($course);

      $_SESSION['message'] = "Curso cadastrado com sucesso!";
      $_SESSION['type'] = 'success';
    header('location: add_course.php');
    die();
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível adicionar curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível adicionar o curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

  }
}

/**
 *  Cadastro de Cliente em Curso
 */
function addCourseCustomer($customer = null) {
  if (!empty($customer)) {

    try {
         $today =
        date_create('now', new DateTimeZone('America/Sao_Paulo'));
        $customer['modification_date_dt'] = $customer['creation_date_dt'] = $today->format("Y-m-d H:i:s");

        //save('tbl_course_customers', $customer);
        insert_course_customer($customer);
        $_SESSION['message'] = "Cliente inserido com sucesso!";
        $_SESSION['type'] = 'success';
        header('location: view_course_customers.php?id=' . $customer['tbl_courses_id']);

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível adicionar o cliente no curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível adicionar o cliente no curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

  }
}

function addCustomerWaitingList($customer = null) {
  if (!empty($customer)) {


    try {
         $today =
        date_create('now', new DateTimeZone('America/Sao_Paulo'));
        $customer['creation_date_dt'] = $today->format("Y-m-d H:i:s");

        //save('tbl_course_customers', $customer);
        insert_customer_waitinglist($customer);
        $_SESSION['message'] = "Cliente inserido com sucesso!";
        $_SESSION['type'] = 'success';
        #header('location: view_course_customers.php?id=' . $customer['tbl_courses_id']);

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível adicionar o cliente no curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível adicionar o cliente no curso. Erro na aplicação. Exceção: " . $e->GetMessage();
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
    if (isset($_POST['course'])) {

     try {
        $course = $_POST['course'];
        $course['modification_date_dt'] = $now->format("Y-m-d H:i:s");


        if(intval($course["'numSlots_int'"]) < intval($course["'numSlotsTaken_int'"])) {
           $_SESSION['message'] = "Erro ao editar curso. Não é possível atualizar a quantidade de vagas de um curso para um número inferior ao número de vagas já preenchidas.";
           $_SESSION['type'] = 'danger';
           header('location:  edit_course.php?id=' . $id);
           die();
        }

        //Se o nome e o professor nao estiverem em branco, quer dizer que pode atualizar o registro todo
        //se nao precisa atualizar so a justificativa
        if(!empty($course["'name_var'"]) && !empty($course["'professor_var'"])) {
               //Formatando a data para insercao no banco
        foreach ($course as $key => $value) {
        if($key=="'event_date_dt'") {
           $valueReplace = str_replace('/', '-', $value);
           $date = strtotime($valueReplace);
           $course["'event_date_dt'"] = date('Y-m-d',$date);
            }
        }
        //update('tbl_courses', $id, $course);
        update_course($id, $course);
        } else {
          update_course_justification($id, $course);
        }


        $_SESSION['message'] = "Curso atualizado com sucesso!";
        $_SESSION['type'] = 'success';
        //header('location: edit_course.php?id=' + $id);
        header('location:  edit_course.php?id=' . $id);
        //header('location: edit_course.php?id=' + $id);
      die();
      } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível atualizar o curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível atualizar o curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

    } else {
      global $course;

      //$course = find('tbl_courses', $id);
      $results = find_course_by_id($id);

      foreach($results as $result) {
        $course = $result;
      }

    }
  } else {
  }
}

/**
 *  Atualizacao de Pagamento
 */
function editPayment()  {
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['courseCustomer'])) {

     try {
        $courseCustomer = $_POST['courseCustomer'];
        $courseCustomer['modification_date_dt'] = $now->format("Y-m-d H:i:s");


         //Formatando a data para insercao no banco
        foreach ($courseCustomer as $key => $value) {
        if($key=="'payment_date_dt'") {
           $valueReplace = str_replace('/', '-', $value);
           $date = strtotime($valueReplace);
           $courseCustomer["'payment_date_dt'"] = date('Y-m-d',$date);
            }
        }

        //update('tbl_courses', $id, $course);
        update_course_customers_payment($id, $courseCustomer);
        $_SESSION['message'] = "Informações de pagamento atualizadas com sucesso!";
        $_SESSION['type'] = 'success';
        //header('location: edit_course.php?id=' + $id);
        header('location: edit_payment.php?id=' . $id);
        //header('location: edit_course.php?id=' + $id);
      die();
      } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível atualizar as informações de pagamento. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível atualizar as informações de pagamento. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

    } else {
     global $courseCustomer;
      $results = find_course_customers_by_id($id);

      foreach($results as $result) {
        $courseCustomer = $result;
      }

    }
  } else {
  }
}

/**
 *  Atualizacao/Edicao de Cliente
 */
function editNumSlots($course = null) {
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
  if (isset($course)) {
    try {
         $course['modification_date_dt'] = $now->format("Y-m-d H:i:s");
         //update('tbl_courses', $course['id'], $course);
         update_course_slotstaken($course['id'], $course);
  } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível atualizar a quantidade de vagas preenchidas no curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível atualizar  a quantidade de vagas preenchidas no curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

  }
}

/**
 *  Atualizacao/Edicao de Cliente
 */
/*function editPayment($courseCustomer) {
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

  if (!empty($courseCustomer)) {
    try {
         $courseCustomer['modification_date_dt'] = $now->format("Y-m-d H:i:s");
         //update('tbl_course_customers', $courseCustomer['id'], $courseCustomer);
         update_course_customer_payment($courseCustomer['id'], $courseCustomer);
         $_SESSION['message'] = "Pagamento atualizado com sucesso!";
         $_SESSION['type'] = 'success';

         header('location: view_course_customers.php?id=' . $courseCustomer['tbl_courses_id']);
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível atualizar o pagamento do cliente. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível atualizar  o pagamento do cliente. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

    } else {

    }
}*/

/**
 *  Exclusão de um Curso
 */
function delete($id = null) {
    try {
      global $course;
      //$course = remove('tbl_courses', $id);
      remove_course($id);
      $_SESSION['message'] = "Curso excluído com sucesso!";
      $_SESSION['type'] = 'success';
      header('location: view_course.php');
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível excluir o cliente do curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível excluir o cliente do curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }
}

/**
 *  Fechamento de um Curso
 */
function open($id = null) {
  $results = find_course_by_id($id);

  foreach ($results as $result) {
    $course = $result;
  }
  $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
  if(isset($course)) {
    try {
            $course['status_var'] = 'Aberto';
            $course['justification_var'] = '';
            $course['modification_date_dt'] = $now->format("Y-m-d H:i:s");
            //update('tbl_courses', $course['id'], $course);
            update_course_status($course['id'], $course);
            $_SESSION['message'] = "Status do curso atualizado com sucesso!";
            $_SESSION['type'] = 'success';
             header('location:  edit_course.php?id=' . $course['id']);
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível atualizar o status do curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível excluir o status do curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

  }

}

/**
 *  Exclusão de um Cliente no Curso
 */
function deleteCustomer($id = null, $courseId = null) {
    try {
        global $customer;
        //$customer = remove('tbl_course_customers', $id);
        $customer = remove_course_customer($id);
        $_SESSION['message'] = "Cliente excluído com sucesso do curso!";
        $_SESSION['type'] = 'success';
        header('location: view_course_customers.php?id=' . $courseId);
    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível excluir o cliente do curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível excluir  o cliente do curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

}

/**
 *  Exclusão de um Cliente da Lista de Espera
 */
function deleteCustomerFromWaitingList($id = null, $courseId = null) {
    try {
        //$customer = remove('tbl_course_customers', $id);
      if(isset($courseId)) {
         remove_customer_from_waitinglist($id);
         $_SESSION['message'] = "Cliente excluído com sucesso da lista de espera!";
         $_SESSION['type'] = 'success';
         header('location: view_course_customers.php?id=' . $courseId);
       } else {
         remove_customer_from_waitinglist($id);
       }



    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível excluir o cliente da lista de espera. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível excluir  o cliente da lista de espera. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

}

function calculateNumSlotsTaken($idCourse = null) {

   try {
        //$results = find_course_by_id($idCourse);
        $results = count_course_slotstaken($idCourse);
        foreach ($results as $result => $value) {
          $count = intval($value['counter']);
        }


        $resultsCourse = find_course_by_id($idCourse);

        foreach ($resultsCourse as $key) {
          $course = $key;
        }

        $course['numSlotsTaken_int'] = $count;
        //$customer = remove('tbl_course_customers', $id);
        update_course_slotstaken($course['id'], $course);

    } catch (PDOException $e) {
       $_SESSION['message'] = "Não foi possível excluir o cliente do curso. Erro no banco de dados. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    } catch (Exception $e) {
       $_SESSION['message'] = "Não foi possível excluir  o cliente do curso. Erro na aplicação. Exceção: " . $e->GetMessage();
       $_SESSION['type'] = 'danger';
    }

}

function searchCustomersNameSearch($name = null) {
     try {
        $return_arr = find_customer_name_search($name);

        return $return_arr;
     } catch (PDOException $e) {
       $return_arr = "Erro ao pesquisar cliente. Exceção: " . $e->GetMessage();
       return $return_arr;
    }
}