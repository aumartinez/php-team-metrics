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
  
  function validateForm() {    
    var arr = [];
        
    //Required fields    
    if ($("#email").val().length == 0) {
      arr.push("email");
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
