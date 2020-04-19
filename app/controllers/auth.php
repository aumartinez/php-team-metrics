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
    $this->load_model("EmailModel");
    
  }
  
  public function index() {
    $this->get_model("AuthModel")->redirect(PATH . "/login");
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
  
  public function login() {    
    # Check if request is coming from form
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
  
  public function register() {
    # Check if request is coming from form
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;
    $_SESSION["error"] = array();
    
    $this->get_model("AuthModel")->register_required();
    $this->get_model("AuthModel")->sanitize_post();
    $this->get_model("AuthModel")->register_validate();
    if ($this->get_model("AuthModel")->register_data()) {
      $this->get_model("AuthModel")->redirect(PATH . "/success/pending");
    }
    else {
      $this->get_model("AuthModel")->redirect(PATH . "/register");
    }    
  }
  
  public function recover() {
    # Check if request is coming from form
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;
    $_SESSION["error"] = array();
    
    $this->get_model("AuthModel")->recovery_required();
    $this->get_model("AuthModel")->sanitize_post();
    $this->get_model("AuthModel")->recovery_validate();
    $hash = $this->get_model("AuthModel")->recovery_data();    
    $email = $this->get_model("AuthModel")->sanitized["email"];    
    
    if ($this->get_model("EmailModel")->submit_recover($email, $hash)) {
      $this->get_model("AuthModel")->redirect(PATH . "/success/recover");
    }
    else {
      $this->get_model("AuthModel")->redirect(PATH . "/recover");
    }
    
  }
  
  public function reset() {
    # Check if request is coming from form
    if (!isset($_POST["submit-form"])) {
      $this->not_found();
    }
    
    $_SESSION["submit-form"] = true;
    $_SESSION["error"] = array();    
    
    $this->get_model("AuthModel")->reset_required();
    $this->get_model("AuthModel")->sanitize_post();
    $this->get_model("AuthModel")->reset_validate();
    
    $hash = $this->get_model("AuthModel")->sanitized["hash"];
    
    if ($this->get_model("AuthModel")->reset_data()) {
      $this->get_model("EmailModel")->submit_reset($hash);
      $this->get_model("AuthModel")->redirect(PATH . "/success/password");
    }
    else {
      $this->get_model("AuthModel")->redirect(PATH . "/reset");
    }
    
  }
     
  public function not_found() {
    $this->get_model("AuthModel")->redirect(PATH . "/login");
  }
  
}

?>
