<?php

class Authmodel extends Dbmodel {
  public $sanitized = array();  
  public $user_name;
  public $user_firstname;
  public $user_lastname;
  public $employee_id;
  public $team_id;
  public $position_name;
  public $password;
  public $salt;
  public $user_pic;
  public $email;
  public $account_name;
  public $user_access;
  
  public function login_required() {
    $required = LOGIN_REQUIRED;
    
    # Check required fields
    foreach ($required as $value) {
      if (!isset($_POST[$value]) || $_POST[$value] == "") {
        $_SESSION["error"][] = $value . " is required";
      }
    }
    
    $this->error_check();
  }
  
  # Global sanitize method
  public function sanitize_post() {
    $this->sanitized = array();
    
    foreach ($_POST as $key => $value) {
      $this->sanitized[$key] = $this->open_link()->real_escape_string($value);
    }
    
    return $this->sanitized;
  }
  
  # Auth system admin at startup
  public function auth_admin()
  
  # Auth user
  public function auth_user($user, $pass) {
    if ($user && $pass) {
      $this->user = $user;
      $this->pass = $pass;
      
      if ($this->user == "admin" && $this->pass == "123") {        
        $_SESSION["logged"] = true;
        
        $this->redirect(PATH . "/cpanel");
      }
      else {
        $_SESSION["error"][] = "User/Password don't match";
      }
    }
    else {
      $_SESSION["error"][] = "Couldn't authenticate user";
    }
    
    $this->error_check();
  }
  
  # Auth registration
  public function auth_register() {
  
  }
  
  # Error check method
  protected function error_check() {
    if (count($_SESSION["error"]) > 0) {
      error_log("Error validating form", 0);
      $this->redirect(PATH . "/login");
    }
  }
  
  public function redirect($page) {
    header ("Location: /" . $page);
    exit();
  }
  
}

?>
