<?php
    header('Content-Type: text/html; charset=ISO-8859-1');
?>

<!Doctype html>
<html lang="en">
<!-- settings page html-->

<head>
	<meta charset="utf-8">
	<title> Account Settings </title>
	<!-- title the page -->
	<link rel="stylesheet" type="text/css" href="../css/settings.css"><!-- link to settings.css -->
	<script src="../js/Settings.js"></script><!-- ready up script magic -->

	<!-- Analytics Script -->
	<script src="../js/analytics.js"></script>

		<?php

            /* removes visible <br> tag from brewery hours & brewery story to display in settings */
            function removeBR($variable)
            {
                if (strstr($variable, '<br>')) { // if $variable has <br>
                    $variable = str_ireplace('<br>', '', $variable); // get rid of <br> tag
                }

                return $variable;
            }

            session_start(); // start connection

            /*Get the token to prove the user was logged in*/
              if (strlen($_SESSION['loginToken']) == 0) { // if the user is not logged in
             header('Location: ../index.php'); // redirect to index.php
              }
             // Create a basic connection
            $connection = include '../php/DBConnectionReturn.php';

            $GetUserInformationQuery = "SELECT * FROM Users WHERE Email='".$_SESSION['signedInUser']."'"; // query to get user's information
            $userInfoResults = mysqli_query($connection, $GetUserInformationQuery); // store into results

            if ($userInfoResults->num_rows > 0) { // if there are results
                while ($row = mysqli_fetch_assoc($userInfoResults)) {
                    $FName = $row['FName']; // assign FName in db to $FName
                    $LName = $row['LName']; // assign LName in db to $LName
                    $Email = $row['Email']; // assign Email in db to $email
                    $Password = password_verify($row['Password'], password_hash($row['Password'], PASSWORD_DEFAULT)); // assign Password in db to $Password
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
                        echo "<form action='' class='stdForm' method='POST' name='generalsettingsform'>";
                        echo '<div>First Name: </div>';
                        echo "<input class='leftAlign' id='fname' type='text' name='fname' value='$FName'><br>";
                        echo '<div> Last Name: </div>';
                        echo "<input class='leftAlign' id='lname' type='text' name='lname' value='$LName'><br>";
                        echo '<div> Email: </div>';
                        echo "<input class='leftAlign' id='email' type='text' name='email' value='$Email'><br>";
                        echo '<br><button type="submit" name="generalsettings">Confirm</button>';
                        echo '</form>';
                    } else {
                        echo 'err: there is no data to be displayed'; //Error getting info
                    }
                if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if a post request was found
                    if (isset($_POST['generalsettings'])) { // and it was from general settings
                        $fn = $_POST['fname']; // fn = new first name
                        $ln = $_POST['lname']; // ln = new last name
                        $em = $_POST['email']; // em = new email

                        $updateUserInfo = "UPDATE Users Set FName = '".$fn."', LName = '".$ln."', Email = '".$em."' WHERE Email = '".$_SESSION['currentUser']."'"; // get update statement
                        if (mysqli_query($connection, $updateUserInfo)) { // if records updated
                            echo 'Records updated';
                            /* refresh parent page */
                            echo '<script type="text/javascript"> top.window.location.href = "../html/profilePage.php";</script>';
                        } else { // there was an error updating records
                            echo '<br><br><br>';
                            echo "$updateUserInfo";
                            echo 'ERORRRR: There was an error updating your user information<br>';
                        }
                    }
                }
                ?>
		</div>
		<!-- end general settings -->
		<h3> Password Settings: </h3> <!-- header for gs -->
		<div class="generalsettings"><br>
			<?php
                /* If there are results then display password form */
                if ($userInfoResults->num_rows > 0) {
                    echo "<form action='' class='stdForm' method='POST' name='passwordsettingsform'>";
                    echo '<div> Password: </div>';
                    echo "<input class='leftAlign' id='password' type='password' name='password' value='$Password'>";
                    echo '<div> Re-Enter Password: </div>';
                    echo "<input class='leftAlign' id='reenterPassword' type='password' name='reenterPassword' value='$Password'>";
                    echo '<br><br><button type="submit" name="passwordsettings">Confirm</button>';
                    echo '</form>';
                } else {
                    echo 'err: There is no password to be displayed'; // there is no password
                }
                if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if a post request was found
                    if (isset($_POST['passwordsettings'])) { // and it was from passwordsettings
                        if ($_POST['password'] == $_POST['reenterPassword']) { // and if password and reenter password match
                            $pw = password_hash($_POST['password'], PASSWORD_DEFAULT); // pw = new (hashed) password
                            $updateUserInfo = "UPDATE Users Set Password = '".$pw."' WHERE Email = '".$_SESSION['signedInUser']."'"; // get update statement
                            if (mysqli_query($connection, $updateUserInfo)) { // if update was successful
                                echo 'Records updated';
                                /* refresh parent page */
                                echo '<script type="text/javascript"> top.window.location.href = "../html/profilePage.php";</script>';
                            } else { // update was not successful
                                echo '<br><br><br>';
                                echo "$updateUserInfo";
                                echo 'ERORRRR';
                            }
                        } else { /* red error msg if passwords do not match */
                            echo '<p><br><br></p><span style="color: red;">Error Updating</span>';
                            echo '<br><span style="color: red;">Passwords did not match</span></p>';
                        }
                    }
                }
            ?>
		</div>

		<h3> Privacy Settings: </h3> <!-- header for ps -->
		<div class="privacysettings"> <!-- privacy settings class -->

			<!-- get current privacy settings -->
			<?php
            $GetUserPrivacySettingsQuery = "SELECT * FROM PrivacySettings WHERE UserEmail='".$_SESSION['signedInUser']."'"; // privacy settings query
            $UserPrivacySettings = mysqli_query($connection, $GetUserPrivacySettingsQuery); // user privacy settings results
            if ($UserPrivacySettings->num_rows > 0) { // if there are results
                while ($row = mysqli_fetch_assoc($UserPrivacySettings)) {
                    $AllowEmails = $row['AllowEmails']; // $AllowEmails = AllowEmails
                    $AllowSearch = $row['AllowSearch']; // $AllowSearch = AllowSearch
                    $ShowLocation = $row['ShowLocation']; // $ShowLocation = ShowLocation
                    $PersonalizedAds = $row['PersonalizedAds']; // $PersonalizedAds = PersonalizedAds
                    break;
                }
            } else { // if the user is not in the table yet
                $NotInTable = true; // $NotInTable is true
            }
             ?>
			 <!-- form for privacy settings -->
			<form action="" class="stdForm" method="POST" name="privacysettingsform">
				<br>Allow Beerhopper to send you occasional emails?
				<select name="emailopt">
					<?php if ($AllowEmails) {
                 echo '<option selected value="yes">Yes</option>';
                 echo '<option value="no">No</option>';
             } else {
                 echo '<option selected value="no">No</option>';
                 echo '<option value="yes">Yes</option>';
             }?>
		 		</select>

				<br><br> Allow other users to search you via email?
				<select name="searchopt">
					<?php if ($AllowSearch) {
                 echo '<option selected value="yes">Yes</option>';
                 echo '<option value="no">No</option>';
             } else {
                 echo '<option selected value="no">No</option>';
                 echo '<option value="yes">Yes</option>';
             }?>
		 		</select>

				<br><br> Show location on profile
				<select name="showlocation">
					<?php if ($ShowLocation) {
                 echo '<option selected value="yes">Yes</option>';
                 echo '<option value="no">No</option>';
             } else {
                 echo '<option selected value="no">No</option>';
                 echo '<option value="yes">Yes</option>';
             }?>
		 		</select>

				<br><br> Opt out of personalized ads?
				<select name="personalizedads">
					<?php if ($PersonalizedAds) {
                 echo '<option selected value="yes">Yes</option>';
                 echo '<option value="no">No</option>';
             } else {
                 echo '<option selected value="no">No</option>';
                 echo '<option value="yes">Yes</option>';
             }?>
					<option value="etc">Sell my soul for all the loot</option>
				</select>

				<br><br><button type="submit" name="privacysettings">Comfirm</button>
			</form>

			<!-- initiate update of privacy settings -->
			<?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if a post request was found
                    if (isset($_POST['privacysettings'])) { // and it was from general settings
                        $EmailOpt = $_POST['emailopt']; // $EmailOpt gets emailopt
                        $SearchOpt = $_POST['searchopt']; // $SearchOpt gets searchopt
                        $ShowLocation = $_POST['showlocation']; // $Show location gets showlocation
                        $PersonalizedAds = $_POST['personalizedads']; // $PersonalizedAds gets personalizedads
                        $UserEmail = $_SESSION['signedInUser']; // $UserEmail assigned to singed in user

                        /* convert result to tiny int */
                        if ($EmailOpt == 'yes') {
                            $EmailOpt = 1;
                            echo "it's a yes";
                        } else {
                            $EmailOpt = 0;
                        }
                        /* convert result to tiny int */
                        if ($SearchOpt == 'yes') {
                            $SearchOpt = 1;
                        } else {
                            $SearchOpt = 0;
                        }
                        /* convert result to tiny int */
                        if ($ShowLocation == 'yes') {
                            $ShowLocation = 1;
                        } else {
                            $ShowLocation = 0;
                        }
                        /* convert result to tiny int */
                        if ($PersonalizedAds == 'yes') {
                            $PersonalizedAds = 1;
                        } else {
                            $PersonalizedAds = 0;
                        }

                        /* actually update the privacy settings */
                        if ($NotInTable) {
                            echo '<br>NOT IN TABLE<br>';
                            $CreatePrivacySettings = "INSERT INTO PrivacySettings (AllowEmails, AllowSearch, ShowLocation, PersonalizedAds, UserEmail)
						        VALUES ('" .$EmailOpt."','".$SearchOpt."','".$ShowLocation."','".$PersonalizedAds."','".$UserEmail."')";
                        } else {
                            echo '<br>IN TABLE<br>';
                            $UpdatePrivacySettings = "UPDATE PrivacySettings Set AllowEmails = '".$EmailOpt."', AllowSearch = '".$SearchOpt."', ShowLocation = '".$ShowLocation."', PersonalizedAds = '".$PersonalizedAds."' WHERE UserEmail = '".$UserEmail."'"; // get update statement
                        }
                        if (mysqli_query($connection, $UpdatePrivacySettings) || mysqli_query($connection, $CreatePrivacySettings)) {
                            echo 'Records updated<br>';
                            /* refresh parent page */
                            echo '<script type="text/javascript"> top.window.location.href = "../html/profilePage.php";</script>';
                        } else {
                            echo '<br><br><br>';
                            echo "$UpdatePrivacySettings";
                            echo 'ERORRRR';
                        }
                    }
                }
            ?>
		</div>

		<h3> My Breweries: </h3><!-- header for my breweries -->
		<div class="mybreweries"><br> <!-- my breweries class -->
			<?php
                /*Get brewery owner info */
                $GetBreweryOwnerQuery = "SELECT * FROM BreweryOwner WHERE UserEmail='".$_SESSION['signedInUser']."'"; // get brewery owner info query
                $BreweriesOwned = array();
                $BreweryNames = array();
                $BreweryStories = array();
                $BreweriesHours = array();
                $BreweryPhoneNumbers = array();
                $BreweryOwner = mysqli_query($connection, $GetBreweryOwnerQuery); // get brewery owner info
                if ($BreweryOwner->num_rows > 0) { // if there are results
                    while ($row = mysqli_fetch_assoc($BreweryOwner)) {
                        $OwnerID = $row['OwnerID']; // OwnerID = OwnerID
                        $UserEmail = $row['UserEmail']; // UserEmail = UserEmail
                        $BreweryID = $row['BreweryID']; // BreweryID = BreweryID
                        array_push($BreweriesOwned, $BreweryID);
                    }

                    foreach ($BreweriesOwned as $key) {
                        /* get brewery information */
                        $GetBreweryInformation = "SELECT * FROM BreweryTable WHERE BreweryID='".$key."'"; // Breweryinfo query
                        $BreweryInfo = mysqli_query($connection, $GetBreweryInformation); // brewery info
                        if ($BreweryOwner->num_rows > 0) { // if there are results
                            while ($row = mysqli_fetch_assoc($BreweryInfo)) {
                                $BreweryNames[] = $row['BreweryName']; // push BreweryName to BreweryNames array
                                $BreweryStories[] = html_entity_decode(removeBR($row['About'])); // push Brewery About to BreweryStories array
                                $BreweriesHours[] = html_entity_decode(removeBR($row['Hours'])); // push Brewery Hours to BreweryHours array
                                $BreweryPhoneNumbers[] = $row['PhoneNo']; // push Brewery PhoneNums to PhoneNum array
                            }
                        }
                    }
                    $BreweryChoice = 0; // inialize brewerychoice to 0
                    if (count($BreweryNames) > 1) { // if the owner has > 1 brewery
                        /* Brewery Selection */
                        unset($value); // reset value
                        echo '<form method="POST" id="breweryselection" name="breweryselection">'; // form to choose brewery
                        echo '<select name="Brewery" onchange="this.form.submit()">'; // onchange submit
                        echo '<option selected value="">Choose Brewery</option>';
                        foreach ($BreweryNames as $key => $value): // for each brewery name gets value
                        echo '<option value="'.$key.'">'.$value.'</option>'; // value becomes option for select
                        endforeach; // end for each
                        echo '</select><br>'; // end select
                        echo '</form>'; // end form

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if a post request was found
                        if (isset($_POST['Brewery'])) { // and it was from the brewery select
                            $BreweryChoice = $_POST['Brewery']; // brewerychoice becomes new brewerychoice
                        } else {
                        }
                        }
                    }

                    /* Brewery settings form */
                    echo '<div class="brewerysettings"></div>';
                    echo "<h3 id='displaybreweryname'>$BreweryNames[$BreweryChoice]</h3>";
                    echo '<form class="stdForm" method="POST" name="brewerysettingsform">';
                    echo "<input type='hidden' value='$BreweriesOwned[$BreweryChoice]' name='breweryid'>";
                    echo '<div class="PhoneNumber"><p>Brewery Phone Number:<br>';
                    echo "<input class='PhoneNumber' type='tel' name='phonenumber' value='$BreweryPhoneNumbers[$BreweryChoice]'></p>";
                    echo '</div>';
                    echo '<div class="BreweryHours"><p>Brewery Hours:<br>';
                    echo "<textarea rows ='' id='breweryhours' name='breweryhours'>$BreweriesHours[$BreweryChoice]</textarea></p>";
                    echo '</div>';
                    echo '<div class="BreweryStory"><p>Brewery Story:<br>';
                    echo "<textarea id='brewerystory' name='brewerystory'>$BreweryStories[$BreweryChoice]</textarea></p>";
                    echo '</div>';
                    echo '<br><button class="submitbrewerysettings" type="submit" name="brewerysettings">Confirm</button>';
                    echo '</form>';
                } else { // the user has no breweries
                    echo 'You do not have any breweries'; // Output the user does not have a brewery
                }
                echo "<p><br><br><button type='submit' onclick='location.href=\"BrewerySignUp.php\"'>Add Brewery</button></p>";
            ?>
			<?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if a post request was found
                    if (isset($_POST['brewerysettings'])) { // and it was from general settings
                        $BreweryHours = $_POST['breweryhours']; // $BreweryHours = new breweryhours
                        $BreweryPhoneNum = $_POST['phonenumber']; // $BreweryPhoneNum = new phonenumber
                        $BreweryStory = $_POST['brewerystory']; // $BreweryStory = new brewerystory
                        $BreweryID = $_POST['breweryid'];

                        $updateBreweryInfo = "UPDATE BreweryTable Set Hours = '".nl2br(htmlentities($BreweryHours, ENT_QUOTES), false)."', PhoneNo = '".$BreweryPhoneNum."', About = '".nl2br(htmlentities($BreweryStory, ENT_QUOTES), false)."' WHERE BreweryID = '".$BreweryID."'"; // get update statement
                        if (mysqli_query($connection, $updateBreweryInfo)) {
                            echo '<br><br>Records updated<br>';
                            /* refresh parent page */
                            echo '<script type="text/javascript"> top.window.location.href = "../html/profilePage.php";</script>';
                        } else {
                            echo '<br>';
                            echo "$updateBreweryInfo";
                            echo 'ERORRRR';
                        }
                    }
                }
             ?>
			</div><!-- end my breweries -->
	</div>
</body>

</html>
