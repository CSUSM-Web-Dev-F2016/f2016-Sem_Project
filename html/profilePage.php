<!DOCTYPE html>

<!--
*	@Author:							Justin Goulet
* @Date-Last-Modified:	November 23, 2016
* @Date-Created:				September 1, 2016
*	@Purpose:							To show a particular person's main profile page
*	@Method:							Using the user's login credentials, this page is first loaded
*												with their content. This includes their profile picture,
*												name, and other identifying information, a table of a user's
*												favorite beers, a table of all who is following the current
*												user, and who the user is currently following.
*												When the user views another's profile, they are shown their profile picture,
*												their name, their favorite beers, who is following them, and
*												who they are following. No privacy settings are set yet.
*												Differnt from a signed in users page, the current user have the option to
*												follow the user or sent them a message.
*
-->
<html lang="en-us">
<head>
		<!-- Import CSS Files -->
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/masterPage.css" type="text/css">
		<link rel="stylesheet" href="../css/menu.css" type="text/css">
		<link rel="stylesheet" href="../css/backgroundVideo.css" type="text/css">
		<link rel="stylesheet" href="../css/ProfileContainer.css" type="text/css">
		<link rel="stylesheet" href="../css/updateStatus.css" type="text/css">
		<link rel="stylesheet" href="../css/calendarview.css" type="text/css">
		<!-- Import JS Files -->
		<script src="../js/contentSwitch.js"></script>
		<script src="../js/analytics.js"></script>
		<link rel="shortcut icon" href="../img/Empty_Glass.png"/>

		<?php
	  	//Start the session
		  session_start();

			//Get the token to prove the user was logged in
		  if(strlen($_SESSION['loginToken']) == 0){
				//redirect to the login page
		 		header("Location: ../index.php");
			}
			else{
				//e	cho "<p>You rock";
			}
			?>
		<!-- Navigation Bar -->
		<nav>
			<table class="menu" title="Menu">
				<tbody>
					<tr>
						<!-- Main Profile Page -->
						<th class="menuItem" title="Home">
							<input type="image" id="homeBtn" src="../img/House.png?raw=true" class="navBtn" onclick="javascript:location.href='../index.php'" alt="home">
						</th>
						<th>|</th>
						<!-- Settings -->
						<th class="menuItem" title="Settings">
							<input type="image" id="settingsBtn" src="../img/gear.png?raw=true" class="navBtn" onclick="showSRC('Settings.php')" alt="home">
						</th>
						<th>|</th>
						<!-- Logout Button -->
						<th class="menuItem" title="Logout">
							<input type="image" id="logoutBtn" src="../img/logout.png?raw=true" class="navBtn" onclick="logout()" alt="home">
						</th>
					</tr>
				</tbody>
			</table>

			<!-- Add a search bar in the top left -->
			<form action="return false;" onsubmit="return false;" method="POST" class="searchForm">
				<label class="hidden">Enter Search Terms here </label>
				<input type="text" placeholder="Search" id="searchText" name="query" class="textSearch">
				<label class="hidden"> Search Field </label>
				<input type="image" id="searchBtn" src="../img/location_filled.png?raw=true" class="searchButton" onclick="startSearch()" alt="search">
			</form>
		</nav>

		<!-- Meta data -->
		<title>Profile</title>
		<!-- For the background image -->
		<div class="is_overlay">
			<img src="http://beerhopper.me/img/bckImg.jpg" alt="Background img">
		</div>
