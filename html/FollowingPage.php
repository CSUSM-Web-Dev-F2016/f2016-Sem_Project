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
        Breweries You're Following
      </div>
      <div class="table">
        <?php
        $getFollowBrew = "SELECT BreweryTable.BreweryID, BreweryName, ProfilePicURL FROM UserFollowsBrewery, BreweryTable WHERE UserFollowsBrewery.BreweryID = BreweryTable.BreweryID AND UserEmail = '" . $CurrentUser . "'";
        $follow_result = mysqli_query($connection, $getFollowBrew);

       //Build the table
       searchResultsTable($follow_result, 'BreweryID', 'ProfilePicURL', 'BreweryName', 'brewery');

       //Free the results
       if($breweriesFollowingResults) mysqli_free_result($breweriesFollowingResults);
        ?>
      </div>
    </div>

    <div class="stdSection" id="followers">
      <div class="stdSectionTitle">
        People You're Following
      </div>
      <div class="table">
        <?php
        $getFollowUser = "SELECT Fname, Lname, ProfilePicURL FROM Users, UserFollowsUser WHERE UserEmail = '" . $CurrentUser . "' AND OtherUserEmail = Email";
        $followUser_result = mysqli_query($connection, $getFollowUser);

       //Build the table
       searchResultsTable($followUser_result, 'Email', 'ProfilePicURL', 'Fname', 'user');

       //Free the results
       if($breweriesFollowingResults) mysqli_free_result($breweriesFollowingResults);
        ?>
      </div>
    </div>

    <?php
    //free query results
    mysqli_free_result($follow_result);
    mysqli_free_result($followUser_result);
    //close database connection
    mysqli_close($connection);
    ?>

  </body>
</html>
