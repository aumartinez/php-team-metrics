<?php

class Ws extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    header("Content-Type: application/json");
            
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("Dbmodel");
    $this->load_model("Wsmodel");
    $this->load_model("Pagemodel");
    
    # Instantiate custom view output
    $this->output = new Pageview();
  }
  
  # Each method will request the model to present the local resource
  public function index() {
    $mess = array();
    $mess["Index"] = "Web services index";
    echo json_encode($mess, JSON_FORCE_OBJECT);
  }
  
  public function accounts() {
    $table = "accounts";
    $arr = array();
    $arr = $this->get_model("Wsmodel")->get_data($table);    
    echo json_encode($arr, JSON_FORCE_OBJECT);
  }
  
  public function positions() {
    $table = "positions";
    $arr = array();
    $arr = $this->get_model("Wsmodel")->get_data($table);    
    echo json_encode($arr, JSON_FORCE_OBJECT);
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    header("Content-Type: text/html; charset=UTF-8");
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
