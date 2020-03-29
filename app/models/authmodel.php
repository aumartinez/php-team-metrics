<?php

class Authmodel extends Dbmodel {
  protected $sanitized = array();  
  
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