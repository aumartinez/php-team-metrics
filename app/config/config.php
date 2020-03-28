<?php

# Database link credentials
define ("DBNAME", "webapp");
define ("DBUSER", "root");
define ("DBPASS", "");
define ("DBHOST", "localhost");

# App name
define ("WEB_TITLE", "Web app");

$global_folder = array();
$global_folder = explode(DS, trim(ROOT, DS));
$app_folder = array_pop($global_folder);

define ("APP_LOC", $app_folder);

# PATH to media files and site root constants
define ("SITE_ROOT", "/" . APP_LOC . "/" . PATH);
define ("MEDIA", "/" . SITE_ROOT . "/" . "common");
define ("HTML", "common" . DS . "html");

# Default states
define ("DEFAULT_CONTROLLER", "login");
define ("DEFAULT_METHOD", "index");
define ("NOT_FOUND", "not_found");

?>
