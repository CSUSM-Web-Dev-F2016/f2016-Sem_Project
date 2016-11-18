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
<div class="is_overlay">
    <img src="http://beerhopper.me/img/bckImg.jpg" alt="Background img">
</div>

    </head>
    <body>

      <div class="centerDiv">
      <!-- Show banner -->
      <div class="banner">
			<img src="../img/Beer_Hopper_Banner.png" alt="Banner">
		</div>

          <div class="grid">
              <p class="centerText" id="sign-up-header">Sign Up</p>
              <form id="signUpForm" action="UserSignUp.php" method="POST">
                  <label for="First_Name" id="fName" class="hidden">First Name:</label>
                  <input type="text" name="name" id="firstName" placeholder="First Name"/>

                  <label for="Last_Name" id="lName" class="hidden">Last Name:</label>
                  <input type="text" name="LName" id="LastName" placeholder="Last Name"/>

                  <label for="email" id="email" class="hidden">Email</label>
                  <input type="text" name="email" id="email" placeholder="Email"/>

                  <label for="birthday" id="birthdayLabel" class="hidden">Birthday</label>
                  <input type="text" id="birthday" name="birthday" placeholder="DOB: yyyy-mm-dd"/>

                  <label for="password" id="pass" class="hidden">Password:</label>
                  <input type="password" name="password" id="password" placeholder="•••"/>

                  <label for="re-enter-password" id="re-enter-password" class="hidden">Re-Enter Password:</label>
                  <input type="password" name="re-enter-password" id="re-enter-password" placeholder="•••"/>

                  <label for="submitButton" id="sButton" class="hidden">Submit:</label>
                  <input type="submit" id="subButton" value="Submit"/>

              </form>
          </div>
        </div>

        <?php
                //Define variables and set to empty values
                $FName = $LName = $birthday = $Email = $State = $Password = $Password2 = $ZipCode = $ProfilePicURl = "";

                //Creates user after checking form input
                function createUser(){
                    echo "Creating User";
                    $connection ->close();
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

                    $errorString = "";
                    //Verify that none are empty. If they are, echo it on the screen using a massive string
                    //Check the first name
                    if(empty($_POST["name"])){
                        $errorString = $errorString . "First Name is required.<br>";
                    }else{
                        $FName = test_input($_POST["name"]);
                    }

                    //Check the last name
                    if(empty($_POST["LName"])){
                        $errorString = $errorString . "Last Name is required.<br>";
                    }else{
                        $LName = test_input($_POST["LName"]);
                    }

                    //Check the birthday
                    if(empty($_POST["birthday"])){
                        $errorString = $errorString . "A Birthday is required (21+ Only)<br>";
                    }else{
                        //Do the parsing here for dob
                        $birthday = test_input($_POST["birthday"]);
                    }

                    //Check the email.. This is imperitive
                    if(empty($_POST["email"])){
                        $errorString = $errorString . "Email is required. We will not SPAM.<br>";
                    }else{
                        $Email = test_input($_POST["email"]);
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
                        $ProfilePicURl = "https://bucketlist.org/static/images/generic-profile-pic.png";
                    }else{
                        $ProfilePicURl = test_input($_POST["ProfilePicURL"]);
                    }

                    //Display the error string
                    echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">" . $errorString . "</p>";

                    //If the length of the error string is 0, create user.
                    if(strlen($errorString) == 0){
                        //Create the user in an SQL Command, tehn, log them in.
                        $createUserQuery = "INSERT INTO Users (Email, Password, FName, LName, DOB, ProfilePicURL) VALUES ('" . $Email . "', '" . $Password . "', '" . $FName . "', '" . $LName . "', '" . $birthday . "', '" . $ProfilePicURl . "')";

                        if(mysqli_query($connection, $createUserQuery)){
                        //The item was successfull created, now change the login page.
                            echo "<p style=\"text-align:center; color:green; width:100%; font-size:18px;\">Successfully inserted data</p>";

                            //Now that user is created, only take them further if they are over 21.
                            //Create a query to see if there are in the view
                            $ageQuery = "SELECT Current_Age FROM valid_Users WHERE Email='" . $Email . "'";

                            //Run the query. If no rows are returned, they must be too young (since we just created it);
                            if($result = mysqli_query($connection, $ageQuery)){
                                //Success, tak them to the main profile page., if there are more than 1 row
                                if($result-> num_rows > 0){
                                    session_start();
                                    $_SESSION['currentUser'] = $_SESSION['signedInUser'] = $Email;
                                    header("Location:  ./profilePage.php");
                                }else {
                                    echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">User is not yet 21. Please come back when you are.<b>";
                                }
                            }else{
                                echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">Error Checking age<b>";
                            }
                        }else{
                            echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">Error with creating account: <br>" . $connection->error . "</p>";
                        }
                    }
                }


            ?>

    </body>
</html>
