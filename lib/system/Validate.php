<?php
namespace System;

/**
 *
 */
class Validate
{

  function __construct($db)
  {
    $this->db = $db;
  }


  function allowedEmail($email){ return filter_var(  $email, FILTER_VALIDATE_EMAIL); }
  function allowedUsername($username){ return preg_match('/^[A-Za-z][A-Za-z\d_.-]{5,31}$/i', $username); }

  function isFreeEmail($email){ return $this->isFree($email, 'SELECT id FROM `ml_account` WHERE `email` = ?'); }
  function isFreeUsername($username){ return $this->isFree($username, 'SELECT id FROM `ml_account` WHERE `username` = ?'); }

  private function isFree($value, $sql){
    if($this->db->query($sql, array('s', $value))){ return false; } return true;
  }


}
