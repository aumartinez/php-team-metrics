<?php

# Define current directory
define ("DS", DIRECTORY_SEPARATOR);
define ("ROOT", dirname(__FILE__));
define ("PATH", "app");

# Get URL from server and Sanitize URL
$url = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);

# Load core
require_once(ROOT . DS. PATH . DS . "core" . DS . "core.php");

?>