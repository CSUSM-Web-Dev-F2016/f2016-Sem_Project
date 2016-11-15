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
            <form class="sign-up-form" action="UserSignUp.php" method="POST">
                <div class="outer-section">
                    <div class="inner-sections">
                        First Name: <span style="color:red;">*</span>
                        <br>
                        <input type="text" name="name" placeholder="" text="">
                    </div>
                    <div class="inner-sections">
                        Last Name:<span style="color:red;">*</span>
                        <br>
                        <input type="text" name="LName" text="">
                    </div>
                    <div class="inner-sections">
                        Email:<span style="color:red;">*</span>
                        <br>
                        <input type="text" name="email" text="">
                    </div>
                    <div class="inner-sections">
                        Alias:
                        <br>
                        <input type="text" name="alias" text="">
                    </div>
                    <div class="inner-sections">
                        Password:<span style="color:red;">*</span>
                        <br>
                        <input type="password" name="password">
                    </div>
                    <div class="inner-sections">
                        Birthday (yyyy-mm-dd):<span style="color:red;">*</span>
                        <br>
                        <input type="text" name="birthday" text="">
                    </div>
                    <div class="inner-sections">
                        Re-Enter Password:<span style="color:red;">*</span>
                        <br>
                        <input type="password" name="re-enter-password" >
                    </div>
                    <div class="inner-sections">
                        Profile Picture URL:
                        <br>
                        <input type="text" name="ProfilePicURL" text="">
                    </div>
                </div>
                <button type="submit" onclick="">Sign-Up</button>
            </form>

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

                    //Check the state (only two chars allowed)
                    if(empty($_POST["state"])){
                        //State is not required
                        //$errorString = $errorString . "State is required to find breweries near you.<br>";
                    }else{
                        //$State = test_input($_POST["state"]);
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
                    
                    //Verify the zip code 
                    if(empty($_POST["zip-code"])){
                        //Zip code is not gathered
                    }else{
                        //$ZipCode = test_input($_POST["zip-code"]);
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
        </div>

    </body>
</html>
