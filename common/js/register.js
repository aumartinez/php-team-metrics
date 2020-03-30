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
    var arr = [];
        
    //Required fields    
    if ($("#first-name").val().length == 0) {
      arr.push("first-name");
    }
    
    if ($("#user").val().length == 0) {
      arr.push("user");
    }
    
    if ($("#password").val().length == 0) {
      arr.push("password");
    }
    
    return arr;
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
