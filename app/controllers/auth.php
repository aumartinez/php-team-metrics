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
    $this->load_model("AuthModel");  
  }
  
  public function index() {
    $this->get_model("AuthModel")->redirect(PATH . "/login");
  }
  
  public function login() {    
    # Check if referred URI is coming from login form
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;    
    $_SESSION["error"] = array();
    
    # Initialize methods
    $this->get_model("AuthModel")->login_required();
    $this->get_model("AuthModel")->sanitize_post();
    if ($this->get_model("AuthModel")->auth_user()) {
      $this->get_model("AuthModel")->redirect(PATH . "/cpanel");
    }
    else {
      $this->get_model("AuthModel")->redirect(PATH . "/login");
    }
  }
  
  public function startup() {
    
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;
    $_SESSION["error"] = array();
    
    # Initialize methods
    $this->get_model("AuthModel")->sysadmin_required();
    $this->get_model("AuthModel")->sanitize_post();
    $this->get_model("AuthModel")->sysadmin_validate();
    if ($this->get_model("AuthModel")->sysadmin_register()) {
      unset($_SESSION["submit-form"]);
      unset($_SESSION["error"]);
      $this->get_model("AuthModel")->redirect(PATH . "/success");
    }
    else {
      $this->get_model("AuthModel")->redirect(PATH . "/dberror");
    }
    
  } 
   
  public function not_found() {
    $this->get_model("AuthModel")->redirect(PATH . "/login");
  }
  
}

?>
