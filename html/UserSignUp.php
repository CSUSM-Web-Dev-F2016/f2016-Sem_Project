<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Sign Up Page</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="../css/UserSignUp.css">
        <link rel="stylesheet" type="text/css" href="../css/backgroundVideo.css">

	<!-- Analytics Script -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-83948702-3', 'auto');
  ga('send', 'pageview');

</script>

    </head>
    <body>
      <div class="is_overlay">
          <img src="http://beerhopper.me/img/bckImg.jpg" alt="Background img">
      </div>

      <<div class="centerDiv">
          <div class="grid">
              <p class="centerText" id="sign-up-header">Sign Up</p>
              <form id="signUpForm" action="../html/UserSignUp.php" method="post">
                  <label for="FirstName" id="fName" class="hidden">First Name:</label>
                  <input type="text" name="firstName" id="FirstName" placeholder="First Name"/>

                  <label for="LastName" id="lName" class="hidden">Last Name:</label>
                  <input type="text" name="lastName" id="LastName" placeholder="Last Name"/>

                  <label for="email" id="email" class="hidden">Email</label>
                  <input type="text" name="email" id="userEmail" placeholder="Email"/>

                  <label for="password" id="pass" class="hidden">Password:</label>
                  <input type="text" name="Password" id="password" placeholder="Password"/>

                  <label for="re_enter_password" id="reEnter_password" class="hidden">Re-Enter Password:</label>
                  <input type="text" name="Re_enter_password" id="Re_enter_password" placeholder="Re-Enter Password"/>

                  <label for="dob" id="dateBirth" class="hidden">DOB:</label>
                  <input type="text" name="DOB" id="dob" placeholder="Date of Birth"/>

                  <label for="subButton" id="sButton" class="hidden">Submit:</label>
                  <input type="submit" id="subButton" value="Submit"/>

              </form>
          </div>
      </div>


      <?php
      include '../php/create_user.php';

      //Define variables and set to empty values
      $FName = $LName = $birthday = $Email  = $Password = $Password2  = $ProfilePicURl = "";


      //Checks form input
      function test_input($data) {
          $data = trim($data);            // Remove whitespace from both ends of text
          $data = stripslashes($data);    // Removes all slashes from text
          $data = htmlspecialchars($data);// Sets special chars
          return $data;                   // Return results
      }


      $errorString = "";
      //Verify that none are empty. If they are, echo it on the screen using a massive string
      //Check the first name
      if(empty($_POST["FirstName"])){
          $errorString = $errorString . "First Name is required.<br>";
      }else{
          $FName = test_input($_POST["FirstName"]);
      }

      //Check the last name
      if(empty($_POST["LastName"])){
          $errorString = $errorString . "Last Name is required.<br>";
      }else{
          $LName = test_input($_POST["LastName"]);
      }

      //Check the birthday
      if(empty($_POST["dob"])){
          $errorString = $errorString . "A Birthday is required (21+ Only)<br>";
      }else{
          //Do the parsing here for dob
          $birthday = test_input($_POST["dob"]);
      }

      //Check the email.. This is imperitive
      if(empty($_POST["userEmail"])){
          $errorString = $errorString . "Email is required. We will not SPAM.<br>";
      }else{
          $Email = test_input($_POST["userEmail"]);
      }

      //Verify the password. They must also be equal
      if(empty($_POST["password"])){
          $errorString = $errorString . "Password is required.<br>";
      }else{
          $Password = test_input($_POST["password"]);
      }
      if(empty($_POST["re-enter-password"])){
          $errorString = $errorString . "Verify your password<br>";
      }else{
          $Password2 = test_input($_POST["re-enter-password"]);
      }
      if($Password != $Password2){
          $errorString = $errorString . "Passwords do not match<br>";
      }


      //Get the profile pic url (optional)
      if(empty($_POST["ProfilePicURL"])){
          //$errorString = $errorString . "State is required to find breweries near you.<br>";
          $ProfilePicURl = "https://pbs.twimg.com/profile_images/1665394718/image.jpg";
      }else{
          $ProfilePicURl = test_input($_POST["ProfilePicURL"]);
      }

      //Display the error string
      echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">" . $errorString . "</p>";

      //If the length of the error string is 0, create user.
      if(strlen($errorString) == 0){
          // calls user that creates user in the db
          createUser($FName, $LName, $birthday, $Email, $Password, $ProfilePicURl);
      }
      
      ?>
    </body>
</html>




