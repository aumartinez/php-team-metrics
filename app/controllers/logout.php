<?php

class Logout extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
        
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("DbModel");
    $this->load_model("PageModel");
    $this->load_model("StartupModel");    
    
    # Instantiate custom view output
    $this->output = new PageView();    
  }
  
  # Each method will request the model to present the local resource
  public function index() {        
    # Clear session
    session_unset();
    session_destroy();
    session_write_close();    
    setcookie(session_name(), "", 0, "/");
    
    header("Location:/". PATH ."/login");
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->build_page("not-found");    
    
    # Clear session
    session_unset();
    session_destroy();
    session_write_close();    
    setcookie(session_name(), "", 0, "/");
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("PageModel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
  # Redirect
  protected function redirect($page) {
    header ("Location: /" . PATH . "/" . $page);
    exit();
  }
  
}

?>
