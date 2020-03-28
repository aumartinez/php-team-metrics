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
});
