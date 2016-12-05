<!Doctype html>
<html lang="en">
<!-- hours page html-->

	<head>
		<meta charset="utf-8">
		<title>Hours</title> <!-- title the page -->
		<link rel="stylesheet" type="text/css" href="../css/hours.css"> <!-- link to settings.css -->
		<link rel="stylesheet" type="text/css" href="../css/BasicPage.css">
		<script src="../js/hours.js"></script> <!-- ready up script magic -->


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
            $BreweryInformationQuery = "SELECT Hours FROM BreweryTable WHERE BreweryID='".$_GET['id']."'";
            $BreweryInfoResults = mysqli_query($connection, $BreweryInformationQuery);
           
            $BreweryID = $_GET['id'];
            if ($BreweryInfoResults->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($BreweryInfoResults)) {
                    $BreweryHours = $row['Hours'];
                    break;
                }
            }

            if (empty($BreweryHours)){
				$BreweryHours = "Brewery hasn't entered their hours yet!";
			}
            ?>
	</head>

	<body>
		<div class="emptyForm">
			<div class="hoursborder">
				<div class="hourstitle">Hours of Operation:</div>
				<hr>
				<div class="listhours">
					<?php echo "$BreweryHours"; ?>
				</div>
		</div>
		</div>
	</body>
</html>
