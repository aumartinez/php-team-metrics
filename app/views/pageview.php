<?php

class Pageview extends View {
  private $locales = array();
  
  # Initialize keywords dictionary
  public function __construct(){
    $this->build_locales();    
  }
  
  # Replace keywords
  public function replace_localizations($html) {
    
    foreach ($this->locales as $key => $value) {
      $html = str_replace("{\$" . $key . "\$}", $value, $html);
    }
    
    return $html;
  }
  
  # Add locales
  public function add_locale($key, $value) {
    $this->locales[$key] = $value;
    
    return $this->locales;
  }
  
  # Keyword list
  protected function build_locales() {
    $this->locales = LOCALES;    
    
    return $this->locales;
  }
  
}

?>