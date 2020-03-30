<?php

class Cpanel extends Controller {
  
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
    if (!isset($_SESSION["logged"])) {      
      header("Location:/". PATH ."/login");
      exit();
    }
    else {
      $this->build_page("cpanel");
    }    
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->build_page("404");    
    
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
