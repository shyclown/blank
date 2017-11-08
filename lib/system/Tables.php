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

private function create_table_article_file(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_article_file` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `article_id`  int(8) NOT NULL,
          `file_id` int(8) NOT NULL ,
          `file_desc` varchar(64) NOT NULL ,
          PRIMARY KEY (`id`)
          ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->query($sql);
}

private function create_table_page(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_page` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `order` int(3),
          `parent` int(8),
          `state` int(1) NOT NULL,
          `date_created` DATETIME NOT NULL,
          `date_edited` DATETIME NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB
        DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->_mysqli->query($sql);
}

private function create_table_page_item(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_page_item` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `page_id`  int(8) NOT NULL,
          `item_id` int(8) NOT NULL ,
          `type` int(2) NOT NULL ,
          `order` int(2) NOT NULL ,
          PRIMARY KEY (`id`)
          ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->query($sql);
}

private function create_table_folder(){
  $sql = "CREATE TABLE IF NOT EXISTS `ml_folder` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
          `order` int(3),
          `parent` int(8),
          `state` int(1) NOT NULL,
          `date_created` DATETIME NOT NULL,
          `date_edited` DATETIME NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB
        DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->_mysqli->query($sql);
}


private function create_table_folder_item(){
    $sql = "CREATE TABLE IF NOT EXISTS `ml_folder_item` (
          `id` int(8) NOT NULL AUTO_INCREMENT,
          `folder_id`  int(8) NOT NULL,
          `item_id` int(8) NOT NULL ,
          `type` int(2) NOT NULL ,

          PRIMARY KEY (`id`)
          ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
  $this->db->query($sql);
}

};
