<?php

class Auth extends Controller {
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
    
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("Authmodel");    
  }
  
  public function login() {
    
    # Check if referred URI is coming from login form
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;
    
    if (isset($_SESSION["error"])) {
      unset($_SESSION["error"]);
    }
    
    $_SESSION["error"] = array();
    
    # Initialize methods
    $this->get_model("Authmodel")->login_required();
    $this->get_model("Authmodel")->sanitize_post();
    $this->get_model("Authmodel")->auth_user($this->get_model("Authmodel")->sanitized["user"], $this->get_model("Authmodel")->sanitized["password"]);
  }
 
   
  public function not_found() {
    $this->get_model("Authmodel")->redirect(PATH . "/login");
  }
  
}

?>