</head>
<?php

	//Import needed PHP files
	include "../php/create_table.php";
	include "../php/LogEvent.php";

	//Create a basic connection
	$connection = include '../php/DBConnectionReturn.php';

	$FName = $LName = $PicURL = $CurrentUser = "";

	//Use already provided var
	$CurrentUser = $_SESSION['currentUser'];

	//Get the user's information
	$GetUserInformationQuery = "SELECT * FROM Users WHERE Email='" . $CurrentUser . "'";
	$userInfoResults = mysqli_query($connection, $GetUserInformationQuery);

	//Check to see if exists (it should since we already logged in)
	if($userInfoResults-> num_rows > 0){
		while($row = mysqli_fetch_assoc($userInfoResults)){
			$FName = $row["FName"];
			$LName = $row["LName"];
			$PicURL = $row["ProfilePicURL"];
			//$visits = $row['visits'];

			break; //Only want the first occurance
		}
		//Get the unique visits
		$UniqueVisits = "SELECT DISTINCT uvb.UserEmail, COUNT(*) AS visits FROM UserVisitsUser uvb WHERE uvb.OtherUserEmail='" . $_SESSION['currentUser'] . "' GROUP BY uvb.UserEmail";
		$visitsResult = mysqli_query($connection, $UniqueVisits);
		if($visitsResult->num_rows > 0){
			while (mysqli_fetch_assoc($visitsResult)) {
				$Visits++;
			}
		}else{
			$Visits = 0;
		}

		//Unset the results
		mysqli_free_result($userInfoResults);

		//Now, we need to see, if the user is different, if the user is following the current user
		if($_SESSION['signedInUser'] != $_SESSION['currentUser']){
			//If the user is not the same as the signed in user, see if the user is following the current user
			$getIsFollowing = "SELECT COUNT(*) AS Count FROM UserFollowsUser WHERE UserEmail='" . $_SESSION['signedInUser'] . "' AND OtherUserEmail='" . $_SESSION['currentUser'] . "'";
			$resultsIfFollowing = mysqli_query($connection, $getIsFollowing);

			if($resultsIfFollowing->num_rows > 0){
				//is following
				while($row = mysqli_fetch_assoc($resultsIfFollowing)){
					if($row['Count'] >= 1){
						$following = 'y';
						$followText = "UnFollow";
						$followingImage = "../img/Unfollow_Follow_Color.png?raw=true";
					}else{
						//Is not following
						$following = 'n';
						$followText = "Follow";
						$followingImage = "../img/Follow.png?raw=true";
					}
					break;
				}
			}else{
				die("Error: " . mysqli_error($connection));
			}

			//Free the results
			mysqli_free_result($resultsIfFollowing);
		}

	}else{
		//err
	}
	//echo "<script type=\"text/javascript\">window.alert(\"User Found: " . $CurrentUser . " FNAME: " . $FName . " LNAME: " . $LName . "\");</script>";
