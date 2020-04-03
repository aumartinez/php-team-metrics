<?php

class Dbmodel {
    
  protected $sql;
  protected $rows = array();  
  protected $conx;
  
  # Open DB link
  protected function open_link() {
    $this->conx = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    if ($this->conx->connect_errno) {
      echo "Failed to connect to MySQL: " . $this->conx->connect_error;
      exit();
    }
    
    return $this->conx;
  }
  
  # Close DB link
  protected function close_link() {
    $this->conx->close();
  }
  
  # Create DB
  protected function create_db($dbname) {    
    $sql = "CREATE DATABASE '{$dbname}'
            CHARACTER SET utf8 
            COLLATE utf8_unicode_ci";
    $this->set_query($sql);    
  }
  
  # Submit SQL query for INSERT, UPDATE or DELETE
  protected function set_query($sql) {
    $this->open_link();
    $this->conx->query($sql);
    $this->close_link();
  }
  
  protected function set_multyquery($sql) {
    $this->open_link();
    $this->conx->multi_query($sql);
    $this->close_link();
  }
  
  # Submit SELECT SQL query
  protected function get_query() {
    $this->open_link();
    $result = $this->conx->query($this->sql);
    while ($this->rows[] = $result->fetch_assoc());    
    $result->free();
    $this->close_link();
    array_pop($this->rows);
    
    return $this->rows[0];
  }
  
}

?>
