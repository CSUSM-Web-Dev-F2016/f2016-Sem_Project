<!DOCTYPE html>
<html lang="en">

<head>
	<title>Brewery Sign Up Page</title>
	<meta name="description" content="Create your own Brewery" />
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/BrewerySignUp.css">


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
	 //Create a basic connection
    $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

    //Check the connection
    if(!$connection){
        die("Connection Failed. Error: " . mysqli_connect_error());
    }

?>
<body>

	<div class="holder">
		<div class="container">
			<div class="sign-up-header">
				<div class="box-line"></div>
				<p>
					Sign Up Your Brewery
				</p>
				<div class="box-line"></div>
			</div>
			<form class="sign-up-form" action="BreweySignUp.php" method="POST">
				<div class="outer-section">
					<div class="inner-sections">
						Brewery Name:
						<br>
						<input type="text" name="breweryName">
					</div>
					<div class="inner-sections">
						Address:
						<br>
						<input type="text" name="address">
					</div>
					<div class="inner-sections">
						Brewery Email:
						<br>
						<input type="text" name="breweryEmail">
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
						<input type="text" name="zipCode">
					</div>
					<div class="inner-sections">
						Re-Enter Password:
						<br>
						<input type="password" name="passConfirm">
					</div>
					<div class="inner-sections">
						Phone Number:
						<br>
						<input type="text" name="phoneNumber">
					</div>
				</div>
				<button type="submit" onclick="">Sign-Up</button>
			</form>

			<!-- PHP for button action to create account -->
			<?php
				//Create a Brewery if all forms are correctly filled out
				//intialize all variables to blank string
				$breweryName = $address = $breweryEmail = $state = $password = $zipCode = $passConfirm = $phoneNumber = "";

				function test_input($data) {
						$data = trim($data);            // Remove whitespace from both ends of text
						$data = stripslashes($data);    // Removes all slashes from text
						$data = htmlspecialchars($data);// Sets special chars
						return $data;                   // Return results
				}

				//Before the info is sent, we want to check all the vars
				if($_SERVER["REQUEST_METHOD"] == "POST"){

					$errorString = "";
					//Verify that none are empty. If they are, echo it on the screen
					//Check the brewery name
					if(empty($_POST["breweryName"])){
							$errorString = $errorString . "A Brewery Name is required.<br>";
					}else{ $breweryName = test_input($_POST["breweryName"]); }

					if(empty($_POST["address"])){
							$errorString = $errorString . "An Address is required.<br>";
					}else{ $address = test_input($_POST["address"]); }

					if(empty($_POST["breweryEmail"])){
							$errorString = $errorString . "An Email is required.<br>";
					}else{ $breweryEmail = test_input($_POST["breweryEmail"]); }

					if(empty($_POST["state"])){
							$errorString = $errorString . "The State is required.<br>";
					}else{ $state = test_input($_POST["state"]); }

					if(empty($_POST["password"])){
							$errorString = $errorString . "A password is required.<br>";
					}else{ $password = test_input($_POST["password"]); }

					if(empty($_POST["zipCode"])){
							$errorString = $errorString . "A ZipCode is required.<br>";
					}else{ $zipCode = test_input($_POST["zipCode"]); }

					if(empty($_POST["passConfirm"])){
							$errorString = $errorString . "Your password does not match.<br>";
					}else{ $passConfirm = test_input($_POST["passConfirm"]); }

					if(empty($_POST["phoneNumber"])){
							$errorString = $errorString . "A phone number is required.<br>";
					}else{ $phoneNumber = test_input($_POST["phoneNumber"]); }

					//Display the error string
					echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">" . $errorString . "</p>";

					//if there were no errors with the user inputs, get query
					if(strlen($errorString) == 0) {
						//get the local date to store for "date created" in brewery tables
						$localDate = date(Y-m-d);
						//the brewery table only has these attributes from the form
						$insertBreweryTable = "INSERT INTO BreweryTable (BreweryName, PhoneNo, DateAdded) VALUES ('" . $BreweryName . "', '" . $phoneNumber . "', '" . $localDate . "')";

						$breweryTable_Result = mysqli_query($connection, $insertBreweryTable);
						if($breweryTable_Result) {
							echo "<p style=\"text-align:center; color:green; width:100%; font-size:18px;\">Brewery Created!</p>";
						} else {
							die("Connection failed: " . mysqli_connect_error());
						}
						//clear the result since we're done with it
						mysqli_free_result($breweryTable_Result);
					}
				}
				//close connection to database
				mysqli_close($connection);
			?>
		</div>
	</div>

</body>

</html>
