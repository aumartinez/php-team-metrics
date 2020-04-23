<?php

class CPanel extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
    session_regenerate_id();
    
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("DBModel");    
    $this->load_model("PageModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
  }
  
  # Each method will request the model to present the local resource
  public function index() {    
    if (!isset($_SESSION["logged"])) {      
      header("Location:/". PATH ."/login");
      exit();
    }
    else {
      if ($_SESSION["access"] == 1) {
        $this->build_page("admin");
      }
      if ($_SESSION["access"] == 2 || $_SESSION["access"] == 3) {
        $this->build_page("lead");
      }
      if ($_SESSION["access"] == 4) {
        $this->build_page("lead");
      }
      
    }    
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->build_page("not-found");    
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("PageModel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
}

?>
