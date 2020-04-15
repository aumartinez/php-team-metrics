//Startup validate

$(document).ready(function(){
  //To do
    
  $("#startup-form").submit(function(evt){    
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
  
  var clicked = false;
  
  $("#view-password").click(function(){   
    if (clicked == false){
      $("#password").attr("type", "text");
      $("#view-password i").removeClass("fa-eye");
      $("#view-password i").addClass("fa-eye-slash");
      clicked = true;
    }
    else {
      $("#password").attr("type", "password");
      $("#view-password i").removeClass("fa-eye-slash");
      $("#view-password i").addClass("fa-eye");
      clicked = false;
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
    if ($("#email").val().length == 0) {
      err.push("email");
    }
    
    if ($("#user").val().length == 0) {
      err.push("user");
    }
    
    if ($("#password").val().length == 0) {
      err.push("password");
    }
    
    if ($("#verify").val().length == 0) {
      err.push("verify");
    }
        
    //Validate email
    var email = $("#email").val();
    var regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var testEmail = regExp.exec(email);
    
    if (!testEmail || testEmail == null) {
       err.push("email");
    }
    
    //Validate password length
    if($("#password").val().length < 6) {
      err.push("password");
    }
    
    //Validate password complexity (1 letter, 1 number)
    var password = $("#password").val();
    var input = /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;
    var testPass = input.exec(password);
    
    if (!testPass || testPass == null) {
      err.push("password");
    }
    
    //Validate password match
    if($("#password").val() !== $("#verify").val()) {
      err.push("verify");
    }
    
    return err;
  }
  
  function displayErrors(errors) {
    for (var i = 0; i < errors.length; i++) {
      $("#" + errors[i]).next().addClass("active");
    }
    
    $("#error-div").addClass("active");
    $("#error-div").text("Errors found!");
    $(".form-wrapper").css("height", "auto");
  }
  
  function removeErrors() {
    $(".error-mess.active").removeClass("active");
  }
});
