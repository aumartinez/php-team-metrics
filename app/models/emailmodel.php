<?php

class EmailModel extends DbModel {
    
  public function submit_recover($email, $hash) {      
    $url_hash = urlencode($hash);
    
    $server_url = isset($_SERVER["HTTPS"]) ? "https://" : "http://";
    $server_url .= $_SERVER["SERVER_NAME"];
    
    $str = $_SERVER["PHP_SELF"];      
    $arr = explode("/", $str);
    $str = array();
    
    for ($i = 0; $i < count($arr); $i++) {
      if ($i == (count($arr) - 1)) {
        break;
      }
      array_push($str, $arr[i]);
    }
    
    $str = join("/", $str);      
    
    $server_url .= $str;
    $server_url .= PATH . "/reset/user/?h=" . $url_hash;
    
    $emailbody = '
          <div style="font-family: Arial, sans-serif; margin: 60px auto; width: 600px">
            <h3 style="text-align: center; color: #46b3e6;">
              Password reset request
            </h3>
            <hr />
            <p>
              Click <a href="'.$server_url.'" title="Reset password">here</a> to open the link to the reset password page.
            </p>
          </div>          
    ';
    
    $to = $email;
    $subject = "Password reset requested";
    $txt = $emailbody;
    
    $headers = array(
               "MIME-Version : 1.0",
               "Content-type: text/html; charset=utf-8",
               "From: no-reply@teams.com",
               "Reply-To: no-reply@teams.com",
               "X-Mailer: PHP/" . PHP_VERSION
               );
               
    $headers = implode("\r\n", $headers);
    $send = mail($to, $subject, $txt, $headers);
    
    if (!$send) {
      $_SESSION["error"][] = "Mail send error, try again later";        
      $this->error_check("recover");
    }
    else {
      return true;
    }
  }
    
  public function submit_reset($hash = "") {
    $emailbody = '
      <div style="font-family: Arial, sans-serif; margin: 60px auto; width: 600px">
        <h3 style="text-align: center; color: #46b3e6;">
          Password reset request
        </h3>
        <hr />
        <p>
          Click <a href="'.$server_url.'" title="Reset password">here</a> to open the link to the reset password page.
        </p>
      </div>          
    ';
    
    $to = $email;
    $subject = "Password changed";
    $txt = $emailbody;
    
    $headers = array(
              "MIME-Version : 1.0",
              "Content-type: text/html; charset=utf-8",
              "From: no-reply@teams.com",
              "Reply-To: no-reply@teams.com",
              "X-Mailer: PHP/" . PHP_VERSION
              );
    
    $headers = implode("\r\n", $headers);
    $send = mail($to, $subject, $txt, $headers);
    
    if (!$send) {
      $_SESSION["error"][] = "Password changed, but server couldn't send confirmation email";        
      $this->error_check("reset/user/?h=" . $hash);
    }
    else {
      return true;
    }
  }
    
  # Error check method
  protected function error_check($page) {
    if (count($_SESSION["error"]) > 0) {
      error_log("Error validating form", 0);
      $this->redirect(PATH . "/" . $page);
    }
  }
      
  # Redirect
  public function redirect($page) {      
    header ("Location: /" . $page);      
    exit();
  }
}

?>
