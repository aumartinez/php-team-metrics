<?php

class Reset extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();    
    
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("DBModel");    
    $this->load_model("PageModel");
    $this->load_model("ResetModel");
    $this->load_model("EmailModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
  }
  
  # Each method will request the model to present the local resource
  public function index() {    
    # No index access
    $this->build_page("not-found");
  }
  
  public function user($hash = "") {    
    # No errors state      
    $active_key = "ACTIVE";
    $active_class = "";
    
    $this->output->add_locale($active_key, $active_class);
    
    $err_key = "RESET_ERROR";
    $err_mess = "";
  
    $hash = isset($_GET["h"])? $_GET["h"] : "";
    
    if ($hash == "") {
      $this->build_page("not-found");
    }
    
    if ($this->get_model("ResetModel")->validate_hash($hash)) {
      $hash_key = "HASH";
      $hash_mess = $hash;
      $this->output->add_locale($hash_key, $hash_mess);
      
      if (isset($_SESSION["error"]) && isset($_SESSION["submit-form"])){
        unset($_SESSION["submit-form"]);
        
        # If errors are returned        
        $active_key = "ACTIVE";
        $active_class = "active";
        
        $this->output->add_locale($active_key, $active_class);
        
        $err_mess = "\n";
        $err_mess .= "Errors found!";
        $err_mess .= "<br />\n";
        
        foreach ($_SESSION["error"] as $error) {
          $err_mess .= $error . "<br />\n";
        }
        
        unset($_SESSION["error"]);
      }
      
      $this->output->add_locale($err_key, $err_mess);      
      $this->build_page("reset");
    }
    else {
      $this->build_page("not-found");
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
