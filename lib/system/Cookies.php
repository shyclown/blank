<?php
namespace System;
/**
 *
 */
class Cookies
{

  function __construct(Database $db)
  {
    $this->db = $db;
  }

  public function create(){
    if(setcookie('elephant-id',session_id(),strtotime( '+30 days' ), "/", NULL)){
      $_COOKIE['elephant-id'] = session_id();
    }
  }
  public function remove(){
    if(isset($_COOKIE['elephant-id'])){
            unset($_COOKIE['elephant-id']);
            setcookie('elephant-id', null, -3600, '/', NULL);
    }
  }
  public function is_valid()
  {
    $sql = "SELECT * FROM `ml_sessions` WHERE `id` = ? LIMIT 1";
    $params = array('s', $_COOKIE['elephant-id']);
    $result = $this->db->query($sql, $params);

    if($result){ $data = $result[0]['data']; }
    else{ $data = false; }

    if(session_decode ( $data )){ return true; }
    return false;
  }
}

 ?>
