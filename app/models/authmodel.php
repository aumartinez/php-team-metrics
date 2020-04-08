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
  
  # Required fields auth
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
  
  public function sysadmin_required() {
    $required = SYS_REQUIRED;
    
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
      $clear = trim($value);
      $clear = stripslashes($clear);
      $clear = htmlspecialchars($clear);
      
      $this->sanitized[$key] = $this->open_link()->real_escape_string($clear);
    }
    
    return $this->sanitized;
  }
  
  # Auth system admin at startup
  public function auth_admin() {
  
  }
  
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
  
  # Additional validations
  public function sysadmin_validate() {    
    if (isset($_POST["email"]) && $_POST["email"] != "") {
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"][] = "Email is invalid.";
      }
    }
    
    $test = $_POST["password"];
    $patt = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;
    
    if (isset($_POST["password"]) && $_POST["password"] != "") {
      if (isset($_POST["verify"]) && $_POST["verify"] != ""){
        if ($_POST["password"] != $_POST["verify"]) {
          $_SESSION["error"][] = "Passwords don't match.";
        }
        else if (strlen($_POST["password"]) < 6 || strlen($_POST["verify"]) < 6) {
          $_SESSION["error"][] = "Passwords should be at least 6 characters."
        }
        else if (!preg_match($patt, $test) {
        
        }
      }
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
  
  # Auth registration
  public function sysadmin_register() {
    
  }
  
  public function auth_register() {
  
  }
  
}

?>
