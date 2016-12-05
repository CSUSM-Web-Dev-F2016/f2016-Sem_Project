<!DOCTYPE html>

<html lang="en-us">
<!--
*	@Author:							Justin Goulet
* @Date-Last-Modified:	November 23, 2016
* @Date-Created:				September 1, 2016
*	@Purpose:							To show search results based on text recieved
*	@Method:							We first take the text from the search ox on either the
*												Profile Page or the Brewery Page. Using that text,
*												We can query several fields to get a precise result
*												For our users.
*												Then, once we have the results, we build tables following
*												The same layout as the sidebars, so that the design is similar.
-->

<head>
     <!-- This page will display 3 stdSections.
          One is a query for users,
          One is a query for breweries,
          One is a query for beers
          -->
          <!-- get Style Sheets -->
	<link rel="stylesheet" href="../css/searchResultsStyle.css" type="text/css">
</head>

<body>

     <!-- The rest is php. Build the tables on the fly -->
     <?php
		 			//Import needed PHP files
		 			include "create_table.php";

					//Start the sessin
          session_start();

					//Gather the new connection
					$connection = include '../php/DBConnectionReturn.php';

					//Now that the connection is built, let's do teh queries (BUsers, Breweries, BEers, max of 20);
					$MaxReturning = 20;
     ?>

		 <!--Build the User Table -->
		 <div class="stdSection" id="followers">
			 <div class="stdSectionTitle">
				 Users
			 </div>
			 <div class="table">
				 <?php
				 $getUsersFollowingMeQuery = "SELECT DISTINCT Email, ProfilePicURL, CONCAT(FName, '<br>', LName) AS Name, LName FROM Users WHERE Email LIKE'%" . $_GET['text'] . "%' OR FName LIKE'%" . $_GET['text'] . "%' OR LName LIKE'%" . $_GET['text'] . "%' ORDER BY LName LIMIT " . $MaxReturning;
				 $usersFollowingMeResult = mysqli_query($connection, $getUsersFollowingMeQuery);

				 //Create the table
				 searchResultsTable($usersFollowingMeResult, 'Email', 'ProfilePicURL', 'Name', 'user');

				 //Free the results
				 if($usersFollowingMeResult) mysqli_free_result($usersFollowingMeResult);

				 ?>
			 </div>
		 </div>

		 <!-- Build the Brewery Table -->
		 <div class="stdSection" id="followers">
			 <div class="stdSectionTitle">
				 Breweries
			 </div>
			 <div class="table">
				 <?php
				 $getBreweriesFollowing = "SELECT DISTINCT b.BreweryName, b.ProfilePicURL, b.BreweryID FROM BreweryTable b, BreweryLocation bl WHERE b.BreweryID=bl.BreweryID AND bl.City LIKE '%" . $_GET['text'] . "%' OR b.BreweryName LIKE '%" . $_GET['text'] . "%' OR bl.City='%" . $_GET['text'] . "%' OR bl.Zip='%" . $_GET['text'] . "%' ORDER BY b.BreweryName LIMIT " . $MaxReturning;
 				$breweriesFollowingResults = mysqli_query($connection, $getBreweriesFollowing);

				//Build the table
				searchResultsTable($breweriesFollowingResults, 'BreweryID', 'ProfilePicURL', 'BreweryName', 'brewery');

				//Free the results
				if($breweriesFollowingResults) mysqli_free_result($breweriesFollowingResults);
				 ?>
			 </div>
		 </div>

		 <div class="stdSection" id="followers">
			 <div class="stdSectionTitle">
				 Beers
			 </div>
			 <div class="table">
				 <?php
				 $getBeers = "SELECT PictureURL, BeerID, BeerName FROM Beers WHERE BeerName Like '%" . $_GET['text'] . "' OR BeerDescription Like '%" . $_GET['text'] . "' LIMIT " . $MaxReturning;
				 $getBeersResults = mysqli_query($connection, $getBeers);
				 //echo "<script type=\"text/javascript\">window.alert(\"Result Count: " . $getBeersResults-> num_rows . " Query: " . $getBeers . "\");</script>";

				 beersSearchTable($getBeersResults);

				 //Free results
				 if($getBeersResults) mysqli_free_result($getBeersResults);

					//Close the mysql connection
					$connection-> close();
				 ?>
			 </div>
		 </div>
		 <?php
		 		//For the Post Request.
				//If a brewery, set the breweryID then go to the brewery page.
				//If a user, set the current user and go to the profile page
				//If a brewery, show the beer in teh current iframe
				if($_SERVER['REQUEST_METHOD'] == 'POST'){

						if(isset($_POST['brewery'])){

							//Navigate to the brewery page iwth the new id
							echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/breweryPage.php?id=" . end(array_keys($_POST)) . "\";</script>";

						}
						else if(isset($_POST['beerID'])) {
								//echo "<script type=\"text/javascript\"> window.alert(\"Found a Beer: " . $_POST['BeerID'] . "\");</script>";
								echo "<script type=\"text/javascript\"> window.location.href = \"../html/BeerInfo.php?BeerID=" . $_POST['beerID'] . "\";</script>";
						}

						else {
								$_SESSION['currentUser'] = strtr(end(array_keys($_POST)), array('#-#' => '.'));

								//echo "<script type=\"text/javascript\"> window.alert(\"Found a User: " . $_SESSION['currentUser'] . "\");</script>";
								echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/profilePage.php\";</script>";
						}
				}

				//Close the current session
				session_write_close();

		  ?>

</body>



</html>
