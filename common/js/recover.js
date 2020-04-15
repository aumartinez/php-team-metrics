//Recover validate

$(document).ready(function(){
  //To do
    
  $("#recover-form").submit(function(evt){    
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
  
  function validateForm() {    
    var err = [];
        
    //Required fields
    if ($("#email").val().length == 0) {
      err.push("email");
    }    
    
    //Validate email
    var email = $("#email").val();
    var regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var testEmail = regExp.exec(email);

    if (!testEmail || testEmail == null) {
       err.push("email");
    }
    
    return err;
  }
  
  function displayErrors(errors) {
    for (var i = 0; i < errors.length; i++) {
      $("#" + errors[i]).next().addClass("active");
    }
    
    $("#error-div").addClass("active");
    $("#error-div").text("Errors found!");
  }
  
  function removeErrors() {
    $(".error-mess.active").removeClass("active");
  }
});
