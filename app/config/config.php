<?php

# Database link credentials
define ("DBNAME", "webapp");
define ("DBUSER", "root");
define ("DBPASS", "");
define ("DBHOST", "localhost");

# App name
define ("WEB_TITLE", "Web app");

# App main folder name
define ("PATH", "php-team-metrics");

# PATH to media files and site root constants
define ("SITE_ROOT", "/" . PATH);
define ("MEDIA", SITE_ROOT . "/" . "common");
define ("HTML", "common" . DS . "html");

# Default states
define ("DEFAULT_CONTROLLER", "login");
define ("DEFAULT_METHOD", "index");
define ("NOT_FOUND", "not_found");

?>