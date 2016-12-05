<!DOCTYPE html>
<html lang="en-us">
<head>
	<link rel="stylesheet" href="../css/BasicPage.css" type="text/css">
	<link rel="stylesheet" href="../css/EmptyForm.css" type="text/css">
	<title>Brewery</title>

	<!-- Analytics Script -->
	<script src="../js/analytics.js"></script>
	<?php

        session_start(); // start connection

        /*Get the token to prove the user was logged in*/
          if (strlen($_SESSION['loginToken']) == 0) { // if the user is not logged in
         header('Location: ../index.php'); // redirect to index.php
          }
         // Create a basic connection
        $connection = include '../php/DBConnectionReturn.php';

        /* get brewery name */
        $BreweryID = $_GET['id'];
        $BreweryInfoQuery = "SELECT * FROM BreweryTable WHERE BreweryID='".$_GET['id']."'";
        $BreweryInfoResults = mysqli_query($connection, $BreweryInfoQuery);
        if ($BreweryInfoResults->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($BreweryInfoResults)) {
                $BreweryName = $row['BreweryName'];
                $BreweryStory = $row['About'];
                break;
            }
						CustomLog($connection, $_SESSION['signedInUser'], 'User Action', "User viewed the story for BreweryID= " . $$_GET['id'] . "Name: " . $BreweryName);
        }

				if(mysqli_error($connection)){
					CustomLog($connection, $_SESSION['signedInUser'], 'Story Error', "Could not load a story for BeerID=" . $_GET['BeerID'] . ", BeerName: " . $BreweryName . "Error Details: " . mysqli_error($connection));
				}

				if(sizeof(trim($BreweryStory)) == 0){
					$BreweryStory = "Bummer... No brewery story has been added yet..";
				}
        ?>

</head>

<body>
	<h1>;&nbsp;</h1>
	<div class="emptyForm" id="about">
		<div class="stdSection">
			<div class="formTitle">
				About
			</div>
			<hr>
			<div class="formContent">
				<p><?php echo "$BreweryStory" ?>
				</p>
      </div>
		</div>
	</div>

</body>

</html>
