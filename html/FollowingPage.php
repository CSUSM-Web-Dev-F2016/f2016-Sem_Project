<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Following Page</title>
    <meta name="description" content="Create your own Brewery" />
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="../css/FollowingPage.css">


	<!-- Analytics Script -->
  <script src="../js/analytics.js"></script>
    <?php
    		//Start the session
    		session_start();
    	 //Create a basic connection
        $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

        //Check the connection
        if(!$connection){
            die("Connection Failed. Error: " . mysqli_connect_error());
        }

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
    //get what breweries they are following
    $getFollowBrew = "SELECT BreweryTable.BreweryID, BreweryName, ProfilePicURL FROM UserFollowsBrewery, BreweryTable WHERE UserFollowsBrewery.BreweryID = BreweryTable.BreweryID AND UserEmail = '" . $CurrentUser . "'";
    $follow_result = mysqli_query($connection, $getFollowBrew);
    if (!$follow_result) {
      die("Error with Get-Follow-Request: " . mysqli_error($connection));
    }
    if(mysqli_num_rows($follow_result) == 0) {
      echo "<p>You're not following any breweries.</p>";
    }
    ?>
    <h1>&nbsp;</h1>
    <div class="container">
      <p class="following-header">Breweries you're following:</p>
      <div class="link-container">
        <?php
        while($brewRow = mysqli_fetch_assoc($follow_result)){
        ?>
        <div class="icon">
          <p class="icon-title"><?php echo $brewRow["BreweryName"]?></p>
          <img src="<?php echo $brewRow["ProfilePicURL"]?>" alt="Brewery Profile Pic" height="100" width="100">
        </div>
        <?php } ?>
      </div>
    </div>

    <?php
    mysqli_free_result($follow_result);
    $getFollowUser = "SELECT Fname, Lname, ProfilePicURL FROM Users, UserFollowsUser WHERE UserEmail = '" . $CurrentUser . "' AND OtherUserEmail = Email";
    $followUser_result = mysqli_query($connection, $getFollowUser);
    if (!$followUser_result) {
      die("Error with Get-User-Request: " . mysqli_error($connection));
    }
    if(mysqli_num_rows($followUser_result) == 0) {
      echo "<p>You're not following any users.</p>" ;
    }
    ?>

    <div class="container">
      <p class="following-header">Users you're following:</p>
      <div class="link-container">
        <?php
        while($userRow = mysqli_fetch_assoc($followUser_result)){
        ?>
        <div class="icon">
          <p class="icon-title"><?php echo $userRow["Fname"] . " " . $userRow["Lname"]?></p>
          <img src="<?php echo $userRow["ProfilePicURL"]?>" alt="User Profile Pic" height="100" width="100">
        </div>
        <?php } ?>
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
