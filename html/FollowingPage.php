<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Following Page</title>
    <meta name="description" content="Create your own Brewery" />
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="../css/FollowingPage.css">


	<!-- Analytics Script -->
  	<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-83948702-3', 'auto');
    ga('send', 'pageview');

    </script>
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
      echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">You must be logged in to create a brewery</p>";
      die();
    }
    //get what breweries they are following
    $getFollowBrew = "SELECT BreweryTable.BreweryID, BreweryName, ProfilePicURL FROM UserFollowsBrewery, BreweryTable WHERE UserFollowsBrewery.BreweryID = BreweryTable.BreweryID AND UserEmail = '" . $CurrentUser . "'";
    $follow_result = mysqli_query($connection, $getFollowBrew);
    if (!$follow_result) {
      die("Error with Get-Follow-Request: " . mysqli_error($connection));
    }
    if(mysqli_num_rows($follow_result) == 0) {
      die("<p>You're not following any breweries.</p>");
    }
    while($brewRow = mysqli_fetch_assoc($follow_result)){
      echo $brewRow["BreweryID"] . " Name: " . $brewRow["BreweryName"] . "URL: " . $brewRow["BreweryName"] . "<br>";
    }
    ?>
    <h1>&nbsp;</h1>
    <div class="container">
      <p class="following-header">Breweries You're Following</p>
      <div class="link-container">
        <div class="icon">
          <p class="icon-title">Ballast Point</p>
          <img src="../img/Beer.png?raw=true" alt="Image 1" height="100" width="100">
        </div>
        <div class="icon">
          <p class="icon-title">Green Flash</p>
          <img src="../img/Beer.png?raw=true" alt="Image 2" height="100" width="100">
        </div>
        <div class="icon">
          <p class="icon-title">Acoustic Ales</p>
          <img src="../img/Beer.png?raw=true" alt="Image 3" height="100" width="100">
        </div>
        <div class="icon">
          <p class="icon-title">Iron Fist</p>
          <img src="../img/Beer.png?raw=true" alt="Image 4" height="100" width="100">
        </div>
      </div>
    </div>

    <div class="container" id="suggested-followers">
      <p class="following-header" id="suggested-header">Suggested Profiles to Follow</p>
      <div class="link-container" id="suggested-container">
        <div class="icon">
          <p class="icon-title">Iron Fist</p>
          <img src="../img/Beer.png?raw=true" alt="Image 5" height="100" width="100">
        </div>
        <div class="icon">
          <p class="icon-title">Brewey</p>
          <img src="../img/Beer.png?raw=true" alt="Image 6" height="100" width="100">
        </div>
      </div>
    </div>

  </body>
</html>
