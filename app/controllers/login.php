<?php

class Login extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();    
    
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("Dbmodel");
    $this->load_model("Pagemodel");
    
    # Instantiate custom view output
    $this->output = new Pageview();
  }
  
  # Each method will request the model to present the local resource
  public function index() {        
    if (isset($_SESSION["logged"])) {      
      header("Location:/". PATH ."/cpanel");
      exit("Logged");
    }
    else {                  
      # If errors are returned
      $err_key = "LOGIN_ERROR";
      $err_mess = "";
      
      if (isset($_SESSION["error"]) && isset($_SESSION["submit-form"])){
        unset($_SESSION["submit-form"]);
        
        $err_mess = "\n";
        $err_mess .= "Errors found!";
        $err_mess .= "<br />\n";
        
        foreach ($_SESSION["error"] as $error) {
          $err_mess .= $error . "<br />\n";
        }
      };
      
      $this->output->add_locale($err_key, $err_mess);
      $this->build_page("login");
    }    
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->build_page("not-found");    
    
    # Clear session
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');    
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("Pagemodel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
}

?>
