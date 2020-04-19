<?php

class StartupModel extends DbModel {
  protected $dblink;
    
  # First run setup
  public function first_run() {
    $dbname = DBNAME;    
    $this->create_db($dbname);
  }
  
  public function test_tables() {        
    $dbname = DBNAME;
    $sql = "SHOW TABLES IN {$dbname}";
    
    $result = $this->get_query($sql);
    
    if ($result){
      return true;
    }
    else {
      return false;
    }
  }
  
  # Prepare DB tables
  public function setup_tables($sql) {
    $this->set_multyquery($sql);
  }
  
  public function test_users() {
    $sql = "SELECT *
            FROM users";
    
    $result = $this->get_rows($sql);
    
    if ($result > 0){
      return true;
    }
    else {
      return false;
    }
    
  }
  
  # Insert default data
  public function startup_data() {    
    # Create sysadmin account
    $sql = "INSERT INTO accounts (
            account_name
            ) 
            VALUES (
            'System admin'
            )";
    
    $this->set_query($sql);
    
    # Insert default position names
    $sql = "INSERT INTO positions (
            position_name, 
            user_access
            ) 
            VALUES (
            'System admin', 1
            ), (
            'Operations Manager', 2
            ), (
            'Team Leader', 3
            ), (
            'Agent', 4
            )";
            
   $this->set_query($sql);
   
    # Insert default position names
    $sql = "INSERT INTO teams (
            team_id,
            team_name,
            account_name
            ) 
            VALUES (
            'team-000',
            'System admins',
            'System admin'
            )";
    
    $this->set_query($sql);
  }
  
  # Create DB
  protected function create_db($dbname) {    
    $sql = "CREATE DATABASE {$dbname}
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci";
    
    $this->dblink = new mysqli(DBHOST, DBUSER, DBPASS);
    if (!$this->dblink->query($sql) == true) {
      $_SESSION["error"][] = $this->dblink->error;
    }
    
    $this->dblink->close();    
  }
  
}

?>
