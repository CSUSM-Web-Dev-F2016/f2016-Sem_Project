<!DOCTYPE html>
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
	<script src="../js/calendarview.js"></script>
	<!-- Analytics Script -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-83948702-3', 'auto');
  ga('send', 'pageview');
  <?php
  	//Start the session
	  session_start();

//Get the token to prove the user was logged in
	  if(strlen($_SESSION['loginToken']) == 0){
	//r	edirect to the login page
	 header("Location: ../index.php");
}
else{
	//e	cho "<p>You rock";
}
?>
</script>
	<!-- Header Bar -->
	<div class="header">
		<img class="logo" src="../img/Beer_Hopper_Banner.png" alt="Beer Hopper Logo">
	</div>
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
	 //Create a basic connection
    $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

//Check the connection
    if(mysqli_connect_errno()){
	die("Connection Failed. ERR: " . mysqli_connect_error());
}
//echo "Connected Successfully";
//This code currently works :)

$FName = $LName = $PicURL = $CurrentUser = "";

//Get the curent var from the URL
/*if(isset($_POST['user'])){
	$CurrentUser = $_POST['user'];
}else{*/
	//Use already provided var
	$CurrentUser = $_SESSION['currentUser'];
//}

//Get the user's information
	$GetUserInformationQuery = "SELECT * FROM Users WHERE Email='" . $CurrentUser . "'";
	$userInfoResults = mysqli_query($connection, $GetUserInformationQuery);

	//Check to see if exists (it should since we already logged in)
	if($userInfoResults-> num_rows > 0){
		while($row = mysqli_fetch_assoc($userInfoResults)){
			$FName = $row["FName"];
			$LName = $row["LName"];
			$PicURL = $row["ProfilePicURL"];
			break; //Only want the first occurance
		}

	}else{
		//err
	}
	//echo "<script type=\"text/javascript\">window.alert(\"User Found: " . $CurrentUser . " FNAME: " . $FName . " LNAME: " . $LName . "\");</script>";
