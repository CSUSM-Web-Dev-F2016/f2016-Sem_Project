<!Doctype html>
<html lang="en">
<!-- settings page html-->

<head>
	<meta charset="utf-8">
	<title> Account Settings </title>
	<!-- title the page -->
	<link rel="stylesheet" type="text/css" href="../css/settings.css">
	<!-- link to settings.css -->
	<script src="../js/settings.js"></script>
	<!-- ready up script magic -->

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
			session_start(); // start connection

			/*Get the token to prove the user was logged in*/
			  if(strlen($_SESSION['loginToken']) == 0){ // if the user is not logged in
			 header("Location: ../index.php"); // redirect to index.php
		}
			 // Create a basic connection
		    $connection = mysqli_connect("localhost", "calla033", "CAss1007", "team3");

		    // Check the connection
		    if(mysqli_connect_errno()){
		        die("Connection Failed. ERR: " . mysqli_connect_error());
		    }
			function submitChange(){
				echo "testest";
				$sql = "UPDATE Users SET FName='fname',  LName='lname', Email='email, Password='password WHERE Email=$Email";
				if(mysqli_query($connection,$sql)){
					echo " records updated";
				}
				mysql_error($connection);
			/*	UPDATE Users SET FName='fname', LName='lname', Email='email', Password='password' WHERE Email=$Email;*/
		}
		?>

</head>

<body>
	<div class="accountsettings">
		<h2 id="accountsettingstitle"> Account Settings </h2>
		<!-- account settings header -->
		<h3> General Settings: </h3>
		<!-- header for gs -->
		<div class="generalsettings"><br>
			<!-- general settings class -->
			<form onsubmit="return false;">
				<?php
				$GetUserInformationQuery = "SELECT * FROM Users WHERE Email='" . $_SESSION["currentUser"] . "'";
				$userInfoResults = mysqli_query($connection, $GetUserInformationQuery);

				//Check to see if exists (it should since we already logged in)
				if($userInfoResults-> num_rows > 0){
					while($row = mysqli_fetch_assoc($userInfoResults)){
						$FName = $row["FName"];
						$LName = $row["LName"];
						$Email = $row["Email"];
						break; //Only want the first occurance
					}
				}else{
					//Error getting info
				}
				?>
				<!-- general settings form -->
				<div>First Name: </div>
				<!-- first name label -->
				<input class="leftAlign" id="fname" type="text" name="fname" value="<?php echo $FName; ?>"><br>
				<!-- first name form -->
				<div>Last Name: </div>
				<!-- last name label -->
				<input class="leftAlign" id="lname" type="text" name="lname" value="<?php echo $LName; ?>"><br>
				<!-- first name form -->
				<div>Email: </div>
				<!-- email label -->
				<input class="leftAlign" id="email" type="email" name="email" value="<?php echo $Email; ?>"><br>
				<!--email form -->
				<div>Password: </div>
				<!-- password label -->
				<input class="leftAlign" id="password" type="password" name="password" placeholder="*********"><br>
				<!-- password form -->
				<!-- end gernal settings form -->
				<button onclick="<?php submitChange()?>" class="inputbutton">Confirm</button>
			</form>

			<!-- onclick do something -->
		</div>
		<!-- end general settings -->

		<h3> My Breweries: </h3>
		<!-- header for my breweries -->
		<div class="mybreweries"><br>
			<!-- my breweries class -->
			You have don't have any breweries
			<br><br><button type="submit" onclick="location.href='BrewerySignUp.php'">Add Brewery</button>
		</div>
		<!-- end my breweries -->

		<h3> Privacy Settings: </h3>
		<!-- header for ps -->
		<div class="privacysettings"><br>
			<!-- privacy settings class -->
			<form>
				Allow Beerhopper to send you occasional emails?
				<select name="emailopt"> <!-- option to opt out of emails -->
					<option value="yes">Yes</option>
					<option value="no">No</option>
					</select>
				<br><br> Allow other users to search you via email?
				<!-- allow others to search you via email -->
				<select name="searchopt">
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				<br><br> Show location on profile
				<select name="showlocation">
						<option value="yes">Yes</option>
						<option value="no">No</option>
						<option value="follow">Only to users I follow</option>
					</select>
				<br><br> Opt out of personalized ads?
				<select name="personalizedads">
						<option value="yes">Yes</option>
						<option value="no">No</option>
						<option value="etc">Sell my soul for all the loot</option>
					</select>
				<br><br>
			</form>
			<button onclick="" class="input button">Confirm</button>
		</div>
	</div>
</body>

</html>
