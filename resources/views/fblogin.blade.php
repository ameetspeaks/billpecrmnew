<!DOCTYPE html>
<html>
<head>
  <title>Facebook SDK Example</title>
</head>
<body>
  <div id="status"></div>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '917153237092749',
        cookie     : true,
        xfbml      : true,
        version    : 'v20.0' // Use a supported version
      });

      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    };

    function statusChangeCallback(response) {
      console.log(response)
      if (response.status === 'connected') {
        // Fetch user data by user ID
        const userId = response.authResponse.userID; // Replace with the actual user ID
        FB.api('/' + userId, {fields: 'id,name,email,picture,link,about,birthday,location,education,work'}, function(response) {
          console.log('Full Response:', response); // Log the full response
          if (response && !response.error) {
            document.getElementById('status').innerHTML =
              'ID: ' + response.id + '<br>' +
              'Name: ' + response.name + '<br>' +
              'Email: ' + (response.email ? response.email : 'Not available') + '<br>' +
              'Profile Picture: <img src="' + response.picture.data.url + '" alt="Profile Picture"><br>' +
              'Profile URL: <a href="' + response.link + '" target="_blank">' + response.link + '</a><br>' +
              'About: ' + (response.about ? response.about : 'Not available') + '<br>' +
              'Birthday: ' + (response.birthday ? response.birthday : 'Not available') + '<br>' +
              'Location: ' + (response.location ? response.location.name : 'Not available') + '<br>' +
              'Education: ' + (response.education ? response.education.map(e => e.school.name).join(', ') : 'Not available') + '<br>' +
              'Work: ' + (response.work ? response.work.map(w => w.employer.name).join(', ') : 'Not available');
          } else {
            console.error('Error retrieving user data:', response.error);
            document.getElementById('status').innerHTML = 'Error retrieving user data: ' + response.error.message;
          }
        });
      } else {
        document.getElementById('status').innerHTML = 'Please log into this app.';
      }
    }

    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }
  </script>
  <fb:login-button scope="public_profile,email,user_friends,user_birthday,user_location,user_education_history,user_work_history" onlogin="checkLoginState();"></fb:login-button>
</body>
</html>