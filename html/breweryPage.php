<!DOCTYPE html>

<!--
*	@Author:							Justin Goulet
* @Date-Last-Modified:	November 23, 2016
* @Date-Created:				September 1, 2016
*	@Purpose:							To show a particular brewery's main page
*	@Method:							Using the passed in breweryID, from GET, we are
*												going to to load the current brewery information into a
*												pre-laid out page. This includes the brewery's profile picture,
*												cover picture, beer list, followers and list of those that
*												it is following. Users can interact with each element to learn more.
-->

<html lang="en-us">

<head>
	<meta charset="utf-8">
	<!-- Link documents to style sheet and JS code -->
	<link rel="stylesheet" href="../css/masterPage.css" type="text/css">
	<link rel="stylesheet" href="../css/menu.css" type="text/css">
	<link rel="stylesheet" href="../css/backgroundVideo.css" type="text/css">
	<link rel="stylesheet" href="../css/ProfileContainer.css" type="text/css">
	<link rel="stylesheet" href="../css/updateStatus.css" type="text/css">
	<link rel="stylesheet" href="../css/breweryPage.css" type="text/css">
	<!--<link rel="stylesheet" href="../css/address.css" type="text/css">
	<link rel="stylesheet" href="../css/hours.css" type="text/css">
	<link rel="stylesheet" href="../css/message.css" type="text/css">-->

  <script src="../js/NewsFeedBuilder.js"></script>
	<script src="../js/contentSwitch.js"></script>

	<!-- Set title of page -->
	<title>Brewery Page</title>


	<!-- Analytics Script -->
	<script src="../js/analytics.js"></script>


	<!-- For the background image -->
	<div class="is_overlay">
		<img src="http://beerhopper.me/img/bckImg.jpg" alt="Background img">
	</div>



</head>

<?php
<<<<<<< HEAD
		//Import needed PHP files
		include "../php/create_table.php";
  	//Start the session
	  session_start();
		 $id= $_GET['id'];
	  //Get the token to prove the user was logged in
	  if(strlen($_SESSION['loginToken']) == 0){
		  //redirect to the login page
		  header("Location: ../index.php");
	  }else{
		  //echo "<p style=\"color:white\">You rock: " . $_GET['id'] . "<br></p>";
	  }

	  	//Connect to the DB
	 	$connection = include '../php/DBConnectionReturn.php';

	  //Start the SQL Query to get the brewery information
	  $getBreweryInfoQuery = "SELECT BreweryName, ProfilePicURL, CoverPicURL, CONCAT(l.City, ', ', l.State) AS City, visits FROM BreweryTable b, BreweryLocation l WHERE b.breweryID = l.breweryID AND b.breweryID=" . $_GET['id'];
	  $getBreweryInnfoResults = mysqli_query($connection, $getBreweryInfoQuery);

		//Get current user info
		$signedInUser = $_SESSION['signedInUser'];
		//Get breweries that user is following
		$signedInUserBreweriesQuery = "SELECT * FROM UserFollowsBrewery WHERE UserEmail='" . $signedInUser . "' AND BreweryID=" . $_GET['id'];
		$signedInUserBreweriesResults = mysqli_query($connection, $signedInUserBreweriesQuery);

		//Check to see if user has favorited brewery
		if ($signedInUserBreweriesResults-> num_rows == 0){
			//Is not following
			$following = 'n';
			$followText = "Follow";
			$followingImage = "../img/Follow.png?raw=true";
		} else {
			$following = 'y';
			$followText = "UnFollow";
			$followingImage = "../img/Unfollow_Follow_Color.png?raw=true";
		}
	  //Check to see if the brewery exists, should only be one result
	  if($getBreweryInnfoResults-> num_rows > 0){
		  //If the brewery exists, get the info
		  while($row = mysqli_fetch_assoc($getBreweryInnfoResults)){
			//echo "<p style=\"color:white;\">Hello World</p>";

			  //Save the values
			  $BreweryName = $row['BreweryName'];
			  $ProfilePicURL = $row['ProfilePicURL'];
			  $CoverPicURL = $row['CoverPicURL'];
			  $City = $row['City'];
				$Visits = $row['visits'] + 1;

			  //If the cover pic does not exist, set it to the default
				if(empty($CoverPicURL)){
					$CoverPicURL = "../img/DefaultCoverImage.png";
				}
		  }

			//Free the results
			mysqli_free_result($getBreweryInnfoResults);
	  }else{
		  //DNE Exist (Show page not found)
		  header("Location: ./PageNotFound.html?breweryID=" . $_GET['id']);
	  }

		//Now, increment the visit count of said brewery
		$UpdateVisits = "UPDATE BreweryTable SET visits=visits+1 WHERE breweryID=" . $_GET['id'];
		if(mysqli_query($connection, $UpdateVisits)){
			//Success
		}else{
			echo "Error With Query: " . mysqli_error($connection);
		}
