<?php

class Auth extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
        
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("Authmodel");    
  }
   
  public function not_found() {
    echo "loaded";
  }
  
}

?>
