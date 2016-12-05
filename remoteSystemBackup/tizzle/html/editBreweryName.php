<html lang="en">

<head>
	<title>Edit Brwery Name</title>
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

			<h1>Edit Brewery Name</h1>
			<div class="box-line"></div>
		</div>

		<form class="edit-form" id="form" method="POST">
			<div class="outer-section">
				<div class="inner-sections">
					Brewery Name
					<br />
					<input type="text" name ="bName" title="bName" />
				</div>
			</div>
			<button type="submit" name="submit" onclick="">Submit</button>
		</form>

<?php
    $brewName = $_POST['bName'];
      //if Submit is clicked
      if(isset($_POST['submit'])){
				if(!empty($brewName)){
					if(preg_match("/^[a-zA-Z0-9.' -]+$/",$brewName)){
						$changeBreweryNameQuery = "UPDATE BreweryTable SET BreweryName ='" . $brewName . "' WHERE BreweryID=$id";
		    		if(mysqli_query($connection, $changeBreweryNameQuery)){
							//Success. Now, refresh parent page
							echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/breweryPage.php?id=$id\";</script>";
		    		}
		      	else {
		        	echo "Error updating record.";
		      	}
					}
					else {
						echo "ERROR: Invalid name entered.";
					}
					}
				else {
					echo "ERROR: Brewery name cannot be empty.";
				}
	}

    echo "</div>";
    endif;
    mysqli_close($connection);
    ?>
</body>

</html>
