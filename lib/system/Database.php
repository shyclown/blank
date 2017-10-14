<?php
namespace System;


mysqli_report(MYSQLI_REPORT_ALL);

class Database{

  private $db;
  public $error;

  public function __construct(){
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
      // from define.php file

      $this->db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $this->db->set_charset('utf8');
    }
    catch(Exception $e){
      echo "Service unavailable";
      echo "message: " . $e->message;
      $error = $e->message;
      exit;
    }
  }

  // Select does not need to bind any parameters
  // Safe internal queries

  public function select($sql_string){
    $result = $this->db->query($sql_string);
    if($result){
      $_array = array();
      while($row = $result->fetch_array(MYSQLI_ASSOC))
        { $_array[] = $row; }
      return $_array;
    }
  }

  public function query($sql_string = null, $values = null, $returning = 'array')
  {
    $return_value = false;
    if($stmt = $this->db->prepare($sql_string)){

      if($values){
        if(is_array($values)){
          if(call_user_func_array(array($stmt, 'bind_param'), $this->refValues($values))){
          };
        }
      }
      if($stmt->execute())
      {
        if($result = $stmt->get_result())
        {
          $_array = array();
          while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $_array[]= $row;
          }
          if($returning == 'array'){
            $return_value = $_array;
          }
        }
        else {
          if($returning == 'get_id'){
            $return_value = $stmt->insert_id;
          }else{
            $return_value = true;
          }
        }
      } else {
        var_dump($this->db->error);
      }
      $stmt->close();
    }
    else
    {
      var_dump($this->db->error);
    }
    return $return_value;
  }

  //Reference is required for PHP 5.3+
  private function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0){
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
  }

  // Close connection to DB
  public function destroy(){
    $thread_id = $this->db->thread_id;
    $this->db->kill($thread_id);
    $this->db->close();
  }
}
