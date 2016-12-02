<!DOCTYPE html>

<html lang="en">
<head>
    <title>Edit Cover Photo</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/EditForm.css" type="text/css">


	<!-- Analytics Script -->
  <script src="../js/analytics.js"></script>
  
</head>
<?php
    session_start();
	 //Create a basic connection
    $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

    //Check the connection
    if(!$connection){
        die("Connection Failed. Error: " . mysqli_connect_error());
    }
?>
<body>
    <div class="container">
        <div class="edit-header">
            <div class="box-line"></div>

            <h1>Edit Cover Photo</h1>
            <div class="box-line"></div>
        </div>

            <form class="edit-form" id="form" method="POST">
                <div class="outer-section">
                    <div class="inner-sections">
                        Enter link to cover photo (.jpg or .png)
                        <br />
                        <input type="text" name="coverURL" title="Cover link"/>
                    </div>
                </div>
                <button type="submit" name="submit" onclick="">Submit</button>
            </form>
<?php

  $currentUser = $_SESSION['currentUser'];
  $signedInUser = $_SESSION['signedInUser'];
  $coverURL = $_POST['coverURL'];
echo "current: $currentUser ";
echo "signed in: $signedInUser";
 /*
  //if Submit is clicked
  if(isset($_POST['submit'])){
  //check if user is on own page
    if(($currentUser == $signedInUser)){
	     //making sure names are not empty
       if((strpos($picURL, '.png') !== false) || (strpos($picURL, '.jpg') !== false)){
	        $changeNameQuery = "UPDATE Users SET FName='" . $fNameinput . "', LName='" . $lNameinput . "' WHERE Email='" . $_SESSION['signedInUser'] . "'";
            if(mysqli_query($connection, $changeNameQuery)){
              echo "Updated cover photo successfully.";

              //Now, refresh parent page
              //echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/breweryPage.php\";</script>";
              }
              else {
                echo "Error updating cover photo.";
              }
            }
            else {
              echo "ERROR: Picture extension must be .png or .jpg.";
            }

          }
          else {
            echo "ERROR: You are not the owner of this page.";
          }
        }
        mysqli_close($connection);
*/
?>
    </div>
</body>
</html>
