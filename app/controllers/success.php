<?php

class Success extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
    
    # Clear session
    session_unset();
    session_destroy();
    session_write_close();    
    setcookie(session_name(), "", 0, "/");
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("DbModel");
    $this->load_model("PageModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
  }
  
  # Each method will request the model to present the local resource
  public function index() {
    $this->get_model("PageModel")->page_title = "Success";
    $this->build_page("success");
  }
  
  public function pending() {
    $this->get_model("PageModel")->page_title = "Pending";
    $this->build_page("pending");
  }
  
  public function recover() {
    $this->get_model("PageModel")->page_title = "Password recovery";
    $this->build_page("emailrecover");
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
