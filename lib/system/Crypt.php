<?php
namespace System;
/**
 *
 */
class Crypt
{

  function generate_hash($password, $cost = 11){
    $salt= substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
    $salt= str_replace("+",".",$salt);
    $param='$'.implode('$',array("2y", str_pad($cost,2,"0",STR_PAD_LEFT), $salt));
    return crypt($password,$param);
  }
  function generate_token($id){
    $token_salt = substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
    return $token_salt.'$'.crypt($id,$token_salt);
  }
  function get_id_from_token($token){

  }
  function compare_hash($password, $hashed){
    return crypt($password, $hashed) == $hashed;
  }

}
