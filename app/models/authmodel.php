<?php

class Authmodel extends Dbmodel {
  protected $validate;
  
  public function validate() {
    
  }
  
  private function redirect($page) {
    header ("Location: /" . $page);
    exit();
  }
  
}

?>