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
	<script>
		(function(i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function() {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-83948702-3', 'auto');
		ga('send', 'pageview');
	</script>

	<?php

        session_start(); // start connection

        /*Get the token to prove the user was logged in*/
          if (strlen($_SESSION['loginToken']) == 0) { // if the user is not logged in
         header('Location: ../index.php'); // redirect to index.php
          }
         // Create a basic connection
        $connection = include '../php/DBConnectionReturn.php';
        $BeerLocationQuery = "SELECT * FROM BreweryLocation WHERE BreweryID='".$_GET['id']."'";
        $BreweryInfoResults = mysqli_query($connection, $BeerLocationQuery);
        //echo "$BreweryLocationQuery";

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
            echo 'NULLL';
            $BreweryAddress = $BreweryAddr1.' '.$BreweryCity.' '.$BreweryState.' '.$BreweryZip;
        } else {  // if brewery has addr2
            echo 'NOT NULL';
            $BreweryAddress = $BreweryAddr1; //.' '.$BreweryAddr2.' '; //.$BreweryCity.' '.$BreweryState.' '.$BreweryZip;
        }
        //echo "$BreweryAddress";
    ?>
</head>

<body>
	<div class="emptyForm">
		<div class="addressborder">
			<div class="addresstitle"> Location <?php// echo "$BreweryAddress" ?></div>
			<hr><br>
			<div class="pictureholder">
				<p><?php// echo "$BreweryID"; ?></p>
				<?php //echo "$BreweryAddress";?>
				<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo "$BreweryAddress"; ?>&output=embed"></iframe>

				<br><!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3339.7000942404284!2d-117.22257168511138!3d33.16949947117712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dc74fbe74608d3%3A0x11ddf54291cfd3ad!2sIndian+Joe+Brewing!5e0!3m2!1sen!2sus!4v1477368189720"
								height="300" style="border:0" allowfullscreen></iframe>-->
			</div>
		</div>
	</div>
</body>

</html>