=======
        //Import needed PHP files
        include '../php/create_table.php';
    //Start the session
      session_start();
         $id = $_GET['id'];
      //Get the token to prove the user was logged in
      if (strlen($_SESSION['loginToken']) == 0) {
          //redirect to the login page
          header('Location: ../index.php');
      } else {
          //echo "<p style=\"color:white\">You rock: " . $_GET['id'] . "<br></p>";
      }

        //Connect to the DB
        $connection = include '../php/DBConnectionReturn.php';

      //Start the SQL Query to get the brewery information
      $getBreweryInfoQuery = "SELECT BreweryName, ProfilePicURL, CoverPicURL, CONCAT(l.City, ', ', l.State) AS City, visits FROM BreweryTable b, BreweryLocation l WHERE b.breweryID = l.breweryID AND b.breweryID=".$_GET['id'];
      $getBreweryInnfoResults = mysqli_query($connection, $getBreweryInfoQuery);

      //Check to see if the brewery exists, should only be one result
      if ($getBreweryInnfoResults->num_rows > 0) {
          //If the brewery exists, get the info
          while ($row = mysqli_fetch_assoc($getBreweryInnfoResults)) {
              //echo "<p style=\"color:white;\">Hello World</p>";

              //Save the values
              $BreweryName = $row['BreweryName'];
              $ProfilePicURL = $row['ProfilePicURL'];
              $CoverPicURL = $row['CoverPicURL'];
              $City = $row['City'];
              $Visits = $row['visits'] + 1;

              //If the cover pic does not exist, set it to the default
                if (empty($CoverPicURL)) {
                    $CoverPicURL = '../img/DefaultCoverImage.png';
                }
          }

            //Free the results
            mysqli_free_result($getBreweryInnfoResults);
      } else {
          //DNE Exist (Show page not found)
          header('Location: ./PageNotFound.html?breweryID='.$_GET['id']);
      }

        //Now, increment the visit count of said brewery
        $UpdateVisits = 'UPDATE BreweryTable SET visits=visits+1 WHERE breweryID='.$_GET['id'];
        if (mysqli_query($connection, $UpdateVisits)) {
            //Success
        } else {
            echo 'Error With Query: '.mysqli_error($connection);
        }
>>>>>>> master

  ?>

