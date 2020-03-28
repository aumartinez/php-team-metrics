<?php

# Implement sanitize methods first
class Controller extends Application {
  
  protected $controller;
  protected $method;
  protected $model;
  protected $view;
  
  public function __construct($controller, $method) {
    parent::__construct();
    
    $this->method = $method;
    $this->controller = $controller;    
    $this->view = new View();
  }
  
  # Load and instantiate model specific for this controller
  protected function load_model($model) {
    if (class_exists($model)) {
      $this->model[$model] = new $model();
    }
    else {
      return false;
    }
  }
  
  # Implement instantiated model methods
  protected function get_model($model) {
    if (isset($this->model[$model]) && is_object($this->model[$model])) {
      return $this->model[$model];
    }
    else {      
      return false;      
    }
  }
  
  # Return view instance
  protected function get_view() {
    return $this->view;
  }
  
}

?>