<?php

class Application {
  
  public function __construct() {
    $this->sanitize_data();
    $this->unregister_globals();
  }  
  
  # Remove slashes from a given string array
  private function stripslashes_deep($value) {    
    $value = is_array($value) ? array_map(array($this, "stripslashes_deep"), $value) : stripslashes($value);
    
    return $value;
  }
  
  # Remove slashes from input data from GET, POST and COOKIE
  private function sanitize_data() {
    $_GET = $this->stripslashes_deep($_GET);
    $_POST = $this->stripslashes_deep($_POST);
    $_COOKIE = $this->stripslashes_deep($_COOKIE);
  }
  
  # If set, unregister any global constant
  private function unregister_globals() {
    if (ini_get("register_globals")) {
      $array = array("_SESSION", "_POST", "_GET", "_REQUEST", "_SERVER", "_ENV", "_FILES");
      
      foreach ($array as $value) {
        foreach ($GLOBALS[$value] as $key => $var) {
          if ($var === $GLOBALS[$key]) {
            unset($GLOBALS[$key]);
          }
        }
      }
    }
  }
  
}

?>
