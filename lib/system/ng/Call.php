<?php

// define globals for DB
require_once($_SERVER['DOCUMENT_ROOT'].'/define.php');
$db = new System\Database;


if(isset($_GET) && isset($_GET['class']))
{
  //Read Handle
  $handle = htmlspecialchars($_GET['class']);
  $class_name = ucfirst ( $handle ); // uppercase first letter
  $class = new $class_name($db);

  if(isset($_POST)
  && isset($_POST['action'])
  ){ $data = $_POST; }
  else{
    $data = file_get_contents("php://input");
    $data = json_decode($data, true); //array
  }

  if(isset($data['action'])){
    if ( method_exists($class, $data['action']) ){
       echo json_encode($class->{$data['action']}($data));
    }
  }
}
// close database
$db->destroy();