<body>
	<!-- onload="buildFeed();" -->
	<!-- Header for Logo -->
	<header class="header">
		<a href="../html/profilePage.php">
			<img class="logo" id="logo" alt="Beer Hopper Logo" src="../img/Beer_Hopper_Banner.png?raw=true">
		</a>

	</header>

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
			<form action="return false;" onsubmit="return false;" class="searchForm">
				<label class="hidden">Enter Search Terms here </label>
				<input type="text" placeholder="Search" id="searchText" name="query" class="textSearch">
				<label class="hidden"> Search Field </label>
				<input type="image" id="searchBtn" src="../img/location_filled.png?raw=true" class="searchButton" onclick="startSearch()" alt="search">
			</form>
	</nav>

	<!--Left side bar; will be profile information -->
	<aside class="left">

		<div id="profileContainer">
			<!-- Three items will appear here... Pic, Name and Edit Button -->
			<img class="profileImg" id="profileImg" src="<?php echo $ProfilePicURL; ?>" alt="<?php echo $BreweryName; ?>" onclick="showSRC<?php echo "('editBrewProfPic.php?id=$id')"; ?>">
			<p class="profileName" onclick="showSRC<?php echo "('editBreweryName.php?id=$id')"; ?>"><?php echo $BreweryName; ?><br></p>
			<p class="breweryLocation"><?php echo $City; ?>
				<br></p>
		</div>

		<div class="subsection">
			<!-- About Section -->
			<div class="stdSection about" id="aboutSection">
				<div class="stdSectionTitle">
					About
				</div>
				<div class="table">
					<?php $BreweryID = $_GET['id']; ?>
					<div class="smalltableCell">
						<a onclick="showSRC<?php echo "('Hours.php?id=$BreweryID')" ?>">
							<!-- hours -->
							<div class="tableCell img">
								<img class="smalltableCell" src="../img/time.png?raw=true" alt="Hours Icon">
							</div>
							<div class="smalltableCell title">
								Hours
							</div>
						</a>
					</div>
					<div class="smalltableCell">
						<a onclick="showSRC('EmptyForm.html')">
							<div class="tableCell img">
								<img class="smalltableCell" src="../img/story.png?raw=true" alt="Story Icon">
							</div>
							<div class="smalltableCell title">
								Story
							</div>
						</a>
					</div>
					<div class="smalltableCell">
						<a onclick="showSRC<?php echo "('Address.php?id=$BreweryID')" ?>">
							<!-- address -->
							<div class="tableCell img">
								<img class="smalltableCell" src="../img/location.png?raw=true" alt="Address Icon">
							</div>
							<div class="smalltableCell title">
								Address
							</div>
						</a>
					</div>
					<div class="smalltableCell">
						<a href="BeerList.html" onclick="showSRC('BeerList.html');return false;resizeIframeBeerList(this);">
							<div class="tableCell img">
								<img class="smalltableCell" src="../img/Beer.png?raw=true" alt="Beers Icon">
							</div>
							<div class="smalltableCell title">
								Beers
							</div>
						</a>
					</div>

					<!-- following button old
					<div class="smalltableCell">
						<a onclick="showSRC('FollowingPage.php')">
							<div class="tableCell img">
								<img class="smalltableCell" src="../img/Follow.png?raw=true" alt="Follow Icon">
							</div>
							<div class="smalltableCell title">
								Follow
							</div>
						</a>
					</div>
					end following button old-->

					<div class="smalltableCell">
						<form action="" class="stdForm" method="POST" name="followBrew">
							<button type="submit" class="defaultSetBtn" name="followBrew" style="padding-top:-10px;">
								<div class="tableCell img">";
									<img class="smalltableCell" src="<?php echo $followingImage ?>" alt="<?php echo $followText ?>">
								</div>
								<div class="smalltableCell title" style="padding-top:20px; padding-bottom:15px; max-height:50px"> <?php echo $followText ?> </div>
							</button>
							<input type="hidden" value="" name="<?php echo strtr($_GET['id'], array('.' => '#-#')) ?>">
						</form>
					</div>

					<div class="smalltableCell">
						<a onclick="showSRC('message.html')">
							<!-- message -->
							<div class="tableCell img">
								<img class="smalltableCell" src="../img/message.png?raw=true" alt="Message">
							</div>
							<div class="smalltableCell title">
								Message
							</div>
						</a>
					</div>
				</div>
			</div>

			<!-- Followers Section -->
			<!--
			<div class="stdSection FollowingBrewery" id="followersOfBreweries">
				<div class="stdSectionTitle">
					Brewery Followers
				</div>
				<div class="table"> -->
					<!-- Brewery Following Brewery -->
