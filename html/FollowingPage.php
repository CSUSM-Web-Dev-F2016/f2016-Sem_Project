<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Following Page</title>
    <meta name="description" content="Create your own Brewery" />
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="../css/FollowingPage.css">
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

    	 $CurrentUser = $_SESSION['currentUser'];
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
        Breweries You're Following
      </div>
      <div class="table">
        <?php
        $getFollowBrew = "SELECT BreweryTable.BreweryID, BreweryName, ProfilePicURL FROM UserFollowsBrewery, BreweryTable WHERE UserFollowsBrewery.BreweryID = BreweryTable.BreweryID AND UserEmail = '" . $CurrentUser . "'";
        $follow_result = mysqli_query($connection, $getFollowBrew);

       //Build the table
       searchResultsTable($follow_result, 'BreweryID', 'ProfilePicURL', 'BreweryName', 'brewery');

       //Free the results
       if($follow_result) mysqli_free_result($follow_result);
        ?>
      </div>
    </div>

    <div class="stdSection" id="followers">
      <div class="stdSectionTitle">
        People You're Following
      </div>
      <div class="table">
        <?php
        $getFollowUser = "SELECT CONCAT(FName, '<br>', LName) AS Name, ProfilePicURL, Email FROM Users, UserFollowsUser WHERE UserEmail = '" . $CurrentUser . "' AND OtherUserEmail = Email";
        $followUser_result = mysqli_query($connection, $getFollowUser);

       //Build the table
       searchResultsTable($followUser_result, 'Email', 'ProfilePicURL', 'Name', 'user');

       //Free the results
       if($followUser_result) mysqli_free_result($followUser_result);
        ?>
      </div>
    </div>

    <div class="stdSection" id="followers">
      <div class="stdSectionTitle">
        Breweries Following You
      </div>
      <div class="table">
        <?php
        $getBrewFollowMe = "SELECT BreweryTable.BreweryID, BreweryName, ProfilePicURL FROM BreweryFollowsUser, BreweryTable WHERE BreweryFollowsUser.BreweryID = BreweryTable.BreweryID AND UserEmail = '" . $CurrentUser . "'";
        $brewFollowMe_result = mysqli_query($connection, $getBrewFollowMe);

       //Build the table
       searchResultsTable($brewFollowMe_result, 'BreweryID', 'ProfilePicURL', 'BreweryName', 'brewery');

       //Free the results
       if($brewFollowMe_result) mysqli_free_result($brewFollowMe_result);
        ?>
      </div>
    </div>

    <div class="stdSection" id="followers">
      <div class="stdSectionTitle">
        People Following You
      </div>
      <div class="table">
        <?php
        $getPeopleFollowMe = "SELECT DISTINCT CONCAT(FName, '<br>', LName) AS Name, ProfilePicURL, Email FROM Users, UserFollowsUser WHERE OtherUserEmail = '" . $CurrentUser . "' AND UserEmail = Email";
        $peopleFollowMe_result = mysqli_query($connection, $getPeopleFollowMe);

       //Build the table
       searchResultsTable($peopleFollowMe_result, 'Email', 'ProfilePicURL', 'Name', 'user');

       //Free the results
       if($peopleFollowMe_result) mysqli_free_result($peopleFollowMe_result);
        ?>
      </div>
    </div>

    <?php

    //Run the 'If' Statement to determine what should happen on click
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

            //echo "<script type=\"text/javascript\"> window.alert(\"Found a User: " . $_POST['user'] . "\");</script>";
            echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/profilePage.php\";</script>";
        }
    }

    //Close the current session
    session_write_close();

    //close database connection
    mysqli_close($connection);
    ?>

  </body>
</html>
