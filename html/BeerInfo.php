<!DOCTYPE html>

<!--
*	@Author:							Justin Goulet
* @Date-Last-Modified:	November 23, 2016
* @Date-Created:				September 1, 2016
*	@Purpose:							To show a simple view of a single beer
*	@Method:							Using a provided beerid, query to get the beer requested.
*												We then allow the current signed in user to favorite the
*												beer so that thy can view it at a later point in time.
-->

<html lang="en-us">

	<head>
		<!-- CSS Files -->
		<link rel="stylesheet" href="../css/BasicPage.css" type="text/css">
		<link rel="stylesheet" href="../css/beerInfo.css" type="text/css">
		<link rel="stylesheet" href="../css/masterPage.css" type="text/css">
		<title>Beer Info</title>

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
  	//Start the session to share data
	  session_start();

	 //Create a basic connection
    	$connection = include '../php/DBConnectionReturn.php';

	//Determine if the user is following the beer
	//See if there is an entry in the table
	$getIfFollows = "SELECT * FROM UserFavoritesBeer WHERE UserEmail='" . $_SESSION['signedInUser'] . "' AND BeerID=" . $_GET['beerID'];
	$getFollowsResult = mysqli_query($connection, $getIfFollows);
	$_SESSION['Follows'] = "FALSE";
	$FollowImage = "";


	if($getFollowsResult-> num_rows > 0){
		//Set the Bool Success
		$_SESSION['Follows'] = "TRUE";
		$FollowImage = "../img/Unfollow_Follow_Color.png";
	}else{
		$FollowImage = "../img/Follow_Color.png";
	}

	//Free the follow result
	mysqli_free_result($getFollowsResult);

	//echo "<script type=\"text/javascript\">window.alert(\"Follows?: " . $getIfFollows . "\");</script>";

	//Get the current beer information
	$BeerQuery = "SELECT
												b.BeerID,b.FromTheBrewMaster, b.PairingsDescription,
												b.PictureURL, b.BeerName, b.RecommendedServingGlass, b.Awards,
												b.FromTheBrewmaster, b.OnTap, b.Awards, b.ServingStyle, b.IBU,
												b.ABV, b.BeerType, b.BeerDescription,
												bt.BreweryName
								FROM
												Beers b, BreweryTable bt
								WHERE
												b.BreweryID=bt.BreweryID AND b.BeerID=" . $_GET['beerID'] . " LIMIT 1";

	//$BeerQuery = "SELECT * FROM Beers WHERE BeerID=" . $_GET['beerID'] . " LIMIT 1";
	$ResultsForBeer = mysqli_query($connection, $BeerQuery);

	if($ResultsForBeer-> num_rows > 0){
		//Should be one instance
		while($row = mysqli_fetch_assoc($ResultsForBeer)){
			$BeerID = $row['BeerID'];
			$BeerName = $row['BeerName'];
			$FromTheBrewMaster = $row['FromTheBrewmaster'];
			$PairingsDescription = $row['PairingsDescription'];
			$PictureURL = $row['PictureURL'];
			$RecommendedServingGlass = $row['RecommendedServingGlass'];
			$Awards = $row['Awards'];
			$ServingStyle = $row['ServingStyle'];
			$IBU = $row['IBU'];
			$ABV = $row['ABV'];
			$BreweryID = $row['BreweryID'];
			$BeerType = $row['BeerType'];
			$OnTap = $row['OnTap'];
			$BeerDescription = $row['BeerDescription'];
			$BreweryName = $row['BreweryName'];
			break; //Since there is only one case.
		}

		//Free the results
		mysqli_free_result($ResultsForBeer);


	}else{
		//Beer does not exist
		//echo "<p style=\"color:white;\">DNE";
		header("Location: ../html/PageNotFound.html");
	}


  ?>
	<body>
		<div class="parentClass">
			<h1>&nbsp;</h1>
			<div class="LargeTable">
				<form action="" onsubmit="" method="POST" class="favBtnHolder">
				<!-- We need to descide if the user is already following the beer or not first -->
					<label class="hidden">submit</label>
					<input value="<?php echo $_GET['beerID']; ?>" type="image" src="<?php echo $FollowImage ?>" name="beerID" alt="follow" id="FollowPic">
				</form>
				<div class="LargeTableTitle">
					<?php echo $BeerName ?>
				</div>
				<div class="mainContent">
					<div class="beerImage">
						<img src="<?php echo $PictureURL ?>" alt="Beer Image" class="cellImage">
					</div>
					<div class="mainTableCells">

						<div class="MainCell">
							<!-- Start of small header table  -->
							<div class="smalltableCell">
								<div>
									<div class="tableCell img">
										<p class="imageCell"><?php if(isset($ABV)) echo $ABV . "%"; else echo "N/A"; ?></p>
									</div>
									<div class="smalltableCell title">
										<!-- The amount will be displayed above -->
										ABV
									</div>
								</div>
							</div>
							<div class="smalltableCell">
								<div>
									<div class="tableCell img">
										<p class="imageCell"><?php if(isset($IBU)) echo $IBU . ""; else echo "N/A"; ?></p>
									</div>
									<div class="smalltableCell title">
										<!-- The amount will be displayed above -->
										IBU
									</div>
								</div>
							</div>
							<div class="smalltableCell">
								<div>
									<div class="tableCell img">
										<p class="imageCell">
										<?php
											//Run a query to get the count of all that favorited this beer
											$qu = "SELECT COUNT(*) AS Count FROM UserFavoritesBeer WHERE BeerID=" . $_GET['beerID'];
											$re = mysqli_query($connection, $qu);

											if($re-> num_rows > 0){
												while($row = mysqli_fetch_assoc($re)){
													echo "" . $row['Count'];
													break;
												}
											}else{
												echo "N/A";
											}

											//Close the connection
											$connection-> close();
										?>
										</p>
									</div>
									<div class="smalltableCell title">
										<!-- The amount will be displayed above -->
										Favorites
									</div>
								</div>
							</div>

							<div class="smalltableCell">
								<div>
									<div class="tableCell img">
										<img class="smalltableCell" src=
										<?php if($OnTap == 'T'){
												echo "../img/check.png?raw=true";
											}
											else{
												echo "../img/x.png?raw=true";
											} ?> alt="OnTap?">
									</div>
									<div class="smalltableCell title">
										<!-- The amount will be displayed above -->
										On Tap
									</div>
								</div>
							</div>
							<div class="smalltableCell">
								<div>
									<div class="tableCell img">
										<p class="imageCell"><?php echo $ServingStyle?></p>
									</div>
									<div class="smalltableCell title">
										<!-- The amount will be displayed above -->
										Serving Style
									</div>
								</div>
							</div>
							<div class="smalltableCell">
								<div>
									<div class="tableCell img">
										<img class="smalltableCell" src="../img/glass.png?raw=true" alt="Glass Image">
									</div>
									<div class="smalltableCell title">
										<!-- The amount will be displayed above -->
										<?php echo $RecommendedServingGlass ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Edn of small header table -->
				</div>
				<!-- End of main Content -->
				<div class="favBtnHolderRight"></div>

				<div class="MainCell">
					<!-- Add a table for remaining brew details -->
					<table class="beerInfo">
						<caption>&nbsp;</caption>
						<tbody>
							<?php if(!empty($BreweryName)){ ?>
								<tr>
									<th>Brewery Name:
									</th>
									<td>
										<?php echo $BreweryName ?>
									</td>
								</tr>
								<?php
							}
						if(!empty($BeerDescription)){ ?>
							<tr>
								<th>Beer Description:
								</th>
								<td>
									<?php echo $BeerDescription ?>
								</td>
							</tr>
							<?php
						}
						if(!empty($PairingsDescription)){
							?>
							<tr>
								<th>
									Foord Pairings:
								</th>
								<td>
									<?php echo $PairingsDescription ?>
								</td>
							</tr>
							<?php
						}
						if(!empty($Awards)){
							?>
							<tr>
								<th>
									Awards Won:
								</th>
								<td>
									<?php echo $Awards ?>
								</td>
							</tr>
							<?php
						}
						if(!empty($FromTheBrewMaster)){
							?>
							<tr>
								<th>
									From the Brewmaster:
								</th>
								<td>
									<?php echo $FromTheBrewMaster ?>
								</td>
							</tr>
							<?php
						}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<?php
			//Check for submit
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(isset($_POST['beerID'])){

					if($_SESSION['Follows'] == "FALSE"){
						//Start the MySQL query to favorite the beer
						$AddBeerToFavorites = "INSERT INTO UserFavoritesBeer VALUES ('" . $_SESSION['signedInUser'] . "', " . $_POST['beerID'] . ")";
						//echo "<script type=\"text/javascript\">window.alert(\"request: " . $AddBeerToFavorites ."\");</script>";
						$AddedBeerResults = mysqli_query($connection, $AddBeerToFavorites);

						if($AddedBeerResults){
							//echo "<script type=\"text/javascript\">window.alert(\"Beer: " . $_POST['beerID'] . " favorited!\");</script>";
							$FollowImage = "../img/Unfollow_Follow_Color.png";
							$_SESSION['Follows'] = "TRUE";
							echo "<script type=\"text/javascript\">window.location.reload();</script>";
						}else{
							echo "<script type=\"text/javascript\">window.alert(\"Beer: " . $_POST['beerID'] . " could not be foavorited!<br>" . $AddBeerToFavorites . "\");</script>";
						}
					}else{
						//Unfolow
						$RemoveBeerFromFavorites = "DELETE FROM UserFavoritesBeer WHERE UserEmail='" . $_SESSION['signedInUser'] . "' AND BeerID=" . $_POST['beerID'];
						//echo "<script type=\"text/javascript\">window.alert(\"request: " . $RemoveBeerFromFavorites ."\");</script>";
						$RemoveBeerResults = mysqli_query($connection, $RemoveBeerFromFavorites);

						//Complete the request
						if($RemoveBeerResults){
							//Removed
							//echo "<script type=\"text/javascript\">window.alert(\"Unfollowed Beer: " . $_POST['beerID'] . " successfully!\");</script>";
							$FollowImage = "../img/Follow_Color.png";
							$_SESSION['Follows'] = "FALSE";
							echo "<script type=\"text/javascript\">window.location.reload();</script>";
						}else{
							//Did not remove
							echo "<script type=\"text/javascript\">window.alert(\"Error Unfollowing Beer\n" . $RemoveBeerFromFavorites . "\");</script>";
						}

						//Free the results
						mysqli_free_result($RemoveBeerResults);
					}
				}
				else{
					echo "<script type=\"text/javascript\">window.alert(\"Invalid Request\");</script>";
				}

				//Close the connection to mysqli
				$conection-> close();

				//Closes the current session
				session_write_close();
			}
		?>


	</body>
</html>