<<<<<<< HEAD
					<!--<
						//$query = "SELECT DISTINCT b.OtherBreweryID AS BreweryID, ob.ProfilePicURL, ob.BreweryName FROM BreweryFollowsBrewery b, BreweryTable ob WHERE ob.BreweryID = b.OtherBreweryID AND b.BreweryID=" . $_GET['id'] . "LIMIT 6";
						//$resultSet = mysqli_query($connection, $query);
=======
					<!--<?php
                        //$query = "SELECT DISTINCT b.OtherBreweryID AS BreweryID, ob.ProfilePicURL, ob.BreweryName FROM BreweryFollowsBrewery b, BreweryTable ob WHERE ob.BreweryID = b.OtherBreweryID AND b.BreweryID=" . $_GET['id'] . "LIMIT 6";
                        //$resultSet = mysqli_query($connection, $query);
>>>>>>> master

                        //Create a basic form
                        //createBasicForm($resultSet, 'BreweryID', 'ProfilePicURL', 'BreweryName', 'brewery');

<<<<<<< HEAD
						//Free results
						//if($resultSet) mysqli_free_result($resultSet);
=======
                        //Free results
                        i//f($resultSet) mysqli_free_result($resultSet);
>>>>>>> master

                    ?>-->
				<!--</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('FollowingPage.php')" class="moreClicked">more</a>
				</div>
			</div>-->

						<!-- Total visit count. Increments on each page visit/refresh -->
						<div class="stdSection Calendar" id="calendar">
							<div class="stdSectionTitle">
								Total Visits
									<div class="numberOfVisits"><?php echo number_format($Visits); ?></div>
							</div>
						</div>
		</div>
	</aside>

	<!-- Right Side bar; will be used for side navigation panels -->
	<aside class="right">
		<div class="subsection">

			<div class="stdSection FollowingBreweries" id="followingBreweries">
				<div class="stdSectionTitle">
					Following
				</div>
				<div class="table">
					<?php
                        //Build the table
                        $GetWhoBreweryIsFollowing = 'SELECT DISTINCT b.OtherBreweryID AS BreweryID, ob.ProfilePicURL, ob.BreweryName FROM BreweryFollowsBrewery b, BreweryTable ob WHERE ob.BreweryID = b.OtherBreweryID AND b.BreweryID='.$_GET['id'].' LIMIT 6';
                        $GetWhoBreweryIsFollowingResults = mysqli_query($connection, $GetWhoBreweryIsFollowing);

                        createBasicForm($GetWhoBreweryIsFollowingResults, 'BreweryID', 'ProfilePicURL', 'BreweryName', 'brewery');

                        //Free the results
                        if ($GetWhoBreweryIsFollowingResults) {
                            mysqli_free_result($GetWhoBreweryIsFollowingResults);
                        }
                    ?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('FollowingPage.php')" class="moreClicked">more</a>
				</div>
			</div>

			<!-- Beers on tap -->
			<div class="stdSection main" id="highestRated">
				<div class="stdSectionTitle">
					Beers On Tap
				</div>
				<div class="table">
					<?php
                        $getFavoritedBeersQuery = "SELECT DISTINCT BeerID, BeerName, PictureURL FROM Beers WHERE OnTap='T' AND  BreweryID = ".$_GET['id'].' LIMIT 6';
                        $favoritedBeersResults = mysqli_query($connection, $getFavoritedBeersQuery);

                        createClickableTable($favoritedBeersResults, 'BeerID', 'PictureURL', 'BeerName');

                        //Free results
                        mysqli_free_result($favoritedBeersResults);

                    ?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('BeerList.html')" class="moreClicked">more</a>
				</div>
			</div>
			<!-- Followers Section -->
			<div class="stdSection FollowingBrewery" id="followersOfBreweries">
				<div class="stdSectionTitle">
					User Followers
				</div>
				<div class="table">
					<!-- User Following Brewery -->
					<?php
                        $GetUsersFollowingBrewery = "SELECT u.ProfilePicURL, CONCAT(u.FName, '<br>', u.LName) AS Name, u.Email FROM Users u, UserFollowsBrewery ufb WHERE u.Email = ufb.UserEmail AND ufb.BreweryID=".$_GET['id'].' LIMIT 6';
                        $GetUsersFollowingBreweryResults = mysqli_query($connection, $GetUsersFollowingBrewery);

                        //Create a basic form
                        if ($GetUsersFollowingBreweryResults) {
                            createBasicForm($GetUsersFollowingBreweryResults, 'Email', 'ProfilePicURL', 'Name', 'user');
                        }

                        //Clear the results
                        if ($GetUsersFollowingBreweryResults) {
                            mysqli_free_result($GetUsersFollowingBreweryResults);
                        }

                        //Close the sql connection
                        $connection->close();
                    ?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('FollowingPage.php')" class="moreClicked">more</a>
				</div>
			</div>

		</div>
	</aside>

	<!-- Main content area -->
	<section class="breweryPage">
		<!-- Display the brewery's cover image -->
		<div>
			<img alt="Brewery Cover Image" id="coverImage" src="<?php echo $CoverPicURL; ?>" onclick="showSRC<?php echo "('editCoverPicture.php?id=$id')"; ?>">
		</div>

		<div class="breweryPage newsFeed">
			<!-- For example purposes, add the add brewery panel -->
			<iframe id="contentFrame" src="../html/NewsFeed.html" style="min-width:480px" title="subframe" onload="resizeIframe(this);"></iframe>
			<div class="newsFeed" id="MainArea"></div>

		</div>

	</section>

	<!-- Footer information; additional links etc -->
	<?php
