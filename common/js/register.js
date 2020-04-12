// Login validate

$(document).ready(function(){
  //To do
    
  $("#register-form").submit(function(evt){    
    $(".loader").addClass("active");
    var errors = validateForm();
    
    if (errors.length == 0) {
      return true;
    }
    else {
      removeErrors();
      displayErrors(errors);
      evt.preventDefault();
      window.scrollTo(0, 0);
      $(".loader").removeClass("active");      
    }
  });
  
  //Reveal password widget
  var passclicked = false;
  
  $("#view-password").click(function(){   
    if (passclicked == false){
      $("#password").attr("type", "text");
      $("#view-password i").removeClass("fa-eye");
      $("#view-password i").addClass("fa-eye-slash");
      passclicked = true;
    }
    else {
      $("#password").attr("type", "password");
      $("#view-password i").removeClass("fa-eye-slash");
      $("#view-password i").addClass("fa-eye");
      passclicked = false;
    }
  });
  
  var verifyclicked = false;
  
  $("#view-match").click(function(){   
    if (verifyclicked == false){
      $("#verify").attr("type", "text");
      $("#view-match i").removeClass("fa-eye");
      $("#view-match i").addClass("fa-eye-slash");
      verifyclicked = true;
    }
    else {
      $("#verify").attr("type", "password");
      $("#view-match i").removeClass("fa-eye-slash");
      $("#view-match i").addClass("fa-eye");
      verifyclicked = false;
    }
  });
  
  function validateForm() {    
    var err = [];
        
    //Required fields    
    if ($("#first-name").val().length == 0) {
      err.push("first-name");
    }
    
    if ($("#last-name").val().length == 0) {
      err.push("last-name");
    }
    
    if ($("#email").val().length == 0) {
      err.push("email");
    }
    
    if ($("#user").val().length == 0) {
      err.push("user");
    }
    
    if ($("#employee-id").val().length == 0) {
      err.push("employee-id");
    }
    
    if ($("#password").val().length == 0) {
      err.push("password");
    }
    
    if ($("#verify").val().length == 0) {
      err.push("verify");
    }
    
    if ($("#verify").val().length == 0) {
      err.push("verify");
    }
    
    if ($("#account").val().length == 0) {
      err.push("account");
    }
    
    if ($("#position").val().length == 0) {
      err.push("position");
    }
    
    return err;
  }
  
  function displayErrors(errors) {
    for (var i = 0; i < errors.length; i++) {
      $("#" + errors[i]).next().addClass("active");
    }
    
    $("#error-div").text("Errors found!");
  }
  
  function removeErrors() {
    $(".error-mess.active").removeClass("active");
  }
});
