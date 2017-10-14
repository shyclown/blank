<?php
namespace System;

class Tables
{
// users
// users photos

function __construct( Database $db )
{
  $this->db = $db;
  $this->create_table_account();
  $this->create_token_table();

  $this->create_table_article();
  $this->create_table_file();

}

// photos
// phototag
// tags


// file
private function create_table_account(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_account` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `email` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `state` int(1) NOT NULL,
          `date_created` datetime NOT NULL,
          `date_edited` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB
        DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->query($sql);
}
private function create_token_table(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_tokens` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `user_id` int(8) NOT NULL,
          `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `date_created` datetime NOT NULL,
          `date_edited` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB
        DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->query($sql);
}

private function create_table_article(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_article` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `header` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `state` int(1) NOT NULL,
          `date_created` datetime NOT NULL,
          `date_edited` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB
        DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->query($sql);
}

private function create_table_file(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_file` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `file_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `file_type` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `file_size` int(64) NOT NULL,
          `file_src` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `date_created` datetime NOT NULL,
          `date_edited` datetime NOT NULL,
          PRIMARY KEY (`id`)
          ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->query($sql);
}

};
