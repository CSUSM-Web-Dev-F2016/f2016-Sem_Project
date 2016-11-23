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
			<form class="sign-up-form" action="BrewerySignUp.php" method="POST">
				<div class="outer-section">
					<div class="inner-sections">
						Brewery Name:
						<br>
						<input type="text" name="breweryName">
					</div>
					<div class="inner-sections">
						Profile Pic URL:
						<br>
						<input type="text" name="profilePic">
					</div>
					<div class="inner-sections">
						Brewery Email:
						<br>
						<input type="text" name="streetAddress">
					</div>
					<div class="inner-sections">
						State:
						<br>
						<input type="text" name="state">
					</div>
					<div class="inner-sections">
						City:
						<br>
						<input type="text" name="city">
					</div>
					<div class="inner-sections">
						Zip Code:
						<br>
						<input type="text" name="zipCode">
					</div>
					<div class="inner-sections">
						Hours:
						<br>
						<input type="text" name="hours">
					</div>
					<div class="inner-sections">
						Phone Number:
						<br>
						<input type="text" name="phoneNumber">
					</div>
				</div>
				<button type="Submit" value="Submit">Sign-Up</button>
			</form>

			<!-- PHP for button action to create account -->
			<?php
				//Create a Brewery if all forms are correctly filled out
				//intialize all variables to blank string
				$breweryName = $profilePic = $streetAddress = $state = $city = $zipCode = $hours = $phoneNumber = "";

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

					if(empty($_POST["profilePic"])){
							$errorString = $errorString . "A Profile Picture URL is required.<br>";
					}else{ $profilePic = test_input($_POST["profilePic"]); }

					if(empty($_POST["streetAddress"])){
							$errorString = $errorString . "A Street Address is required.<br>";
					}else{ $streetAddress = test_input($_POST["streetAddress"]); }

					if(empty($_POST["state"])){
							$errorString = $errorString . "The State is required.<br>";
					}else{ $state = test_input($_POST["state"]); }

					if(empty($_POST["city"])){
							$errorString = $errorString . "A city is required.<br>";
					}else{ $city = test_input($_POST["city"]); }

					if(empty($_POST["zipCode"])){
							$errorString = $errorString . "A ZipCode is required.<br>";
					}else{ $zipCode = test_input($_POST["zipCode"]); }

					if(empty($_POST["hours"])){
							$errorString = $errorString . "Please enter the Hours of Operation.<br>";
					}else{ $hours = test_input($_POST["hours"]); }

					if(empty($_POST["phoneNumber"])){
							$errorString = $errorString . "A phone number is required.<br>";
					}else{ $phoneNumber = test_input($_POST["phoneNumber"]); }

					//Display the error string
					echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">" . $errorString . "</p>";

					//if there were no errors with the user inputs, get query
					if(strlen($errorString) == 0) {
						//get the local date to store for "date created" in brewery tables
						$localDate = date('Y-m-d H:i:s');
						//the brewery table only has these attributes from the form
						$insertBreweryTable = "INSERT INTO BreweryTable (BreweryName, PhoneNo, DateAdded, ProfilePicURL, Hours) VALUES ('" . $breweryName . "', '" . $phoneNumber . "', '" . $localDate . "', '" . $profilePic . "', '" . $hours . "')";
						$breweryTable_Result = mysqli_query($connection, $insertBreweryTable);
						if(!$breweryTable_Result) {
							die("Could not fullfill BreweryTable Request: " . mysqli_error($connection));
						}
						//get Foreign key for Location table
						$getForeignKey = "SELECT BreweryID FROM BreweryTable WHERE BreweryName = 'TEST1'";
						$foreignKey_Result = mysqli_query($connection, $getForeignKey);
						if (!$foreignKey_Result) {
							die("Could not fullfill foreign Key Request: " . mysqli_error($connection));
						}
						//fetch the row of the array, use assoc index to get BreweryID
						$foreignKey = mysqli_fetch_assoc($foreignKey_Result);
						//get query for Brewery Location Table
						$insertBreweryLocation = "INSERT INTO BreweryLocation (BreweryID, AddrLineOne, City, State, Zip) VALUES ('" . $foreignKey["BreweryID"] . "','" . $streetAddress . "', '" . $city . "', '" . $state . "', '" . $zipCode . "')";
						$breweryLocation_Result = mysqli_query($connection, $insertBreweryLocation);
						if (!$breweryLocation_Result) {
							die("Could not fullfill BreweryLocation Request: " . mysqli_error($connection));
						} else {
							echo "<p style=\"text-align:center; color:green; width:100%; font-size:18px;\">Brewery Created!</p>";
						}

					}
				}
				//close connection to database
				mysqli_close($connection);
			?>
		</div>
	</div>

</body>

</html>
