// Login validate

$(document).ready(function(){
  //To do
  
  $("#login-form").submit(function(evt){
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
      return false;
    }
  });
  
  function validateForm() {
    var errors = [];
    
    //Required fields    
    if ($("#user").val().length == 0) {
      errors.push["user"];
    }
    
    if ($("#password").val().length == 0) {
      errors.push["password"];
    }
    
    return errors;
  }
  
  function displayErrors(errors) {
    for (var i = 0; i < errors.length; i++) {
      $("#" + errors[i] + "\"").next().addClass("active");
    }
    
    $("#error-div").text("Errors found!");
  }
  
  function removeErrors() {
    $(".error-mess.active").removeClass("active");
  }
});
