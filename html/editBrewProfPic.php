<!DOCTYPE html>

<html lang="en">
<head>
    <title>Edit Brewery Profile Picture</title>
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
    $id = $_GET['id'];

    $getOwnerQuery = "SELECT UserEmail FROM BreweryOwner WHERE BreweryID=$id";
    $resultOwner = mysqli_query($connection,$getOwnerQuery);
    $row=mysqli_fetch_assoc($resultOwner);
    $ownerEmail = $row["UserEmail"];

    $signedInUser = $_SESSION['signedInUser'];
?>

<body>
  <?php
  if(($ownerEmail == $signedInUser)):
    ?>
    <div class="container">
        <div class="edit-header">
            <div class="box-line"></div>

            <h1>Edit Brewery Profile Picture</h1>
            <div class="box-line"></div>
        </div>
            <form class="edit-form" id="form" method="POST">
                <div class="outer-section">
                    <div class="inner-sections">
                        Enter link to brewery profile picture (.jpg or .png)
                        <br />
                        <input type="text" name="picURL" title="Profile Link"/>
                    </div>
                </div>
                <button type="submit" name="submit" onclick="">Submit</button>
            </form>
<?php
  $picURL = $_POST['picURL'];
  if(isset($_POST['submit'])){
            		//making sure URL has .png or .jpg extension
	        if((strpos($picURL, '.png') !== false) || (strpos($picURL, '.jpg') !== false)){
            	$changePicQuery = "UPDATE BreweryTable SET ProfilePicURL='" . $picURL . "' WHERE BreweryID=$id";
              if(mysqli_query($connection, $changePicQuery)){
            					//Updated. Now, refresh parent page
        				echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/breweryPage.php?id=$id\";</script>";
        		    }
              else {
                echo "Error updating brewery picture.";
            	}
          }
    		else {
          echo "ERROR: Picture extension must be .png or .jpg.";
    		}

  }
  echo "</div>";
  else : echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/breweryPage.php?id=$id\";</script>";
  endif;
  mysqli_close($connection);
  ?>
</body>
</html>
