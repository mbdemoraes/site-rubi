<?php
/**
 *  Pesquisa Todos os Registros de uma Tabela
 */
function find_all( $table ) {
  return find($table);
}

function save($table = null, $data = null) {
  $database = open_database();
  $columns = null;
  $values = null;
  //print_r($data);
  foreach ($data as $key => $value) {
    $columns .= trim($key, "'") . ",";
    $values .= "'$value',";
  }
  // remove a ultima virgula
  $columns = rtrim($columns, ',');
  $values = rtrim($values, ',');

  $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
  $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->prepare($sql);
  $stmt->execute();

}

/**
 *  Atualiza um registro em uma tabela, por ID
 */
function update($table = null, $id = 0, $data = null) {
  $database = open_database();
  $items = null;

  foreach ($data as $key => $value) {
    $items .= trim($key, "'") . "='$value',";
  }
  // remove a ultima virgula
  $items = rtrim($items, ',');
  $sql  = "UPDATE " . $table;
  $sql .= " SET $items";
  $sql .= " WHERE id=" . $id . ";";

  try {
    $database->query($sql);
    $_SESSION['message'] = 'Registro atualizado com sucesso.';
    $_SESSION['type'] = 'success';
  } catch (Exception $e) {
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
    $_SESSION['type'] = 'danger';
  }
  close_database($database);
}


function remove( $table = null, $id = null ) {

    $sql = "DELETE FROM " . $table . " WHERE id = " . $id;


    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare($sql);
    $stmt->execute();

}


mysqli_report(MYSQLI_REPORT_STRICT);
function open_database() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        return $conn;
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
}
function close_database($conn) {
    try {
        mysqli_close($conn);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function findByColumn ($table = null, $column = null, $value = null) {
    $database = open_database();
    $found = null;

    try {
      if ($value) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $column . " LIKE '%" . $value . "%' ORDER BY " . $column . " ASC LIMIT 1";
        $result = $database->query($sql);

        if ($result->num_rows > 0) {
          $found = $result->fetch_assoc();
        }

      } else {

        $sql = "SELECT * FROM " . $table;
        $result = $database->query($sql);

        /* Metodo alternativo*/
        $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }

      }
    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';
  }

    close_database($database);
    return $found;
}


function findCoursesFill() {

    $database = open_database();
    $found = null;

    try {

        $sql = "SELECT * FROM tbl_courses WHERE status_var='Aberto' ORDER BY event_date_dt ASC LIMIT 10;";
        $result = $database->query($sql);

         $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }


    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';
  }

    close_database($database);
    return $found;

}

function findByString ($table = null, $column = null, $value = null) {

   $database = open_database();
    $found = null;

    try {
      if ($value) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $column . " LIKE '%" . $value . "%' ORDER BY " . $column;
        $result = $database->query($sql);

         $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }

      }
    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';

  }

    close_database($database);
    return $found;

}

function findByColumnNumber ($table = null, $column = null, $value = null) {
    $database = open_database();
    $found = null;

    try {
      if ($value) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $column . " = " . $value;
        $result = $database->query($sql);

        /* Metodo alternativo*/
        $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }

        // if ($result->num_rows > 0) {
        //   $found = $result->fetch_assoc();
        // }

      } else {

        $sql = "SELECT * FROM " . $table;
        $result = $database->query($sql);

        /* Metodo alternativo*/
        $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }

      }
    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';
  }

    close_database($database);
    return $found;
}
/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find( $table = null, $id = null ) {

    $database = open_database();
    $found = null;

    try {
      if ($id) {
        $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
        $result = $database->query($sql);

        if ($result->num_rows > 0) {
          $found = $result->fetch_assoc();
        }

      } else {

        $sql = "SELECT * FROM " . $table;
        $result = $database->query($sql);

        /* Metodo alternativo*/
        $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }

      }
    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';
  }

    close_database($database);
    return $found;
}

function deleteCashFlows() {

  $database = open_database();

    try {

        $sql = "DELETE FROM tbl_cash_flow";
        $result = $database->query($sql);

        // if ($result->num_rows > 0) {
        //   $found = $result->fetch_assoc();
        //

    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';
  }

    close_database($database);

}

function getCosts() {
    $database = open_database();
    $found = null;

    try {

        $sql = "SELECT SUM(value_int) as 'value', MONTH(deadline_dt) as 'month', YEAR(deadline_dt) as 'year' FROM tbl_costs GROUP BY MONTH(deadline_dt)";
        $result = $database->query($sql);

        /* Metodo alternativo*/
        $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }

        // if ($result->num_rows > 0) {
        //   $found = $result->fetch_assoc();
        //

    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';
  }

    close_database($database);
    return $found;

}


function getIncomes() {
    $database = open_database();
    $found = null;

    try {

        $sql = "SELECT SUM(price_int) as 'value', MONTH(payment_date_dt) as 'month', YEAR(payment_date_dt) as 'year' FROM tbl_courses
          INNER JOIN tbl_course_customers on tbl_courses.id = tbl_course_customers.tbl_courses_id
          WHERE tbl_course_customers.payment_date_dt is not null and tbl_course_customers.payment_date_dt!='0000-00-00'
          GROUP BY MONTH(tbl_course_customers.payment_date_dt)";
        $result = $database->query($sql);

        /* Metodo alternativo*/
        $found = array();
        while ($row = $result->fetch_assoc()) {
          array_push($found, $row);
          }

        // if ($result->num_rows > 0) {
        //   $found = $result->fetch_assoc();
        //

    } catch (Exception $e) {
      $_SESSION['message'] = $e->GetMessage();
      $_SESSION['type'] = 'danger';
  }

    close_database($database);
    return $found;

}


  // GRAVAR SAIDA EM ARQUIVO
/*  ob_start();
  echo $sql;

  $content = ob_get_contents();

  $f = fopen("file.txt", "w");
  fwrite($f, $content);
  fclose($f);*/


/**
 *  Remove uma linha de uma tabela pelo ID do registro
 */
/*function remove( $table = null, $id = null ) {
  $database = open_database();

  try {
    if ($id) {
      $sql = "DELETE FROM " . $table . " WHERE id = " . $id;
      $result = $database->query($sql);
      if ($result = $database->query($sql)) {

        $_SESSION['message'] = "Registro Removido com Sucesso.";
        $_SESSION['type'] = 'success';
      }
    }
  } catch (Exception $e) {
    $_SESSION['message'] = $e->GetMessage();
    $_SESSION['type'] = 'danger';
  }
  close_database($database);
}*/

?>