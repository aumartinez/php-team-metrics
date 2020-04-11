<?php

class Login extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
        
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("Dbmodel");
    $this->load_model("Pagemodel");
    $this->load_model("Startupmodel");
    
    # Instantiate custom view output
    $this->output = new Pageview();
    
    # Start methods
    $this->startup(); 
  }
  
  # Each method will request the model to present the local resource
  public function index() {        
    if (isset($_SESSION["logged"])) {      
      header("Location:/". PATH ."/cpanel");
      exit();
    }
    else {
      # No errors state
      $active_body = "STYLE";
      $active_class = "";
      
      $this->output->add_locale($active_body, $active_class);
      
      $active_key = "ACTIVE";
      $active_class = "";
      
      $this->output->add_locale($active_key, $active_class);
      
      # If errors are returned
      $err_key = "LOGIN_ERROR";
      $err_mess = "";
      
      if (isset($_SESSION["error"]) && isset($_SESSION["submit-form"])){
        unset($_SESSION["submit-form"]);
        
        $active_key = "ACTIVE";
        $active_class = "active";
        
        $this->output->add_locale($active_key, $active_class);
        
        $err_mess = "\n";
        $err_mess .= "Errors found!";
        $err_mess .= "<br />\n";
        
        foreach ($_SESSION["error"] as $error) {
          $err_mess .= $error . "<br />\n";
        }
      };
      
      $this->output->add_locale($err_key, $err_mess);
      
      if ($this->get_model("Startupmodel")->test_users()) {
        $this->build_page("login");
      }      
    }    
  }
  
  # Start setup on application launch
  private function startup() {  
    # If DB doesn't exist create it
    if(!$this->get_model("Dbmodel")->test_db()) {
      $this->get_model("Startupmodel")->first_run();
      
      if (file_exists(ROOT . DS . "config" . DS . "createtables.sql")) {        
        $sql = file_get_contents(ROOT . DS . "config" . DS . "createtables.sql");
        $this->get_model("Startupmodel")->setup_tables($sql);
        $this->get_model("Startupmodel")->startup_data();
      }
      else {
        $this->build_page("db-error");
      }
    }
    
    # If system admin is not setup, ask to create it
    if(!$this->get_model("Startupmodel")->test_users()){
            
      # No errors state
      $active_body = "STYLE";
      $active_class = "";
      
      $this->output->add_locale($active_body, $active_class);
      
      $active_key = "ACTIVE";
      $active_class = "";
      
      $this->output->add_locale($active_key, $active_class);
      
      $err_key = "STARTUP_ERROR";
      $err_mess = "";
      
      $this->output->add_locale($err_key, $err_mess);
      
      # If errors are returned
      if (isset($_SESSION["error"]) && count($_SESSION["error"]) > 0){
        $active_body = "STYLE";
        $active_class = "style=\"height: auto;\"";
        
        $this->output->add_locale($active_body, $active_class);
        
        $active_key = "ACTIVE";
        $active_class = "active";
        
        $this->output->add_locale($active_key, $active_class);
              
        $err_mess .= "Errors found!";
        $err_mess .= "<br />\n";
        
        foreach ($_SESSION["error"] as $error) {
          $err_mess .= $error . "<br />\n";          
        }
        
        unset($_SESSION["error"]);
        $this->output->add_locale($err_key, $err_mess);
      }
      
      $this->build_page("startup");
    }
  }
  
  # DB error page
  public function dberror () {
    $this->build_page("db-error");
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->build_page("not-found");    
    
    # Clear session
    session_unset();
    session_destroy();
    session_write_close();
    session_regenerate_id();
    setcookie(session_name(), "", 0, "/");    
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("Pagemodel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
}

?>
