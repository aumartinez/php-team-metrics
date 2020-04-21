<?php

class DbModel {

  protected $rows = array();  
  protected $conx;  
  
  # Test if DBNAME exists
  public function test_db() {
    $this->conx = new mysqli(DBHOST, DBUSER, DBPASS);
    if ($this->conx->connect_errno) {
      error_log("Database test failed");
      echo "Failed to connect to MySQL: " . $this->conx->connect_error;      
      exit();
    }
    
    return $this->conx->select_db(DBNAME);
  }  
  
  # Open DB link
  protected function open_link() {  
    $this->conx = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    if ($this->conx->connect_errno) {
      error_log("Connection failed");
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
    $result = $this->conx->query($sql);
    
    if (!$result) {
      error_log("Query failed " . $sql);
      $_SESSION["error"][] = "Query error: " . $this->conx->error;
    }
    
    $this->close_link();
  }
  
  protected function set_multyquery($sql) {
    $this->open_link();
    $result = $this->conx->multi_query($sql);
    
    if (!$result) {
      error_log("Query failed: " . $sql);
      $_SESSION["error"][] = "Query error: " . $this->conx->error;      
    }
    
    $this->close_link();
  }
  
  # Submit SELECT SQL query
  protected function get_query($sql) {
    $this->rows = array();
    $this->open_link();
    $result = $this->conx->query($sql);     
    
    if (!$result) {
      error_log("Query failed: " . $sql);
      $_SESSION["error"][] = "Query error: " . $this->conx->error;
      return false;
    }
    
    while ($this->rows[] = $result->fetch_assoc());    
    $result->free();
    $this->close_link();
    
    array_pop($this->rows);
    return $this->rows;
  }
  
  # Submit SELECT SQL query - get row count if matches found
  protected function get_rows($sql) {
    $this->open_link();
    $result = $this->conx->query($sql);
    
    if (!$result) {
      error_log("Query failed: " . $sql);
      $_SESSION["error"][] = "Query error: " . $this->conx->error;
      return false;
    }
    
    $rows = $result->num_rows;    
    return $rows;    
  }
  
}

?>
