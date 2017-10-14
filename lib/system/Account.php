<?php
namespace System;

class Account
{
  private $id;
  private $username;
  private $email;
  private $password;

  private $crypt;
  private $validate;
  protected $db;

  function __construct(Database $db){
    $this->db = $db;

    $this->crypt = new Crypt;
    $this->validate = new Validate($this->db);

    $this->errors = [];
    $this->debug = [];
  }

  // getVariable
  public function getUsername(){ return $this->username; }
  public function getEmail(){ return $this->email; }

  // public: SIGN IN, LOGIN, DELETE

  public function signin(){
    $this->username = $_POST['username'];
    $this->email = $_POST['email'];
    $this->password = $this->crypt->generate_hash($_POST['password']);

    $this->checkValues();
    if(empty($this->errors)){
      $user_id = $this->createAccount();
      $token = $this->activationToken($user_id);
      return $token;
    }
    else{ return $this->errors; }
  }

  public function resetPassword($logname){
    $sql_findUser = "SELECT * FROM ml_tokens WHERE `email` = ? OR 'username' = ? LIMIT 1";
    $par_findUser = array('ss', $logname, $logname);
    if($foundUser = $this->db->query($sql_findUser, $par_findUser)){
      $user = $foundUser[0];
      $token = $this->activationToken($user['id']);
      $email = $user['email'];
      // send email

      // debug
      return $token;
    }
    return false;
  }

  public function updatePassword($password){
    $password = $this->crypt->generate_hash($password);

  }

  private function findUserByToken($token){

  }

  public function activateAccount($token){
    // find token
    $sql = "SELECT * FROM ml_tokens WHERE `token` = ?";
    $params = array('s', $token);
    $result = $this->db->query($sql,$params);
    if($result){
      $sql_active = "UPDATE `ml_account` SET `state` = '1' WHERE `ml_account`.`id` = ?";
      $id = $result[0]['user_id'];
      $params_activate = array('i', $id);
      $result_activation = $this->db->query($sql_active,$params_activate);

      $sql_token = "DELETE FROM `ml_tokens` WHERE `ml_tokens`.`id` = ?";
      $params_token = array('s', $result[0]['id']);
      $result_token = $this->db->query($sql_token,$params_token);

      if($result_activation){ return true; }
    }
    return false;
  }

  private function activationToken($id){
    $token = $this->crypt->generate_token($id);
    $sql = "INSERT INTO `ml_tokens` (`id`, `user_id`, `token`, `date_created`,`date_edited`)
            VALUES (NULL, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    $params = array('is', $id, $token);
    $this->db->query($sql, $params);
    return $token;
  }

  public function login(){
    // logname can be email or username
  $this->logname = $_POST['logname'];
  $this->password = $_POST['password'];
    if($this->findAccount()){ $this->make_session();
     return true;
    }
    else{ return false; }
  }

  public function logout(){

  }

  public function deleteAccount(){
    $this->user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM `ml_account` WHERE id = ?";
    $params = array('i', $this->user_id);
    $result = $db->query($sql, $params);
  }

  public function loadSigned(){
    // check sessions if user is signed in
    if(isset($_SESSION['user_id'])){

      $id = $_SESSION['user_id'];
      $sql = "SELECT * FROM `ml_account` WHERE `id` = ? LIMIT 1";
      $params = array("i",$id);
      $result = $this->db->query($sql,$params);

      if(!empty($result)){
        $this->id = $result[0]['id'];
        $this->username = $result[0]['username'];
        $this->email = $result[0]['email'];
      }
    }
    else {
      // probably exploit
      array_push($this->errors, 'Account does not exists');
    }
  }

  private function err($msg){ array_push($this->errors, $msg);}


  private function checkValues()
  {
    if(!isset($this->email) || $this->email == ''){ $this->err('email not set'); }
    elseif(!$this->validate->allowedEmail($this->email)){ $this->err('email in wrong format'); }
    elseif(!$this->validate->isFreeEmail($this->email)){ $this->err('email already used'); }

    if(!isset($this->username) || $this->username == ''){  $this->err('username not set');}
    elseif(!$this->validate->allowedUsername($this->username)){ $this->err('username in wrong format');}
    elseif(!$this->validate->isFreeUsername($this->username)){  $this->err('username already used');}
  }

  private function createAccount()
  {
    $sql = "INSERT INTO `ml_account` (`id`, `username`, `password`, `email`, `state`,`date_created`,`date_edited`)
            VALUES (NULL, ?, ?, ?, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    $params = array('sss', $this->username , $this->password , $this->email);
    $result = $this->db->query($sql, $params, 'get_id');
    return $result;
  }


  // find acount in DB based on username or email
  private function findAccount()
  {
    $sql = "SELECT * FROM `ml_account` WHERE `username` = ? OR `email` = ?";
    $params = array("ss", $this->logname ,$this->logname);
    $result = $this->db->query($sql, $params);
    if(!empty($result))
    {
      if($this->crypt->compare_hash($this->password, $result[0]['password']))
      {
        $this->id = $result[0]['id'];
        $this->username = $result[0]['username'];
        $this->email = $result[0]['email'];
        return true;
      }
      else
      {
        return false;
      }
    }
  }



  private function make_session()
  {
    $_SESSION["user_id"] = $this->id;
    $_SESSION["loged_in"] = true;
  }





}
?>
