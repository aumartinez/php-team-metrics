<?php

class Startupmodel extends Dbmodel {
    
  # First run setup
  public function first_run() {
    $dbname = DBNAME;    
    $this->create_db($dbname);    
  }
  
  public function setup_tables($sql) {
    $this->set_multyquery($sql);
  }
  
}

?>
