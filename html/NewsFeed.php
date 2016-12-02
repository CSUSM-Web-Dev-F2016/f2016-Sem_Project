<!DOCTYPE html>

<html lang="en-us">

<head>
     <!-- CSS Files -->
     <link rel="stylesheet" href="../css/updateStatus.css" type="text/css">
	    <script src="../NewsFeedBuilder.js" type="text/javascript"></script>
     <title> News Feed </title>
     <meta charset="utf-8">
 		  <script src="../js/analytics.js"></script>

</head>

<body>

<?php
  //Start the current session
  session_start();

  $connection = include '../php/DBConnectionReturn.php';

  //Now, once the connection is etablished, get the news feed
  //Basic posts only, presently
  $GetNewsFeedElements = "SELECT DISTINCT p.auto_ID, p.UserEmail, p.PostDate, p.TextContent, CONCAT(u.FName, ' ', u.LName) AS Name, u.ProfilePicURL
                          FROM Post p, UserFollowsUser ufu, Users u
                          WHERE p.shown=1 AND (ufu.UserEmail ='" . $_SESSION['currentUser'] . "' AND (p.UserEmail=ufu.OtherUserEmail AND u.Email=ufu.OtherUserEmail) OR (p.UserEmail='" . $_SESSION['currentUser'] . "' AND p.UserEmail=u.Email))
                          ORDER BY p.PostDate DESC;";

  $NewsFeedResults = mysqli_query($connection, $GetNewsFeedElements);

  if($NewsFeedResults->num_rows > 0){
    while($row = mysqli_fetch_assoc($NewsFeedResults)){

 ?>
    <div class="newsFeedBox" style="width:100%; padding: 0px; padding-bottom:25px;">
      <div class="inline">
      <form action="" class="statusHeader" method="POST" name="user">
        <button class="newsFeedUserButton">
          <img class="feedImg" id="feedImg" src=<?php echo $row['ProfilePicURL'] ?> alt="Image in Feed">
          <p class="userName"><?php echo $row['Name']; ?><p>
          <input type="hidden" name="user" value="<?php echo strtr($row['UserEmail'], array('.' => '#-#')) ?>">
        </button>
      </form>
      <?php if($_SESSION['signedInUser'] == $row['UserEmail']){ ?>
        <form action="" method="POST" name="removeForm" class="remove">
          <input type="image" src="../img/x.png" value="submit" style="height:25px; vertical-align:middle;">
          <input type="hidden" name="remove" value="<?php echo $row['auto_ID'] ?>">
        </form>
      <?php } ?>
    </div>
      <hr/>
      <div class="feedTxt">
        <p class="postText">
          <?php echo $row['TextContent']; ?>
        </p>
        <p class="postDate">
          <?php //echo humanTiming($row['PostDate']) . " ago";
          //echo "Time is Running";
          //echo time2string(time()-strtotime($row['PostDate'])).' ago';
          echo time_elapsed_string($row['PostDate']);
          ?>
        </p>
      </div>
    </div>
    <br>
  <?php
  }
}
else {
  if(mysqli_error($connection)){
    echo "<p class\"postText\"> Error: " . $GetNewsFeedElements . "<br>" . $NewsFeedResults->num_rows;
  }
}

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      if(isset($_POST['user'])){
        //Set the current page to the new user
        $_SESSION['currentUser'] = strtr($_POST['user'], array('#-#' => '.'));
        echo "<script type=\"text/javascript\"> top.window.location.href = \"profilePage.php\";</script>";
      }else{
        //Run a query to hide the post from view
        $hidePost = "UPDATE Post Set shown=0 WHERE auto_ID=" . $_POST['remove'];
        if(mysqli_query($connection, $hidePost)){
          //Success
          //refresh the page
          echo "<script type=\"text/javascript\"> window.location.href = \"NewsFeed.php\";</script>";

        }else{
          //Failed
          echo "<script type=\"text/javascript\"> window.alert(\"" . mysqli_error($connection). "\");</script>";
        }
      }

    }

//Free the results and close the connection
mysqli_free_result($NewsFeedResults);

//Close the session
session_write_close();

//Close teh connection
$conection->close();

/**
* @Date-Created:        November 27, 2016
* @Date-Last-Modified:  December 01, 2016
* @Author:              Justin Goulet
* @param dateTime -     Mysql formatted time
* @param -              Full Details, or minimal
* @Description:         Format the timing into readable 'time since' event
*/
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

</body>

</html>
