<!DOCTYPE html>

<html lang="en-us">

<head>
	<!-- Import CSS Files -->
	<link rel="stylesheet" href="css/header.css" type="text/css">
	<link rel="stylesheet" href="css/masterPage.css" type="text/css">
	<link rel="stylesheet" href="css/backgroundVideo.css" type="text/css">
	<link rel="stylesheet" href="css/login.css" type="text/css">

	<!-- Import JS Files -->

	<!-- Header Bar -->
	<div class="header">
		<img class="logo" src="img/Beer_Hopper_Banner.png" alt="Beer Hopper Logo">
	</div>

	<!-- Navigation Bar -->
	<nav>
		<!-- This is a table with two rows -->
	</nav>

	<!-- Put a background video that covers the entire page -->
	<div class="is_overlay">
		<video autoplay loop>
			<source src="http://beerhopper.me/img/bw.mp4" type="video/mp4">
			<source src="img/bw.webm" type="video/webm">
		</video>
	</div>

	<!-- Meta data -->
	<title>Beer Hopper</title>
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

<?php
	//If the user is logged in, take them to the profile page
	//Start the session
	  session_start();

	  //Get the token to prove the user was logged in
	  if(strlen($_SESSION['loginToken']) != 0){
		  //redirect to the login page
		  $_SESSION['currentUser'] = $_SESSION['signedInUser'];
		  header("Location: html/profilePage.php");
	  }else{
		  //echo "<p style=\"color:white\">You rock: " . $_GET['id'] . "<br></p>";
	  }
?>


<body>


	<!-- Put the login page on the right side of the screen -->
	<div class="centerDiv">

		<!-- Ad the beer hopper banner to the left -->
		<div class="banner">
			<img src="img/Beer_Hopper_Banner.png" alt="Banner">
		</div>

		<div class="grid">
			<form id="loginForm" action="index.php" class="loginForm" method="POST">

				<label for="username" id="uLabel" class="hidden">Username:</label>
				<input type="text" name="username" id="username" placeholder="Username" />

				<label for="password" id="pLabel" class="hidden">Password:</label>
				<input type="password" id="password" placeholder="Password" name="password"/>

				<label for="loginButton" id="lButton" class="hidden">Submit:</label>
				<input type="submit" id="loginButton" value="Login" />

			</form>

			<?php


			/** Determines if the user exists, tehn if the password matches */
			function getLoginInfo(){

			$connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

   		 	//Check the connection
    		if(mysqli_connect_errno()){
       			 die("Connection Failed. ERR: " . mysqli_connect_error());
    		}
   			 //echo "<p class\"centerText\"> Connection Success!</p>";

				$getLoginQuery = "SELECT Users.Email, Users.Password FROM Users WHERE Users.Email='" . $_POST['username'] . "'";
		//echo "<p class\"centerText\" color=\"white\">" . $getLoginQuery . "</p>";

				$loginInfoGathered = mysqli_query($connection, $getLoginQuery);


				if($loginInfoGathered-> num_rows > 0){
					//echo "<p class\"centerText\"> Found " . $loginInfoGathered-> num_rows . " rows</p>";

					//If a row was found, check the password
					while($row = mysqli_fetch_assoc($loginInfoGathered)){
						if($row["Password"] == $_POST["password"]){
							//echo "<p class\"centerText\"> Correct Password Match </p>";

							//Set the username to search in the session var .. current user is for the page, signed in user is for the rights
							$_SESSION['currentUser'] = $_SESSION['signedInUser'] = $row["Email"];

							//Now, set the authorization token value so we know the user is logged in
							$_SESSION['loginToken'] = "yes";

							//We need to update the last time the user has logged in. Do that here.
							$UpdateUserLoginDate = "UPDATE Users SET LastLogin=UTC_TIMESTAMP() WHERE Email='" . $row['Email'] . "'";
							$UpdateUserLoginDateResults = mysqli_query($connection, $UpdateUserLoginDate);


							if(!$UpdateUserLoginDateResults){
								echo "<script type=\"text/javascript\"> window.alert(\"Could not update last login time due to Err:  " . mysqli_error($connection) . "\");</script>";
							}else{
								//echo "<script type=\"text/javascript\">window.alert(\"User Updated: " . $row['Email'] . "\");</script>";
							}


							//Close the SQL connection
							$connection->close();

							//Open the next page
							header("Location: ./html/profilePage.php");

							exit(); //Leave the current Session
							break;

						}else{
							echo "<p class\"centerText\" style=\"color:red; text-align:center; font-size:20px\"> Not correct password. Try again</p>";
						}
					}
				}else{
					echo "<p class\"centerText\" style=\"color:red; text-align:center; font-size:20px\">Account Not found</p>";
				}

				echo '</script>';
			}
			/** Adds the action listener to the submit button */
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				//Make sure the fields are not blank, first

				//Get data from the table
				getLoginInfo();
			}
			?>

			<p class="centerText">
				Not a member?
				<a href="html/UserSignUp.php">Sign up now</a>
			</p>
		</div>

	</div>


</body>


</html>
