<!DOCTYPE html>

<html lang="en-us">

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
          session_start();

          //Read the get variable (Should be text)
          //echo "<script type=\"text/javascript\">window.alert(\"Beer Found!: " . $_GET['text'] . "\");</script>";

					$connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

		   		 	//Check the connection
		    		if(mysqli_connect_errno()){
		       			 die("Connection Failed. ERR: " . mysqli_connect_error());
		    		}

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

				 if($usersFollowingMeResult-> num_rows > 0 ){
					 //If there are some rows, loop through them
					 while($row = mysqli_fetch_assoc($usersFollowingMeResult)){
						 //echo "<script type=\"text/javascript\">window.alert(\"User Found: " . $row['UserEmail'] . "\");</script>";

						 echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"user\">";
							 echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"" . $row['Email'] . "\">";
								 echo "<div class=\"tableCell img\">";
									 echo "<img class=\"smalltableCell\" src=\"" . $row['ProfilePicURL'] . "\" alt=\"" . $row['Name'] . "\">";
								 echo "</div>";
								 echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . $row['Name'] . "</div>";
							 echo "</button>";
							 echo "<input type=\"hidden\" name=\"" . strtr($row['Email'], array('.' => '#-#')) . "\" value=\"\">";
						 echo "</form>";

						 //echo "<p style=\"color:white\">" . $row['UserEmail'];
					 }
				 }
				 else{
					 //Just print a text saying 'no items found';
					 echo "<form action=\"\" class=\"stdForm\" name=\"user\" onsubmit=\"return false;\">";
							 echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"\">";
								 echo "<div class=\"tableCell img\">";
									 echo "<img class=\"smalltableCell\" src=\"" . "http://beerhopper.me/img/x.png" . "\" alt=\"" . "" . "\">";
								 echo "</div>";
								 echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . "No Users Found!" . "</div>";
							 echo "</button>";
						 echo "</form>";
				 }
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

				 if($getBeersResults-> num_rows > 0){
  					//Use a while loop to build the form

  					while($row = mysqli_fetch_assoc($getBeersResults)){
  						echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"beer\">";
  							echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"beer\">";
  								echo "<div class=\"tableCell img\">";
  									echo "<img class=\"smalltableCell\" src=\"" . $row['PictureURL'] . "\" alt=\"" . $row['BeerName'] . "\">";
  								echo "</div>";
  								echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . $row['BeerName'] . "</div>";
  							echo "</button>";
  							echo "<input type=\"hidden\" name=\"beerID\" value=\"" . $row['BeerID'] . "\">";
  						echo "</form>";
  					}

  				}else{
  					//Build custom when no rows are found
  					echo "<form action=\"\" class=\"stdForm\" name=\"beer\" onsubmit=\"return false;\">";
  							echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"" . "" . "\">";
  								echo "<div class=\"tableCell img\">";
  									echo "<img class=\"smalltableCell\" src=\"" . "http://beerhopper.me/img/x.png" . "\" alt=\"" . "" . "\">";
  								echo "</div>";
  								echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . "No Beers Found!" . "</div>";
  							echo "</button>";
  							//echo "<input type=\"hidden\" name=\"brewery\" value=\"\">";
  						echo "</form>";
  				}
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
								//echo "<script type=\"text/javascript\">window.alert(\"Brewery Found!\");</script>";
							//$_SESSION['breweryID'] = end(array_keys($_POST));

							//Navigate to the brewery page iwth the new id
							echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/breweryPage.php?id=" . end(array_keys($_POST)) . "\";</script>";

						}
						else if(isset($_POST['beerID'])) {
								//echo "<script type=\"text/javascript\"> window.alert(\"Found a Beer: " . $_POST['BeerID'] . "\");</script>";
								echo "<script type=\"text/javascript\"> window.location.href = \"../html/BeerInfo.php?beerID=" . $_POST['beerID'] . "\";</script>";
						}

						else  {
								$_SESSION['currentUser'] = strtr(end(array_keys($_POST)), array('#-#' => '.'));

								//echo "<p style=\"color:white;\">" . end(array_keys($_POST));

								//echo "<script type=\"text/javascript\"> window.alert(\"Found a User: " . $_SESSION['currentUser'] . "\");</script>";
								echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/profilePage.php\";</script>";
							}
				}


		  ?>

</body>



</html>
