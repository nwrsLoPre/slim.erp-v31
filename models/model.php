<?php

namespace Models;

class Model
{
    private $model_table;
    private $mysqli;
    public $id;
    public $params;
    public $connection_status = false;

  public function __construct() {

    $model_name_arr = explode('\\', get_class($this));
    $model_name = $model_name_arr[count($model_name_arr) - 1];
    $this->model_table = strtolower($model_name);
   
  }

  public function connect() {

    if( $connection_status ) {

      return $this->mysqli;
    } else {

      require_once '/config/db.php';
      $this->mysqli = new \mysqli($host, $user, $pass, $db);

      if(mysqli_connect_errno())
      {
        return false;
      }

    }

    return $this->mysqli;
  }

  public function find_all() {

    $mysqli = $this->connect();

      $query = "select * from $this->model_table order by id";

      $result = $mysqli->query($query);

      while($row = $result->fetch_assoc()) {
          $data[] = $row;
      }

      $this->params = $data;

  }

  public function find_one($id) {
    
    $this->id = (int)$id;
    $mysqli = $this->connect();

    if($this->id > 0) {

      $query = "select * from $this->model_table where id = '{$this->id}'";
      $result = $mysqli->query($query);

      while($row = $result->fetch_assoc()) {
          $this->params = $row;
      }

    }

  }

  public function delete($id) {

      $this->id = (int)$id;
      $mysqli = $this->connect();

      $query = "DELETE from $this->model_table WHERE id = '{$id}'";

      if (!empty($id))
      {
          try {
              $result = $mysqli->query($query);
          } catch (Exception $e) {
              return $response->withJson([
                  'status'    =>  false,
                  'message'   =>  $e->getMessage()
              ]);
          }
      }
  }

}