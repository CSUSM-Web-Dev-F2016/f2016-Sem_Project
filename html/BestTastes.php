<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Best Tastes</title>
    <meta name="description" content="Show your favorite Beers" />
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../css/searchResultsStyle.css" type="text/css">


	<!-- Analytics Script -->
  <script src="../js/analytics.js"></script>
    <?php
    		//Start the session
    		session_start();

       //Import needed PHP files
       include "../php/create_table.php";

       //Create a basic connection
       $connection = include '../php/DBConnectionReturn.php';

    	 $CurrentUser = $_SESSION['signedInUser'];
    ?>
  </head>
  <body>
    <?php
    //if the login has timed out, notify user
    if ($CurrentUser == "") {
      echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">You must be logged in to view your followers.</p>";
      die();
    }
    ?>

    <!-- Build the Brewery Following Table -->
    <div class="stdSection" id="followers">
      <div class="stdSectionTitle">
        Your Favorite Beers
      </div>
      <div class="table">
        <?php
        $getFavBeer = "SELECT u.BeerID, b.PictureURL, b.BeerName FROM UserFavoritesBeer u, Beers b WHERE u.UserEmail='" . $CurrentUser . "' AND b.BeerID=u.BeerID";
        $favBeer_result = mysqli_query($connection, $getFavBeer);

       //Build the table
       beersSearchTable($favBeer_result);

       //Free the results
       if($favBeer_result) mysqli_free_result($favBeer_result);
        ?>
      </div>
    </div>

    <?php


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
       if(isset($_POST['beerID'])) {
            //echo "<script type=\"text/javascript\"> window.alert(\"Found a Beer: " . $_POST['BeerID'] . "\");</script>";
            echo "<script type=\"text/javascript\"> window.location.href = \"../html/BeerInfo.php?BeerID=" . $_POST['beerID'] . "\";</script>";
        }


      //close database connection
      mysqli_close($connection);
    }
    ?>

  </body>
</html>
