<!DOCTYPE html>

<html lang="en">

<head>
	<title>Edit Profile Picture</title>
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
    $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

    //Check the connection
    if(!$connection){
        die("Connection Failed. Error: " . mysqli_connect_error());
    }

		$currentUser = $_SESSION['currentUser'];
		$signedInUser = $_SESSION['signedInUser'];
?>

<body>
	<?php
	if($currentUser == $signedInUser) :
		?>
	<div class="container">
		<div class="edit-header">
			<div class="box-line"></div>

			<h1>Edit Name</h1>
			<div class="box-line"></div>
		</div>

		<form class="edit-form" id="form" method="POST">
			<div class="outer-section">
				<div class="inner-sections">
					First Name
					<br />
					<input type="text" name="fName" id="fName"/>
					<br /> Last Name
					<br />
					<input type="text" name="lName" id="lName"/>
				</div>
			</div>
			<button type="submit" name='submit' onclick="">Submit</button>
		</form>
<?php

$fNameinput = $_POST['fName'];
$lNameinput = $_POST['lName'];
//if Submit is clicked
if(isset($_POST['submit'])){
		//making sure names are not empty
		if((!empty($fNameinput)) && (!empty($lNameinput))){
			if((preg_match("/^[a-zA-Z'-]+$/",$fNameinput)) && (preg_match("/^[a-zA-Z'-]+$/",$lNameinput))){
				$changeNameQuery = "UPDATE Users SET FName='" . $fNameinput . "', LName='" . $lNameinput . "' WHERE Email='" . $_SESSION['signedInUser'] . "'";
    		if(mysqli_query($connection, $changeNameQuery)){
					//Success. Now, refresh parent page
					echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/profilePage.php\";</script>";
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
			echo "ERROR: First and Last name cannot be empty.";
		}
}
echo "</div>";
endif;
mysqli_close($connection);
?>
</body>

</html>
