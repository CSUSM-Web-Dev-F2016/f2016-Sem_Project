<!DOCTYPE html>

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

	  //check status
	   if(strlen($_SESSION['loginToken']) == 0){
		//r	edirect to the login page 
	 	header("Location: ../index.php");
		}
		else{
		//e	cho "<p>You rock";
		}

	 //Create a basic connection
    	$connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

	//Check the connection
    	if(mysqli_connect_errno()){
		die("Connection Failed. ERR: " . mysqli_connect_error());
	}

	//Get the current beer information
	$BeerQuery = "SELECT * FROM Beers WHERE BeerID=" . $_GET['beerID'] . " LIMIT 1";
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
			break; //Since there is only one case.
		}
	}else{
		//Beer does not exist
		echo "<p style=\"color:white;\">DNE";
	}


  ?>
	<body>
		<div class="parentClass">
			<h1>&nbsp;</h1>
			<div class="LargeTable">
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
										<p class="imageCell"><?php echo $ABV . "%" ?></p>
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
										<p class="imageCell"><?php echo $IBU ?></p>
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
										<p class="imageCell">N/A</p> 
									</div>
									<div class="smalltableCell title">
										<!-- The amount will be displayed above -->
										Like Count
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

				<div class="MainCell">
					<!-- Add a table for remaining brew details -->
					<table class="beerInfo">
						<caption>&nbsp;</caption>
						<tbody>
							<tr>
								<th>Beer Description:
								</th>
								<td>
									<?php echo $FromTheBrewMaster ?>
								</td>
							</tr>
							<tr>
								<th>
									Foord Pairings:
								</th>
								<td>
									<?php echo $PairingsDescription ?>
								</td>
							</tr>
							<tr>
								<th>
									Awards Won:
								</th>
								<td>
									<?php echo $Awards ?>
								</td>
							</tr>
							<tr>
								<th>When Available:</th>
								<td><span style="color:green;">Coming Soon...</span>
								</td>
							</tr>
						</tbody>
					</table>

				</div>

			</div>

		</div>

	</body>
