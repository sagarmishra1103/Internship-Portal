<?php
// extend so that it can can use con variable for connections
class dataOperaion extends Database {

  // create a function insert that takes two arguments as parameters
  public function insert($table, $fields){
    // INSERT INTO <table-name>(, ,) VALUES ('medicine', 'quantity')";
    $query = "";
    $query .= "INSERT INTO " .$table;
    //
    $query .= "(".implode(", ", array_keys($fields)).") VALUES ";
    // used to get an array of values from another array that may contain key-value pairs or just values
    $query .= "('".implode("', '", array_values($fields))."')";
    //echo $query;
    $result = mysqli_query($this -> con, $query);
    if($result){
      return true;
    }
  }

  // now function for fetching data from Database
  public function fetch($table){
    $query = "SELECT * FROM ".$table;
    $array = array();
    $result = mysqli_query($this->con, $query);
    while($row = mysqli_fetch_assoc($result)){
    $array[] = $row;
    }
    return $array;
  }

   // now function for fetching data from Database
   public function custom_query($query){
    $array = array();
    $result = mysqli_query($this->con, $query);
    while($row = mysqli_fetch_assoc($result)){
    $array[] = $row;
    }
    return $array;
  }

// code for selecting data using id
public function select($table, $where){
  $query = "";
  $candition = "";
  foreach ($where as $key => $value) {
    // id = '5' and medicine_name = "kuffdryl"
    $candition .= $key . "='" .$value ."' AND ";
  }
   $candition = substr($candition, 0 , -5);
   $query .= "SELECT * FROM ".$table. " WHERE " .$candition;
   $result = mysqli_query($this->con, $query);
   $row = mysqli_fetch_array($result);
   return $row;
}

// Function to grap values based on some condition
public function fetchConditionally($table, $where, $candition, $limit = 500)
{
  $query = "SELECT * FROM " . $table . " WHERE " . $where . " = '$candition' LIMIT $limit";
  $array = array();
  $result = mysqli_query($this->con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $array[] = $row;
    // echo $query;
  }
  return $array;
}

// Fetch data with some condition
public function fetchOneRowBy($fieldName, $table, $canditionColumn, $candition){
  $query = "SELECT " . $fieldName . " FROM " . $table . " WHERE " . $canditionColumn . " = '$candition'";
  $array = array();
  $result = mysqli_query($this->con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $array[] = $row;
    // echo $query;
  }
  return $array;
}

// code of update function goes here...
  public function update($table, $where, $fields){
    $query = "";
    $candition = "";
    foreach ($where as $key => $value) {
      // id = '5' and medicine_name = "kuffdryl"
      $candition .= $key . "='" .$value ."' AND ";
    }
    $candition = substr($candition, 0 , -5);
    foreach ($fields as $key => $value) {
      // update table set medicine_name = '', quantity = '' where id = '';
      $query .= $key . "='".$value."', ";
    }
    $query = substr($query, 0 , -2);
    $query ="UPDATE ".$table." SET ".$query." WHERE ".$candition;
    if(mysqli_query($this->con, $query)){
      return true;
    }
  }

  // code for deletion
  public function delete($table, $where){
    $query = "";
    $candition = "";
    foreach ($where as $key => $value) {
    $candition .= $key . "='" .$value ."' AND ";
    }
    $candition = substr($candition, 0 , -5);
    $query ="DELETE FROM ".$table." WHERE ".$candition;
    if (mysqli_query($this->con, $query)) {
      return true;
    }
  }
}
