<?php

class Register extends Controller {
  
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
    }
    else {
      # If referred from Login page, clear session variables
      if (isset($_SERVER["HTTP_REFERER"])) {
        $url = $_SERVER["HTTP_REFERER"];
        $url_array = explode("/", trim($url, "/"));
        
        $referrer = array_pop($url_array);
        
        if ($referrer == "login") {
          session_unset();
        }
      }
      else {
        header("Location:/". PATH ."/cpanel");
      }
    
      # Initial states
      $active_key = "ACTIVE";
      $active_class = "";
      
      $this->output->add_locale($active_key, $active_class);
      
      $err_key = "REGISTER_ERROR";
      $err_mess = "";
      
      # If errors are returned
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
      $this->build_page("register");
    }    
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->build_page("not-found");
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("Pagemodel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
}

?>
