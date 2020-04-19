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

# Startup Locales
define ("LOCALES", 
        array(
          "SITE_ROOT" => SITE_ROOT,
          "MEDIA" => MEDIA
        ));

# User default
define ("DEFAULT_PIC", MEDIA . "/img/". "default-pic.png");

# Required values
define ("SYS_REQUIRED", 
        array(
        "email",
        "user",        
        "password"
        ));
 
define ("LOGIN_REQUIRED", 
        array(
        "user",
        "password"
        ));
        
define ("RESET_REQUIRED", 
        array(
        "email",
        "password",
        "verify"
        ));
        
define ("REGISTER_REQUIRED", 
        array(
        "first-name",
        "last-name",
        "email",
        "user",
        "employee-id",
        "password",
        "verify",
        "account",
        "position"
        ));

# Excluded pages
define ("EXCLUDED_PAGES",
        array(
          "not-found",
          "startup",
          "login",
          "register",
          "recover",
          "success",
          "success-recover",
          "success-password",
          "pending",
          "db-error",
          "reset"
        ));
?>
