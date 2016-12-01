<!DOCTYPE html>

<html lang="en">
<head>
    <title>Edit Cover Photo</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/EditForm.css" type="text/css">


	<!-- Analytics Script -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-83948702-3', 'auto');
  ga('send', 'pageview');

</script>
</head>
<?php
    session_start();
	 //Create a basic connection
  $connection = include '../php/DBConnectionReturn.php';


  $getOwnerQuery = "SELECT UserEmail FROM BreweryOwner WHERE BreweryID=" . $_GET['BreweryID'];
  $resultOwner = mysqli_query($connection,$getOwnerQuery);
  $row=mysqli_fetch_assoc($resltOwner);
  $owneremail = $row["UserEmail"];

  $currentUser = $_SESSION['currentUser'];
  $signedInUser = $_SESSION['signedInUser'];

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


  $coverURL = $_POST['coverURL'];
echo "current: $currentUser <br>";
echo "signed in: $signedInUser <br>";
echo "owner: $owneremail <br>";
echo "ID: $id";
mysqli_close($connection);
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
