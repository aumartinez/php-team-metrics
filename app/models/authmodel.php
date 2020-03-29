<?php

class Authmodel extends Dbmodel {
  public $sanitized = array();  
  public $user;
  public $pass;
  public $is_logged = false;  
  
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
  
  # Auth user
  public function auth_user($email, $pass) {
    if ($email && pass) {
      $this->user = $user;
      $this->pass = $pass;
      
      if ($this->user == "admin" && $this->pass = "123") {
        $this->is_logged = true;
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