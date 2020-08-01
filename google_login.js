
  var googleUser = {};
  var logged_in = "";

  var startApp = function() {

    // console.log(logged_in);
    gapi.load('auth2', function(){
      // set up the client
      auth2 = gapi.auth2.init({
        client_id: '1070054651173-2je2vs1jfr7nfv840gfef8grdj5e75ea.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
      }).then(function(){

        auth2 = gapi.auth2.getAuthInstance();
        // console.log(auth2.isSignedIn.get());

        if(window.location.pathname.substring(1) == "~huan981/final_project/index.php" || window.location.pathname.substring(1) == "index.php"){
          attachSignin(document.getElementById('gbtn'));
        }

      });
    });
  };

  function attachSignin(element) {
    // console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) { //callback
          
           // console.log("name: " + googleUser.getBasicProfile().getName());
           // console.log("email: " + googleUser.getBasicProfile().getEmail());

           var name = googleUser.getBasicProfile().getName();
           var email = googleUser.getBasicProfile().getEmail();

           //post request to php
           sendLoginInfo(name, email);


        }, function(error) {
          // alert(JSON.stringify(error, undefined, 2));
        });
  }
 
function sendLoginInfo(nameInput, emailInput){
  $.ajax({
      url: 'handle_login.php',
      type: 'POST',
      data: { name : nameInput, email: emailInput },
      success: function(output){
        // console.log(output);
        window.location.reload(true); 
      }
    });
}

$("#logout-btn").click(function() {
  gapi.auth2.getAuthInstance().signOut();
  sendLogoutInfo();
});

function sendLogoutInfo(){
  $.ajax({
      url: 'logout.php',
      type: 'POST',
      success: function(output){
        // console.log(output);
        window.location.replace("index.php"); 
      }
    });

}
