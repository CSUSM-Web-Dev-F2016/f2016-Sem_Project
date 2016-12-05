<!Doctype html>
<html lang="en">
<!-- maps page html-->

<head>
	<meta charset="utf-8">
	<title>location</title>
	<!-- title the page -->
	<link rel="stylesheet" type="text/css" href="../css/address.css">
	<!-- link to settings.css -->
	<script src="../js/address.js"></script>
	<!-- ready up script magic -->

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
        $BreweryInfoQuery = "SELECT * FROM BreweryTable WHERE BreweryID='".$_GET['id']."'";
        $BreweryInfoResults = mysqli_query($connection, $BreweryInfoQuery);
        if ($BreweryInfoResults->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($BreweryInfoResults)) {
                $BreweryName = $row['BreweryName'];
                break;
            }
        }

        /* get brewery location */
        $BreweryLocationQuery = "SELECT * FROM BreweryLocation WHERE BreweryID='".$_GET['id']."'";
        $BreweryInfoResults = mysqli_query($connection, $BreweryLocationQuery);

        $BreweryID = $_GET['id'];
        if ($BreweryInfoResults->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($BreweryInfoResults)) {
                $BreweryAddr1 = $row['AddrLineOne'];
                $BreweryAddr2 = $row['AddrLineTwo'];
                $City = $row['City'];
                $State = $row['State'];
                $Zip = $row['Zip'];
                $BreweryAddress = ' ';
                break;
            }
        }

        if (!isset($BreweryAdd2)) { // if brewery has no addr2
            //echo 'NULLL';
            $BreweryAddress = $BreweryAddr1.' '.$BreweryCity.' '.$BreweryState.' '.$BreweryZip;
        } else {  // if brewery has addr2
            //echo 'NOT NULL';
            $BreweryAddress = $BreweryAddr1; //.' '.$BreweryAddr2.' '; //.$BreweryCity.' '.$BreweryState.' '.$BreweryZip;
        }
        //echo "$BreweryAddress";
    ?>
</head>

<body>
	<div class="emptyForm">
		<div class="addressborder">
			<div class="addresstitle"> Location <?php //echo "$BreweryName"?></div>
			<hr><br>
			<div class="pictureholder">
				<p><?php// echo "$BreweryID"; ?></p>
				<?php //echo "$BreweryAddress";?>
				<!-- Gets Brewerylocation from Google Maps using $BreweryName & $BreweryAddress -->
				<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo "$BreweryName"."$BreweryAddress"; ?>&output=embed"></iframe>
				<br>
			</div>
		</div>
	</div>
</body>

</html>
