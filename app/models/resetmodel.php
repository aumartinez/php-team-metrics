<?php

class ResetModel extends DbModel {
  public $sanitized = array();

  public function validate_hash($hash) {      
    $hash = $this->sanitize_get($hash);
    $hash = $hash["h"];
    
    $sql = "SELECT pass_key
            FROM resetpassword
            WHERE pass_key = '{$hash}'";
            
    $found = $this->get_rows($sql);
    
    if ($found > 0) {
      return true;
    }
    else {
      return false;
    }
  }
    
  public function sanitize_get() {
    $this->sanitized = array();      
    
    foreach ($_GET as $key => $value) {
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
      
      $this->sanitized[$key] = $this->open_link()->real_escape_string($value);
    }
    $this->close_link();
    
    return $this->sanitized;
  }
      
  # Redirect
  public function redirect($page) {
    header ("Location: /" . $page);
    exit();
  }
}

?>
