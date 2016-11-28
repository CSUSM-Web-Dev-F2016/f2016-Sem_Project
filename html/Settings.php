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
              if (strlen($_SESSION['loginToken']) == 0) { // if the user is not logged in
             header('Location: ../index.php'); // redirect to index.php
              }
             // Create a basic connection
            $connection = mysqli_connect('localhost', 'calla033', 'CAss1007', 'team3');

            // Check the connection
            if (mysqli_connect_errno()) {
                die('Connection Failed. ERR: '.mysqli_connect_error());
            }

            $GetUserInformationQuery = "SELECT * FROM Users WHERE Email='".$_SESSION['currentUser']."'";
            $userInfoResults = mysqli_query($connection, $GetUserInformationQuery);

            if ($userInfoResults->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($userInfoResults)) {
                    $FName = $row['FName'];
                    $LName = $row['LName'];
                    $Email = $row['Email'];
                    $Password = $row['Password'];
                    break;
                }
            }
        ?>

</head>

<body>
	<div class="accountsettings">
		<h2 id="accountsettingstitle"> Account Settings </h2> <!-- account settings header -->
		<h3> General Settings: </h3> <!-- header for gs -->
		<div class="generalsettings"><br> <!-- general settings class -->
				<?php
                    /* If the user has info */
                    if ($userInfoResults->num_rows > 0) {
                        /* echo the form data for them */
                        echo "<form action='' class='stdForm' method='POST'' name='generalsettings'>";
                        echo '<div>First Name: </div>';
                        echo "<input class='leftAlign' id='fname' type='text' name='fname' value='$FName'><br>";
                        echo '<div> Last Name: </div>';
                        echo "<input class='leftAlign' id='lname' type='text' name='lname' value='$LName'><br>";
                        echo '<div> Email: </div>';
                        echo "<input class='leftAlign' id='email' type='text' name='email' value='$Email'><br>";
                        echo '<div> Password: </div>';
                        echo "<input class='leftAlign' id='password' type='password' name='password' value='$Password'><br>";
                        echo '<button type="submit" name="generalsettings">Comfirm</button>';
                        echo '</form>';
                    } else {
                        //Error getting info
                    }
                if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if a post request was found
                    if (isset($_POST['generalsettings'])) { // and it was from general settings
                        $fn = $_POST['fname']; // fn = new first name
                        $ln = $_POST['lname']; // ln = new last name
                        $em = $_POST['email']; // em = new email
                        $pw = $_POST['password']; // pw = new password
                        $updateUserInfo = "UPDATE Users Set FName = '".$fn."', LName = '".$ln."', Email = '".$em."', Password = '".$pw."' WHERE Email = '".$_SESSION['currentUser']."'"; // get update statement
                        if (mysqli_query($connection, $updateUserInfo)) {
                            echo 'Records updated<br>';
                            echo "<br>$updateUserInfo";
                        } else {
                            echo '<br><br><br>';
                            echo "$updateUserInfo";
                            echo 'ERORRRR';
                        }
                    }
                }
                ?>
		</div>
		<!-- end general settings -->

		<h3> My Breweries: </h3>n<!-- header for my breweries -->
		<div class="mybreweries"><br> <!-- my breweries class -->
			<?php
                $GetUserInformationQuery = "SELECT * FROM BreweryOwner WHERE UserEmail='".$_SESSION['currentUser']."'"; // get user info query
                $userInfoResults = mysqli_query($connection, $GetUserInformationQuery); // get user info
                if ($userInfoResults->num_rows > 0) { // if there are results
                    while ($row = mysqli_fetch_assoc($userInfoResults)) {
                        $OwnerID = $row['OwnerID']; // OwnerID = OwnerID
                        $UserEmail = $row['UserEmail']; // UserEmail = UserEmail
                        $BreweryID = $row['BreweryID']; // BreweryID = BreweryID
                        break;
                    }
                } else { // the user has no breweries
                    echo 'You do not have any breweries'; // Output the user does not have a brewery
                }
            ?>
			<br><br><button type="submit" onclick="location.href='BrewerySignUp.php'">Add Brewery</button> <!-- link to create brewery -->
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
