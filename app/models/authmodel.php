<?php

class AuthModel extends DbModel {
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
    
    $this->error_check("login");
  }
  
  public function sysadmin_required() {
    $required = SYS_REQUIRED;
    
    # Check required fields
    foreach ($required as $value) {
      if (!isset($_POST[$value]) || $_POST[$value] == "") {
        $_SESSION["error"][] = $value . " is required";
      }
    }
    
    $this->error_check("login");
  }
  
  public function register_required() {
    $required = REGISTER_REQUIRED;
    
    # Check required fields
    foreach ($required as $value) {
      if (!isset($_POST[$value]) || $_POST[$value] == "") {
        $_SESSION["error"][] = $value . " is required";
      }
    }
    
    $this->error_check("register");
  }
  
  public function recovery_required() {
    $required = "email";
    
    # Check required fields
    if (!isset($_POST["email"]) || $_POST["email"] == "") {
        $_SESSION["error"][] = $value . " is required";
    }
    
    $this->error_check("recover");
  }
  
  # Global sanitize methods
  public function sanitize_post() {
    $this->sanitized = array();      
    
    foreach ($_POST as $key => $value) {
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
      
      $this->sanitized[$key] = $this->open_link()->real_escape_string($value);      
    }
    $this->close_link();
    
    return $this->sanitized;
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
  
  # Auth user
  public function auth_user() {
    $result = array();
    
    $user = $this->sanitized["user"];
    $password = $this->sanitized["password"];
    
    $sql = "SELECT *
            FROM users
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
    
    $this->error_check("login");
  }
  
  # Additional validations
  public function sysadmin_validate() { 
    # Email is valid
    if (isset($_POST["email"]) && $_POST["email"] != "") {
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"][] = "Email is invalid";
      }
    }
    
    # Password is valid and is verified
    $test = $_POST["password"];
    $patt = "/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/";
    
    if (isset($_POST["password"]) && $_POST["password"] != "") {
      if (isset($_POST["verify"]) && $_POST["verify"] != ""){
        if ($_POST["password"] != $_POST["verify"]) {
          $_SESSION["error"][] = "Passwords don't match";
        }
        else if (strlen($_POST["password"]) < 6 || strlen($_POST["verify"]) < 6) {
          $_SESSION["error"][] = "Passwords should be at least 6 characters";
        }
        else if (!preg_match($patt, $test)) {
          $_SESSION["error"][] = "Password should contain 1 letter and 1 number";
        }
      }
    }
    
    $this->error_check("login");
  }
  
  public function register_validate() {
    # Email is valid
    if (isset($_POST["email"]) && $_POST["email"] != "") {
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"][] = "Email is invalid";
      }
    }
    
    $this->sanitize_post();
    
    # Check if email address is not duplicated
    $email = $this->sanitized["email"];
    
    $sql = "SELECT u.email
            FROM users AS u
            WHERE u.email = '{$email}'
            UNION
            SELECT p.email
            FROM pending AS p
            WHERE p.email = '{$email}'";
    
    $result = $this->get_query($sql);
    
    if ($email == $result[0]["email"]) {
      $_SESSION["error"][] = "Email address already in use";
    }
    
    # Check if user name is not taken    
    $user = $this->sanitized["user"];
    
    $sql = "SELECT u.user_name
            FROM users AS u
            WHERE u.user_name = '{$user}'
            UNION
            SELECT p.user_name
            FROM pending AS p
            WHERE p.user_name = '{$user}'";
    
    $result = $this->get_query($sql);
    
    if ($user == $result[0]["user_name"]) {
      $_SESSION["error"][] = "User name already in use";
    }
    
    # Check if Employee ID is four digits
    if (isset($_POST["employee-id"]) && $_POST["employee-id"] != "") {
      if (strlen($_POST["employee-id"]) != 4) {
        $_SESSION["error"][] = "Invalid Employee ID";
      }
    }
    
    # Check if Employee ID is not taken    
    $employee_id = $this->sanitized["employee-id"];
    
    $sql = "SELECT u.employee_id
            FROM users AS u
            WHERE u.employee_id = '{$employee_id}'
            UNION
            SELECT p.employee_id
            FROM pending AS p
            WHERE p.employee_id = '{$employee_id}'";
    
    $result = $this->get_query($sql);
    
    if ($employee_id == $result[0]["employee_id"]) {
      $_SESSION["error"][] = "Employee ID already in use";
    }
    
    # Password is valid and is verified
    $test = $_POST["password"];
    $patt = "/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/";
    
    if (isset($_POST["password"]) && $_POST["password"] != "") {
      if (isset($_POST["verify"]) && $_POST["verify"] != ""){
        if ($_POST["password"] != $_POST["verify"]) {
          $_SESSION["error"][] = "Passwords don't match";
        }
        else if (strlen($_POST["password"]) < 6 || strlen($_POST["verify"]) < 6) {
          $_SESSION["error"][] = "Passwords should be at least 6 characters";
        }
        else if (!preg_match($patt, $test)) {
          $_SESSION["error"][] = "Password should contain 1 letter and 1 number";
        }
      }
    }
    
    # Account name is valid
    if (isset($_POST["account"]) && $_POST["account"] != "") {
      $account_name = $this->sanitized["account"];
      
      $sql = "SELECT *
              FROM accounts
              WHERE account_name = '$account_name'";
              
      $result = $this->get_rows($sql);
      if ($result != 1) {
        $_SESSION["error"][] = "Invalid account name";        
      }
      
    }
    
    # Position name is valid
    if (isset($_POST["position"]) && $_POST["position"] != "") {
      $position_name = $this->sanitized["position"];
      
      $sql = "SELECT *
              FROM positions
              WHERE position_name = '$position_name'";
      
      $result = $this->get_rows($sql);
      if ($result != 1) {
        $_SESSION["error"][] = "Invalid position name";
      }
      
    } 
    
    $this->error_check("register");
  }
  
  public function recovery_validate() {
    # Email is valid
    if (isset($_POST["email"]) && $_POST["email"] != "") {
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"][] = "Email is invalid";
      }
    }
    
    $this->sanitize_post();
    
    $email = $this->sanitized["email"];
    
    $sql = "SELECT *
            FROM users
            WHERE email = '{$email}'";
    
    $result = $this->get_rows($sql);
    
    if ($result != 1) {
      $_SESSION["error"][] = "Email not found on registry";
    }

    $this->error_check("recover");
  }
  
  # Error check method
  protected function error_check($page) {
    if (count($_SESSION["error"]) > 0) {
      error_log("Error validating form", 0);
      $this->redirect(PATH . "/" . $page);
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
    $approved_by = "system";
  
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
            user_access,
            approved_by
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
            '{$user_access}',
            '{$approved_by}'
            )";
            
    $this->set_query($sql);
    
    $this->error_check("login");
    return true;
  }
  
  # Register all data
  public function register_data() {
    
    $user_name = $this->sanitized["user"];
    $user_firstname = $this->sanitized["first-name"];
    $user_lastname = $this->sanitized["last-name"];
    $employee_id = $this->sanitized["employee-id"];
    $team_id = "team-000";
    $position_name = $this->sanitized["position"];
    
    $password = $this->sanitized["password"];
    $salt = "\$6\$rounds=5000\$".randomStr(8)."\$";
    
    $password = crypt($password, $salt);
    $password = substr($password, strlen($salt));
    
    $user_pic = DEFAULT_PIC;
    $email = $this->sanitized["email"];
    $account_name = $this->sanitized["account"];
    
    $sql = "SELECT *
            FROM positions
            WHERE position_name = '{$position_name}'";
            
    $result = $this->get_query($sql);    
    $user_access = $result[0]["user_access"];
    
    $sql = "INSERT INTO pending (
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
    
    $this->error_check("register");
    return true;
  }
  
  public function recovery_data() {
    
    $email = $this->sanitized["email"];
    
    $sql = "SELECT user_name, email
            FROM users
            WHERE email = '{$email}'";
            
    $result = $this->get_query($sql);
    
    $user = $result[0]["user_name"];
    
    $hash = uniqid("", TRUE);
    $hash = md5($hash);
    $hash = $this->open_link()->real_escape_string($hash);
    
    $sql = "INSERT INTO resetpassword (
            user_name,
            pass_key,
            create_date,
            status
            )
            VALUES (
            '{$user}',
            '{$hash}',
            NOW(),
            '0'
            )";
            
    $this->set_query($sql);
    
    $this->error_check("recover");
    return $hash;
  }
  
  # Redirect
  public function redirect($page) {
    header ("Location: /" . $page);
    exit();
  }
  
}

?>