?>
<body>
	<!-- Profile Container -->
	<div class="ProfileContainer">
		<!-- Within the container, we have a rounded profile image -->
		<img src="<?php echo $PicURL ?>" alt="Profile Picture" id="profileImg" class="profileImage" onclick="showSRC('editProfilePicture.html')">
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
				<div class="smalltableCell">
						<a onclick="showSRC('FollowingPage.html')">
							<div class="tableCell img">
								<img class="smalltableCell" src="../img/Follow.png?raw=true" alt="Follow Icon">
							</div>
							<div class="smalltableCell title">
								Follow
							</div>
						</a>
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
		<?php
			}
			?>
			<div class="stdSection" id="bestTastes">
				<div class="stdSectionTitle">
					Best Tastes
				</div>
				<div class="table">

					<!-- Get Favorited beers for this user -->
					<?php
						$getFavoritedBeersQuery = "SELECT DISTINCT u.BeerID, b.PictureURL, b.BeerName FROM UserFavoritesBeer u, Beers b WHERE u.UserEmail='" . $CurrentUser . "' AND b.BeerID=u.BeerID ORDER BY b.BeerName LIMIT 6";
						$favoritedBeersResults = mysqli_query($connection, $getFavoritedBeersQuery);

						if($favoritedBeersResults-> num_rows > 0){
							while($row = mysqli_fetch_assoc($favoritedBeersResults)){
								//There are rows
								$_Session['currentBeer'] = $row['BeerID'];
								echo '<div class="smalltableCell">';
									echo "<a onclick=\"showBeerView(" . $row['BeerID'] . ")\">";
										echo '<div class="tableCell img">';
											echo	"<img class=\"smalltableCell\" src=\"" .  $row['PictureURL'] . "\"alt=\"" . $row['BeerName'] . "\">";
										echo "</div>";
										echo "<div class=\"smalltableCell title\">" . $row['BeerName'] . "</div>";
									echo "</a>";
								echo "</div>";
							}
						}else{
							//No rows yet; inform user;
							echo '<div class="smalltableCell">';
									echo "<a onclick=\"return false;\">";
										echo '<div class="tableCell img">';
											echo	"<img class=\"smalltableCell\" src=\"" .  "http://beerhopper.me/img/x.png" . "\"alt=\"" . "" . "\">";
										echo "</div>";
										echo "<div class=\"smalltableCell title\">" . "No Beers Yet" . "</div>";
									echo "</a>";
								echo "</div>";
						}
					?>
				</div>
				<div class="stdSectionFooter">
					<a href="#" onclick="showSRC('BeerInfo.php');return false;" class="moreClicked">more</a>
				</div>
			</div>
		<div class="stdSection" id="eventCalendar">
			<div class="stdSectionTitle">
				Calendar
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

					if($usersFollowingMeResult-> num_rows > 0 ){
						//If there are some rows, loop through them
						while($row = mysqli_fetch_assoc($usersFollowingMeResult)){
							//echo "<script type=\"text/javascript\">window.alert(\"User Found: " . $row['UserEmail'] . "\");</script>";

							echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"user\">";
								echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"" . $row['UserEmail'] . "\">";
									echo "<div class=\"tableCell img\">";
										echo "<img class=\"smalltableCell\" src=\"" . $row['ProfilePicURL'] . "\" alt=\"" . $row['Name'] . "\">";
									echo "</div>";
									echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . $row['Name'] . "</div>";
								echo "</button>";
								echo "<input type=\"hidden\" name=\"" . strtr($row['UserEmail'], array('.' => '#-#')) . "\" value=\"\">";
							echo "</form>";

							//echo "<p style=\"color:white\">" . $row['UserEmail'];
						}
					}else{
						//Just print a text saying 'no items found';
						echo "<form action=\"\" class=\"stdForm\" name=\"user\" onsubmit=\"return false;\">";
								echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"\">";
									echo "<div class=\"tableCell img\">";
										echo "<img class=\"smalltableCell\" src=\"" . "http://beerhopper.me/img/x.png" . "\" alt=\"" . "" . "\">";
									echo "</div>";
									echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . "Not Followed By Anyone" . "</div>";
								echo "</button>";
							echo "</form>";
					}

					?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('FollowingPage.html')" class="moreClicked">more</a>
				</div>
			</div>
			<div class="stdSection" id="following">
				<div class="stdSectionTitle">
					Following
				</div>
				<div class="table">

				<!-- Using PHP, build the table -->
				<?php
					//Session is already started
					//Get the breweryies the user is following, max 3
					$getBreweriesFollowing = "SELECT DISTINCT BreweryName, ProfilePicURL, b.BreweryID, u.UserEmail FROM BreweryTable b, UserFollowsBrewery u WHERE u.BreweryID = b.BreweryID AND u.UserEmail ='" . $CurrentUser . "' GROUP BY u.BreweryID ORDER BY BreweryName LIMIT 6";
					$breweriesFollowingResults = mysqli_query($connection, $getBreweriesFollowing);

					//If the rows are greater than 1, we can use them to build our table. If not, we need to put a notice to the user.
					if($breweriesFollowingResults-> num_rows > 0){
						//Use a while loop to build the form

						while($row = mysqli_fetch_assoc($breweriesFollowingResults)){
							echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"brewery\">";
								echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"brewery\">";
									echo "<div class=\"tableCell img\">";
										echo "<img class=\"smalltableCell\" src=\"" . $row['ProfilePicURL'] . "\" alt=\"" . $row['BreweryName'] . "\">";
									echo "</div>";
									echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . $row['BreweryName'] . "</div>";
								echo "</button>";
								echo "<input type=\"hidden\" name=\"" . $row['BreweryID'] . "\" value=\"\">";
							echo "</form>";
						}

					}else{
						//Build custom when no rows are found
						echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"brewery\" onsubmit=\"return false;\">";
								echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"" . "" . "\">";
									echo "<div class=\"tableCell img\">";
										echo "<img class=\"smalltableCell\" src=\"" . "http://beerhopper.me/img/x.png" . "\" alt=\"" . "" . "\">";
									echo "</div>";
									echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . "Not Following Anyone!" . "</div>";
								echo "</button>";
								//echo "<input type=\"hidden\" name=\"brewery\" value=\"\">";
							echo "</form>";
					}
					/** Should work **/
					if($_SERVER['REQUEST_METHOD'] == 'POST'){

    						if(isset($_POST['brewery'])){
       							//echo "<script type=\"text/javascript\">window.alert(\"Brewery Found!\");</script>";
							  //$_SESSION['breweryID'] = end(array_keys($_POST));

							  //Navigate to the brewery page iwth the new id
							  echo "<script type=\"text/javascript\"> document.location.href = \"breweryPage.php?id=" . end(array_keys($_POST)) . "\";</script>";

    						}else {
							    $_SESSION['currentUser'] = strtr(end(array_keys($_POST)), array('#-#' => '.'));

							    //echo "<p style=\"color:white;\">" . end(array_keys($_POST));

							    //echo "<script type=\"text/javascript\"> window.alert(\"Found a User: " . print_f(array_keys($_POST)) . "\");</script>";
							    echo "<script type=\"text/javascript\"> document.location.href = \"profilePage.php\";</script>";
						    }
					}

				?>
				</div>
				<div class="stdSectionFooter">
					<a onclick="showSRC('PageNotFound.html')" class="moreClicked">more</a>
				</div>
			</div>
		</div>
	</aside>
	<section>
		<div class="newsFeedHeader">
			Feed:
			<!-- Black Field to Post -->
			<div class="newsFeedBox">
				<img class="feedImg" id="feedImg" src="<?php echo $PicURL ?>" alt="Image in Feed">
				You:
				<hr/>
				<div class="feedTxt">
					<form>
						<textarea id="postBox" wrap="soft" rows="5"></textarea>
						<br/>
					</form>
				</div>
				<button type="submit" onclick="">Post</button>
			</div>
			<div class="newsFeed" id="MainArea">
			<!-- For example purposes, add the add brewery panel -->
			<iframe id="contentFrame" src="../html/NewsFeed.html" title="subcontent" style="width:100%;" onload="resizeIframe(this);"></iframe>
		</div>
		</div>
		<!-- Black Field to Post -->
	</section>
</body>
</html>
