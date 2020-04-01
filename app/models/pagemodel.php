<?php

class Pagemodel extends Dbmodel {
  
  private $html_str;
  
  public $site_title = WEB_TITLE;
  public $page_title = "";
  
  # First run setup
  public function first_run() {
    $dbname = DBNAME;    
    $this->create_db($dbname);
    
    
    $this->set_query($sql);
  }
  
  # With page name locate resources, put them together and return it 
  # to the controller
  public function get_page($page_name) {        
    $this->html_str = "";
    $this->html_str .= $this->get_htmlhead();
    $this->html_str .= $this->get_htmlbody($page_name);
    $this->html_str .= $this->get_htmlclose();
    
    return $this->html_str;
  }
  
  # Build head template
  protected function get_htmlhead() {
    $html = "";
    $html .= $this->get_doctype();
    $html .= $this->get_openhtml();
    $html .= $this->get_head();
    
    return $html;
  }
  
  # Build body content and bottom scripts
  protected function get_htmlbody($page_name) {
    $html = "";
    $html .= $this->get_openbody($page_name);
    $html .= $this->get_header($page_name);
    $html .= $this->get_bodycont($page_name);
    $html .= $this->get_footer($page_name);
    $html .= $this->get_scripts($page_name);
    
    return $html;
  }
  
  # Close HTML document
  protected function get_htmlclose() {
    $html = "";
    $html .= $this->get_closebody();
    
    return $html;
  }
  
  # Define doctype, defaults to html5
  protected function get_doctype($doctype = "html5") {
    $dtd = "";
    
    if ($doctype == "html5") {
      $dtd .= "<!doctype html>";
      $dtd .= "\n";
    }
    
    return $dtd;
  }
  
  # Define language, defaults to english
  protected function get_openhtml($lang = "en-us") {
    $html = "";
    
    if ($lang = "en-us") {
      $html .= "<html lang=\"en\">";
      $html .= "\n";
    }
    
    return $html;
  }
  
  # Build head section
  protected function get_head() {
    $html = "";
    $html .= " <head>\n";
        
    if (file_exists(HTML . DS . "temp" . DS . "meta.html")) {
      $html .= file_get_contents(HTML . DS . "temp" . DS . "meta.html");
      $html .= "\n";
    }
    
    if ($this->page_title != "") {
      $title = $this->page_title . " | " . $this->site_title;
    }
    else{
      $title = $this->site_title;
    }
    
    $html .= "  <title>" . $title . "</title>";
    $html .= "\n";
    
    if (file_exists(HTML . DS . "temp" . DS . "resources.html")) {
      $html .= file_get_contents(HTML . DS . "temp" . DS . "resources.html");
      $html .= "\n";
    }
    
    $html .= " </head>";
    $html .= "\n";
    
    return $html;
  }
  
  # Open body section, define body id with page name
  protected function get_openbody($page_name) {
    $html = "";
    $html .= " <body id=\"" . $page_name . "\">";
    $html .= "\n";
    
    return $html;
  }
  
  # Build templated header (navigation, branding)
  protected function get_header($page_name) {
    $excluded_pages = EXCLUDED_PAGES;
  
    $html = "";
    
    if (file_exists(HTML . DS . "temp" . DS . "header.html") && !in_array($page_name, $excluded_pages)) {
      $html .= file_get_contents(HTML . DS . "temp" . DS . "header.html");
      $html .= "\n";
    }
    
    return $html;
  }
  
  # Build specific content for the page
  protected function get_bodycont($page_name) {
    $html = "";
    
    if (file_exists(HTML . DS . "page" . DS . $page_name . ".html")) {
      $html .= file_get_contents(HTML . DS . "page" . DS . $page_name . ".html");
      $html .= "\n";
    }
    
    return $html;
  }
  
  # Build footer
  protected function get_footer($page_name) {
    $excluded_pages = EXCLUDED_PAGES;
    $html = "";
    
    if (file_exists(HTML . DS . "temp" . DS . "footer.html") && !in_array($page_name, $excluded_pages)) {
      $html .= file_get_contents(HTML . DS . "temp" . DS . "footer.html");
      $html .= "\n";
    }
    
    return $html;
  }
  
  # Add bottom JS scripts
  protected function get_scripts($page_name) {    
    $html = "";
    
    if (file_exists(HTML . DS . "temp" . DS . $page_name . "-scripts.html")) {
      $html .= file_get_contents(HTML . DS . "temp" . DS . $page_name ."-scripts.html");
      $html .= "\n";
    }
    else if (file_exists(HTML . DS . "temp" . DS . "scripts.html")) {
      $html .= file_get_contents(HTML . DS . "temp" . DS ."scripts.html");
      $html .= "\n";
    }
    
    return $html;
  }
  
  # Close body and html
  protected function get_closebody() {
    $html = "";
    $html .= " </body>\n";
    $html .= "</html>";
    $html .= "\n";
    
    return $html;
  }
  
}

?>
