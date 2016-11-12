<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Sign Up Page</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="../css/UserSignUp.css">


	<!-- Analytics Script -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-83948702-3', 'auto');
  ga('send', 'pageview');

</script>

<?php
	 //Create a basic connection
    $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

    //Check the connection
    if(mysqli_connect_errno()){
        die("Connection Failed. ERR: " . mysqli_connect_error());
    }
    //echo "Connected Successfully";
    //This code currently works :)

?>

    </head>
    <body>

        <div class="centerDiv">
          <div class="grid">
            <form id="signUpForm" action="../html">
              <label for="First Name" id="fName" class="hidden">First Name:</label>
              <input type="text" name="firstName" id="firstName" placeholder="First Name"/>

              <label for="Last Name" id="lName" class="hidden">Last Name:</label>
              <input type="text" name="lastName" id="LastName" placeholder="Last Name"/>

            </form>

            <?php
                //Define variables and set to empty values
                $FName = $Address = $Email = $State = $Password = $Password2 = $ZipCode = $ProfilePicURl = "";

                //Creates user after checking form input
                function createUser(){
                }

                //Checks form input
                function test_input($data) {
                    $data = trim($data);            // Remove whitespace from both ends of text
                    $data = stripslashes($data);    // Removes all slashes from text
                    $data = htmlspecialchars($data);// Sets special chars
                    return $data;                   // Return results
                }

                //Before the info is sent, we want to check all the vars
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $FName = test_input($_POST["name"]);
                    $Address = test_input($_POST["address"]);
                    $Email = test_input($_POST["email"]);
                    $State = test_input($_POST["state"]);
                    $Password = test_input($_POST["password"]);
                    $Password2 = test_input($_POST["re-enter-password"]);
                    $ZipCode = test_input($_POST["zip-code"]);
                    $ProfilePicURl = test_input($_POST["ProfilePicURL"]);
                }

            ?>
        </div>

    </body>
</html>
