<?php

class Auth extends Controller {
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
    
    if (isset($_SESSION["error"])) {
      unset($_SESSION["error"]);
    }
    
    $_SESSION["error"] = array();
    
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("Authmodel");  
  }
  
  public function login() {    
    # Check if referred URI is coming from login form
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;    
    $_SESSION["error"] = array();
    
    # Initialize methods
    $this->get_model("Authmodel")->login_required();
    $this->get_model("Authmodel")->sanitize_post();
    if ($this->get_model("Authmodel")->auth_user()) {
      $this->get_model("Authmodel")->redirect(PATH . "/cpanel");
    }
    else {
      $this->get_model("Authmodel")->redirect(PATH . "/login");
    }
  }
  
  public function startup() {
    
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;
    $_SESSION["error"] = array();
    
    # Initialize methods
    $this->get_model("Authmodel")->sysadmin_required();
    $this->get_model("Authmodel")->sanitize_post();
    $this->get_model("Authmodel")->sysadmin_validate();
    if ($this->get_model("Authmodel")->sysadmin_register()) {
      unset($_SESSION["submit-form"]);
      unset($_SESSION["error"]);
      $this->get_model("Authmodel")->redirect(PATH . "/success");
    }
    else {
      $this->get_model("Authmodel")->redirect(PATH . "/dberror");
    }
    
  } 
   
  public function not_found() {
    $this->get_model("Authmodel")->redirect(PATH . "/login");
  }
  
}

?>
