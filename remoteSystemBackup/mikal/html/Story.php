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
				<p><?php echo "$BreweryStory" ?></p>
				<p hidden="true">In my 20s, I was introduced to the art of
				craft brewing after helping my father and a German master brewer formulate small batches of beer. I was mesmerized by
				the process and how unique flavors could be achieved by blending different natural ingredients. Inspired to become a
				brewer, I asked my entrepreneur friend, Pedro, if he would go into business with me in the late 1980s. He told me that
				I was a crazy dreamer:“There’s no way we could compete with giants like Bud, Miller and Coors,” he said. So I put my
				dream on hold. Then, in the late 1990s, I watched local upstart breweries, like Stone, Ballast Point and others carving
				out success. This was very encouraging and it re-lit the fire within me. Encouraged by friends and loved ones, I took
				the leap of faith and decided to pursue my dream and become a full-time brewer. In 2010, after nearly two years of legal
				maneuvering, I was granted the trademark for “Indian Joe Brewing” in honor of my Great Uncle Joe and my Native heritage.
				The vision I had nearly 20 years ago is now a reality. Our small brewery and tasting room opened in the fall of 2012.
				</p>
               </div>
		</div>
	</div>

</body>

</html>
