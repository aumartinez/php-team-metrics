<?php

class Dbmodel {

  protected $rows = array();  
  protected $conx;  
  
  # Test if DBNAME exists
  public function test_db() {
    $this->conx = new mysqli(DBHOST, DBUSER, DBPASS);
    if ($this->conx->connect_errno) {
      echo "Failed to connect to MySQL: " . $this->conx->connect_error;      
      exit();
    }
    
    return $this->conx->select_db(DBNAME);
  }  
  
  # Open DB link
  protected function open_link() {  
    $this->conx = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    if ($this->conx->connect_errno) {
      $_SESSION["error"][] = "Failed to connect to MySQL: " . $this->conx->connect_error;      
      exit();
    }
    
    return $this->conx;
  }
    
  # Close DB link
  protected function close_link() {
    $this->conx->close();
  }
  
  # Submit SQL query for INSERT, UPDATE or DELETE
  protected function set_query($sql) {
    $this->open_link();
    if (!$this->conx->query($sql)) {
      $_SESSION["error"][] = "DB error: " . $this->conx->error;
    }
    $this->conx->query($sql);    
    $this->close_link();
  }
  
  protected function set_multyquery($sql) {
    $this->open_link();
    if (!$this->conx->multi_query($sql)) {
      $_SESSION["error"][] = "DB error: " . $this->conx->error;      
    }
    $this->conx->multi_query($sql);
    $this->close_link();
  }
  
  # Submit SELECT SQL query
  protected function get_query($sql) {
    $this->open_link();
    $result = $this->conx->query($sql);
    if (!$result) {
      $_SESSION["error"][] = "Query error: " . $this->conx->error;
    }
    while ($this->rows[] = $result->fetch_assoc());    
    $result->free();
    $this->close_link();
    array_pop($this->rows);
    
    return $this->rows[0];
  }
  
}

?>