?>
<body>

		<!-- Header Bar -->
		<div class="header">
			<img class="logo" src="../img/Beer_Hopper_Banner.png" alt="Beer Hopper Logo">
		</div>

	<!-- Profile Container -->
	<div class="ProfileContainer">
		<!-- Within the container, we have a rounded profile image -->
		<img src="<?php echo $PicURL ?>" alt="Profile Picture" id="profileImg" class="profileImage" onclick="showSRC('editProfilePicture.php')">
		<br>
		<hr>
		<p class="profileName"><?php echo $FName . " " . $LName?></p>
		<a class="editBtn" onclick="showSRC('editName.php')">Edit</a>
	</div>
	<!-- Left Section -->
	<aside class="left">
		<div class="subsection">
			<?php
			if($_SESSION['signedInUser'] != $CurrentUser){
				?>
			<div class="stdSection" id="About">
				<div class="stdSectionTitle">
				Info
				</div>
				<div class="table">
					<!-- Create a basic form to handle the follow button -->
					<form action="" class="stdForm" method="POST" name="follow">
            <button type="submit" class="defaultSetBtn" name="follow" style="padding-top:-10px;">
              <div class="tableCell img">";
                <img class="smalltableCell" src="<?php echo $followingImage ?>" alt="<?php echo $followText ?>">
              </div>
              <div class="smalltableCell title" style="padding-top:20px; padding-bottom:15px; max-height:50px"> <?php echo $followText ?> </div>
            </button>
            <input type="hidden" value="" name="<?php echo strtr($_SESSION['currentUser'], array('.' => '#-#')); ?>">
          </form>
					</div>
			</div>
		<?php
		//Now, update the visit count of this user
		$updateUserCount = "INSERT INTO UserVisitsUser VALUES (NULL, '" . $_SESSION['signedInUser'] . "', '" . $_SESSION['currentUser'] . "')";
		if(mysqli_query($connection, $updateUserCount)){
			//Update was handled
		}else{
			echo "Not updated: " . mysqli_error($connection);
		}

	}?>

	<!-- Total visit count. Increments on each page visit/refresh -->
	<div class="stdSection" id="calendar">
		<div class="stdSectionTitle">
			Total Unique Visits
				<div class="numberOfVisits"><?php echo number_format($Visits); ?></div>
		</div>
	</div>

			<div class="stdSection" id="bestTastes">
				<div class="stdSectionTitle">
					Best Tastes
				</div>
				<div class="table">

					<!-- Get Favorited beers for this user -->
					<?php
						$getFavoritedBeersQuery = "SELECT DISTINCT u.BeerID, b.PictureURL, b.BeerName FROM UserFavoritesBeer u, Beers b WHERE u.UserEmail='" . $CurrentUser . "' AND b.BeerID=u.BeerID ORDER BY b.BeerName LIMIT 6";
						$favoritedBeersResults = mysqli_query($connection, $getFavoritedBeersQuery);

						//Create a basic clickable table
						if($favoritedBeersResults) createClickableTable($favoritedBeersResults, 'BeerID', 'PictureURL', 'BeerName');

						//Free the results
						if($favoritedBeersResults) mysqli_free_result($favoritedBeersResults);
					?>
				</div>
				<div class="stdSectionFooter">
					<a href="#" onclick="showSRC('BestTastes.php');return false;" class="moreClicked">more</a>
				</div>
			</div>
		<div class="stdSection" id="eventCalendar">
			<div class="stdSectionTitle">
				Today's Date is:
					<div class="numberOfVisits"><?php echo date("d"); ?></div>
					<div class="stdSectionFooter"><?php  echo date("l\,<br> F Y");?> </div>
			</div>
		</div>
		</div>
	</aside>
	<!-- Right Section -->
	<aside class="right">
		<div class="subsection">
			<div class="stdSection" id="followers">
				<div class="stdSectionTitle">
					Following Me
				</div>
				<div class="table">
					<!-- User 'Following me' -->
					<?php
					$getUsersFollowingMeQuery = "SELECT DISTINCT u.UserEmail, u.OtherUserEmail, them.ProfilePicURL, CONCAT(them.`FName`, '<br>', them.`LName`) AS 'Name', them.LName FROM UserFollowsUser u, Users p, Users them WHERE u.OtherUserEmail=p.Email AND them.Email=u.UserEmail AND u.OtherUserEmail='" . $CurrentUser . "'ORDER BY them.LName LIMIT 3";
					$usersFollowingMeResult = mysqli_query($connection, $getUsersFollowingMeQuery);

					//Create a form to change the current page when clicked
					createBasicForm($usersFollowingMeResult, 'UserEmail', 'ProfilePicURL', 'Name', 'user');

					//Free the results
					if($usersFollowingMeResult) mysqli_free_result($usersFollowingMeResult);

					?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('FollowingPage.php')" class="moreClicked">more</a>
				</div>
			</div>
			<div class="stdSection" id="followingBreweries">
				<div class="stdSectionTitle">
					Following Breweries
				</div>
				<div class="table">

				<!-- Using PHP, build the table -->
				<?php
					//Session is already started
					//Get the breweryies the user is following, max 3
					$getBreweriesFollowing = "SELECT DISTINCT BreweryName, ProfilePicURL, b.BreweryID, u.UserEmail FROM BreweryTable b, UserFollowsBrewery u WHERE u.BreweryID = b.BreweryID AND u.UserEmail ='" . $CurrentUser . "' GROUP BY u.BreweryID ORDER BY BreweryName LIMIT 3";
					$breweriesFollowingResults = mysqli_query($connection, $getBreweriesFollowing);

					//If the rows are greater than 1, we can use them to build our table. If not, we need to put a notice to the user.
					if($breweriesFollowingResults) createBasicForm($breweriesFollowingResults, 'BreweryID', 'ProfilePicURL', 'BreweryName', 'brewery');

					//Free the results
					if($breweriesFollowingResults) mysqli_free_result($breweriesFollowingResults);

					/** Should work **/
					if($_SERVER['REQUEST_METHOD'] == 'POST'){

    						if(isset($_POST['brewery'])){
								  //redirect to the login page
								  $_SESSION['currentUser'] = $_SESSION['signedInUser'];
									CustomLog($connection, $_SESSION['signedInUser'], 'User Action', "User Visited BreweryID=" . end(array_keys($_POST)) . "");

							  //Navigate to the brewery page iwth the new id
							  	echo "<script type=\"text/javascript\"> document.location.href = \"breweryPage.php?id=" . end(array_keys($_POST)) . "\";</script>";

							}
							else if(isset($_POST['follow'])){
							    $_SESSION['currentUser'] = strtr(end(array_keys($_POST)), array('#-#' => '.'));

								//User is going to Follow the user$
								if($following == 'y'){
									//If the user is currently following the user, unfollow it and change the image
									$DeleteQuery = "DELETE FROM UserFollowsUser WHERE UserEmail='" . $_SESSION['signedInUser'] . "' AND OtherUserEmail='" . $_SESSION['currentUser'] . "'";
									if(mysqli_query($connection, $DeleteQuery)){
										//Success
										$followText = "Follow";
										$followingImage = "../img/Follow.png?raw=true";
										CustomLog($connection, $_SESSION['signedInUser'], 'User Comparison', "User Un-Followed " . $_SESSION['currentUser'] . "");
									}else{
										die("Error: " . mysqli_error($connection));
									}
								}else {
									//If the user is not following the user, follow it and change the image.
									$addQuery = "INSERT INTO UserFollowsUser (UserEmail, OtherUserEmail) VALUES ('" . $_SESSION['signedInUser'] . "', '" . $_SESSION['currentUser'] . "')";
									if(mysqli_query($connection, $addQuery)){
										$followText = "UnFollow";
										$followingImage = "../img/Unfollow_Follow_Color.png?raw=true";
										CustomLog($connection, $_SESSION['signedInUser'], 'User Comparison', "User Followed " . $_SESSION['currentUser'] . "");
									}
								}
								//Take the user back to their page by directing them to their page
								$_SESSION['currentUser'] = $_SESSION['signedInUser'];
								CustomLog($connection, $_SESSION['signedInUser'], 'User Action', "User went to homepage");

								echo "<script type=\"text/javascript\"> document.location.href = \"../index.php\";</script>";

							}
							else if(isset($_POST['user'])) {
							    $_SESSION['currentUser'] = strtr(end(array_keys($_POST)), array('#-#' => '.'));
									CustomLog($connection, $_SESSION['signedInUser'], 'User Visited', "" . $_SESSION['currentUser'] . "");
									echo "<script type=\"text/javascript\"> document.location.href = \"profilePage.php\";</script>";
						    }

								else if(isset($_POST['beerID'])) {
										//echo "<script type=\"text/javascript\"> window.alert(\"Found a Beer: " . $_POST['BeerID'] . "\");</script>";
										echo "<script type=\"text/javascript\"> window.location.href = \"../html/BeerInfo.php?BeerID=" . $_POST['beerID'] . "\";</script>";
								}
						 	else {

									//Get the text field value
									//$postText = "<script type=\"text/javascript\">document.getElementByID(\"postBox\").value;</script>";
									$postText = $_POST['postBox'];

									//Post to the DB then refresh the page
									$addPost = "INSERT INTO Post VALUES (NULL, '" . $_SESSION['signedInUser'] . "', UTC_TIMESTAMP(), '" .  htmlspecialchars($postText, ENT_QUOTES) . "', 1)";
									if(isset($postText) && strlen($postText) > 0){
										if( mysqli_query($connection, $addPost)){
										//Success
										CustomLog($connection, $_SESSION['signedInUser'], 'User Created Post', "No Post Text Available. Please See Post table.");

										}else{
											CustomLog($connection, $_SESSION['signedInUser'], 'User Post Failed', "Err: " . mysqli_error($connection));
											die("Error Creating new Post");
										}
									}
									//Reload the page
									echo "<script type=\"text/javascript\"> document.location.href = \"profilePage.php\";</script>";
								}

								//Ends the current session
								session_write_close();

								//Close the sql session
							 	$connection->close();

								exit();
					}

				?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('FollowingPage.php')" class="moreClicked">more</a>
				</div>
			</div>
			<div class="stdSection" id="followingUsers">
				<div class="stdSectionTitle">
					Following Users
				</div>
				<div class="table">
					<!-- User 'Following me' -->
					<?php
					$getUsersFollowingMeQuery = "	SELECT DISTINCT ufu.OtherUserEmail, u.ProfilePicURL, CONCAT(u.FName, '<br>', u.LName) AS Name, u.LName
					 															FROM UserFollowsUser ufu, Users u
																				WHERE u.Email=ufu.OtherUserEmail AND ufu.UserEmail='" . $_SESSION['currentUser'] . "' ORDER BY u.LName LIMIT 3";
					$usersFollowingMeResult = mysqli_query($connection, $getUsersFollowingMeQuery);

					//Create the table using the data
					if($usersFollowingMeResult) createBasicForm($usersFollowingMeResult, 'OtherUserEmail', 'ProfilePicURL', 'Name', 'user');

					//Free the results
					if($usersFollowingMeResult) mysqli_free_result($usersFollowingMeResult);

					?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('FollowingPage.php')" class="moreClicked">more</a>
				</div>
			</div>
		</div>
	</aside>
	<section>

		<?php
			//Get the current signed in users profile PictureURL
			$proPicQ = "SELECT ProfilePicURL FROM Users WHERE Email='" . $_SESSION['signedInUser'] . "'";
			$res = mysqli_query($connection, $proPicQ);

			if($res->num_rows > 0){
				while($row = mysqli_fetch_assoc($res)){
					$PicURL = $row['ProfilePicURL'];
					break;
				}
			}else{
				//Leave the profile pic the same
			}

		 ?>
		<div class="newsFeedHeader">
			Feed:
			<!-- Black Field to Post -->
			<div class="newsFeedBox">
				<img class="feedImg" id="feedImg" src="<?php echo $PicURL ?>" alt="Image in Feed">
				You:
				<hr/>
				<div class="feedTxt">
					<form action="" method="POST">
						<textarea id="postBox" wrap="soft" name="postBox" rows="3" value=""></textarea>
					  <button type="submit" value="Submit">Post</button>
					</form>
				</div>
				</div>
			<div class="newsFeed" id="MainArea">

			<!-- For example purposes, add the add brewery panel -->
			<iframe id="contentFrame" src="../html/NewsFeed.php" title="subcontent" style="width:100%;" onload="resizeIframe(this);"></iframe>
		</div>
		</div>
		<!-- Black Field to Post -->
	</section>
</body>
</html>