<<<<<<< HEAD
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
								//Check which form was ssent then get the appropriate id.
    						if(isset($_POST['brewery'])){
							  	//Navigate to the brewery page iwth the new id
							  	echo "<script type=\"text/javascript\"> document.location.href = \"breweryPage.php?id=" . end(array_keys($_POST)) . "\";</script>";
    						}
    						else if(isset($_POST['followBrew'])){
								//User is going to follow the brewery
								if($following == 'y'){
									//If the user is currently following the brewery, unfollow it and change the image
									$DeleteQuery = "DELETE FROM UserFollowsBrewery WHERE UserEmail='" . $_SESSION['signedInUser'] . "' AND BreweryID=$id";
									if(mysqli_query($connection, $DeleteQuery)){
										//Success
										$followText = "Follow";
										$followingImage = "../img/Follow.png?raw=true";
									}else{
										die("Error: " . mysqli_error($connection));
									}
								}else{
									//If the user is not following the user, follow it and change the image.
									$addQuery = "INSERT INTO UserFollowsBrewery (UserEmail, BreweryID) VALUES ($signedInUser, $id)";
									if(mysqli_query($connection, $addQuery)){
										$followText = "UnFollow";
										$followingImage = "../img/Unfollow_Follow_Color.png?raw=true";
									} else{
										die("Error: " . mysqli_error($connection));
									}
								}
							}
    						else {
							    $_SESSION['currentUser'] = strtr(end(array_keys($_POST)), array('#-#' => '.'));
									echo "<script type=\"text/javascript\"> document.location.href = \"profilePage.php\";</script>";
						    }

								//Ends the current session
								session_write_close();
					}
		?>
=======
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Check which form was ssent then get the appropriate id.
                            if (isset($_POST['brewery'])) {
                                //Navigate to the brewery page iwth the new id
                                echo '<script type="text/javascript"> document.location.href = "breweryPage.php?id='.end(array_keys($_POST)).'";</script>';
                            } else {
                                $_SESSION['currentUser'] = strtr(end(array_keys($_POST)), array('#-#' => '.'));
                                echo '<script type="text/javascript"> document.location.href = "profilePage.php";</script>';
                            }

                                //Ends the current session
                                session_write_close();
            }
        ?>
>>>>>>> master

</body>

</html>
