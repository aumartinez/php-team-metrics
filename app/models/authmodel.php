<?php

class Authmodel extends Dbmodel {
  public $sanitized = array();  
  
  # Required fields auth
  public function login_required() {
    $required = LOGIN_REQUIRED;
    
    # Check required fields
    foreach ($required as $value) {
      if (!isset($_POST[$value]) || $_POST[$value] == "") {
        $_SESSION["error"][] = $value . " is required";
      }
    }
    
    $this->error_check();
  }
  
  public function sysadmin_required() {
    $required = SYS_REQUIRED;
    
    # Check required fields
    foreach ($required as $value) {
      if (!isset($_POST[$value]) || $_POST[$value] == "") {
        $_SESSION["error"][] = $value . " is required";
      }
    }
    
    $this->error_check();
  }
  
  # Global sanitize method
  public function sanitize_post() {
    $this->sanitized = array();      
    
    foreach ($_POST as $key => $value) {
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
      
      $this->sanitized[$key] = $this->open_link()->real_escape_string($value);
    }
    
    return $this->sanitized;
  }  
  
  # Auth user
  public function auth_user() {
    $result = array();
    
    $user = $this->sanitized["user"];
    $password = $this->sanitized["password"];
    
    $sql = "SELECT * FROM users
            WHERE user_name = '{$user}' OR email = '{$user}'";
    
    $result = $this->get_query($sql);
    
    $salt = $result[0]["salt"];    
    $crypted = crypt($password, $salt);
    $crypted = substr($crypted, strlen($salt));    
            
    if ($user && $password) {      
      if ($crypted == $result[0]["password"]) {        
        $_SESSION["logged"] = true;
        
        return true;
      }
      else {
        $_SESSION["error"][] = "User/Password don't match";        
      }
    }
    else {
      $_SESSION["error"][] = "Couldn't authenticate user";
    }
    
    $this->error_check();
  }
  
  # Additional validations
  public function sysadmin_validate() {  
    if (isset($_POST["email"]) && $_POST["email"] != "") {
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"][] = "Email is invalid.";
      }
    }
    
    $test = $_POST["password"];
    $patt = "/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/";
    
    if (isset($_POST["password"]) && $_POST["password"] != "") {
      if (isset($_POST["verify"]) && $_POST["verify"] != ""){
        if ($_POST["password"] != $_POST["verify"]) {
          $_SESSION["error"][] = "Passwords don't match.";
        }
        else if (strlen($_POST["password"]) < 6 || strlen($_POST["verify"]) < 6) {
          $_SESSION["error"][] = "Passwords should be at least 6 characters.";
        }
        else if (!preg_match($patt, $test)) {
          $_SESSION["error"][] = "Password should contain 1 letter and 1 number.";
        }
      }
    }
    
    $this->error_check();
  }
  
  # Error check method
  protected function error_check() {
    if (count($_SESSION["error"]) > 0) {
      error_log("Error validating form", 0);
      $this->redirect(PATH . "/login");
    }
  }
  
  # Auth registration
  public function sysadmin_register() {
    
    $user_name = $this->sanitized["user"];
    $user_firstname = "System";
    $user_lastname = "Admin";
    $employee_id = "0000";
    $team_id = "team-000";
    $position_name = "System admin";
    
    $password = $this->sanitized["password"];
    $salt = "\$6\$rounds=5000\$".randomStr(8)."\$";
    
    $password = crypt($password, $salt);
    $password = substr($password, strlen($salt));
    
    $user_pic = DEFAULT_PIC;
    $email = $this->sanitized["email"];
    $account_name = "sysadmin";
    $user_access = 1;
  
    $sql = "INSERT INTO users (
            create_date,
            user_name,
            user_firstname,
            user_lastname,
            employee_id,
            team_id,
            position_name,
            password,
            salt,
            user_pic,
            email,
            account_name,
            user_access
            )
            VALUES(
            NOW(),
            '{$user_name}',
            '{$user_firstname}',
            '{$user_lastname}',
            '{$employee_id}',
            '{$team_id}',
            '{$position_name}',
            '{$password}',
            '{$salt}',
            '{$user_pic}',
            '{$email}',
            '{$account_name}',
            '{$user_access}'
            )";
            
    $this->set_query($sql);
    
    return true;
  }
  
  public function auth_register() {
  
  }
  
  # Redirect
  public function redirect($page) {
    header ("Location: /" . $page);
    exit();
  }
  
}

?>
