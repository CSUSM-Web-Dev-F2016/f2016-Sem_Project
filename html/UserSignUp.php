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

        <div class="container">
            <div class="sign-up-header">
                <div class="box-line"></div>
                <p>
                    Sign Up!
                </p>
                <div class="box-line"></div>
            </div>
            <form class="sign-up-form">
                <div class="outer-section">
                    <div class="inner-sections">
                        Name:
                        <br>
                        <input type="text" name="name" placeholder="" >
                    </div>
                    <div class="inner-sections">
                        Address:
                        <br>
                        <input type="text" name="address">
                    </div>
                    <div class="inner-sections">
                        Email:
                        <br>
                        <input type="text" name="email">
                    </div>
                    <div class="inner-sections">
                        State:
                        <br>
                        <input type="text" name="state">
                    </div>
                    <div class="inner-sections">
                        Password:
                        <br>
                        <input type="password" name="password">
                    </div>
                    <div class="inner-sections">
                        Zip Code:
                        <br>
                        <input type="text" name="zip-code">
                    </div>
                    <div class="inner-sections">
                        Re-Enter Password:
                        <br>
                        <input type="password" name="re-enter-password">
                    </div>
                    <div class="inner-sections">
                        Phone Number:
                        <br>
                        <input type="text" name="phone-number">
                    </div>
                </div>
                <button type="submit" onclick="">Sign-Up</button>
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
