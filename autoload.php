<?php
// autoloader
define('BASE_PATH', realpath(dirname(__FILE__)));

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "core");

function my_autoloader($class)
{
    $filename = BASE_PATH . '/lib/' . str_replace('\\', '/', $class) . '.php';
    include($filename);
}
spl_autoload_register('my_autoloader');

// autoload files from folders or specific files

function listAllFrom($folder, $folders){
  foreach (glob($folder, GLOB_ONLYDIR) as $dir) {
    $folders[] = $dir;
    $folders = listAllFrom($dir."/*", $folders);
  }
  return $folders;
}


//Array of filenames
function getFilesOfTypeAll($folder, $type){

  $folder =  $folder."*";
  $files = array();
  $folders = array();

  $folders = listAllFrom($folder, $folders);
  foreach (glob($folder.".".$type) as $filename){
    $files[] = $filename;
  }
  foreach ($folders as $subfolder) {
    $path = $subfolder."/*.".$type;

    foreach (glob($path) as $filename){
      $files[] = $filename;
    }
  }
  return $files;
}

function getFilesOfTypeSingle($folder, $type){
  $folder =  $folder."*";
  $files = array();
  foreach (glob($folder.".".$type) as $filename){
    $files[] = $filename;
  }
  return $files;
}
