<?php

# Load config
require_once(ROOT . DS . PATH . DS . "config" . DS . "config.php");
require_once(ROOT . DS. PATH . DS . "core" . DS . "functions.php");

# Autoloader
spl_autoload_register(function ($class_name) {
  if (file_exists(ROOT . DS . PATH . DS . "core" . DS . strtolower($class_name) . ".php")) {
    require_once (ROOT . DS . PATH . DS . "core" . DS . strtolower($class_name) . ".php");
  }
  else if (file_exists(ROOT . DS . PATH . DS . "models" . DS . strtolower($class_name) . ".php")) {
    require_once (ROOT . DS . PATH . DS . "models" . DS . strtolower($class_name) . ".php");
  }
  else if (file_exists(ROOT . DS . PATH . DS . "views" . DS . strtolower($class_name) . ".php")) {
    require_once (ROOT . DS . PATH . DS . "views" . DS . strtolower($class_name) . ".php");
  }    
  else if (file_exists(ROOT . DS . PATH . DS . "controllers" . DS . strtolower($class_name) . ".php")) {
    require_once (ROOT . DS . PATH . DS . "controllers" . DS . strtolower($class_name) . ".php");
  }
});


# Route request
$router = new Router();
$router->route($url);

?>