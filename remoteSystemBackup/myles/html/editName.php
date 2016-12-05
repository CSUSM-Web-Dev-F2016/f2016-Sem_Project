<!DOCTYPE html>

<html lang="en">

<head>
	<title>Edit Profile Picture</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="../css/EditForm.css" type="text/css">


	<!-- Analytics Script -->
	<script src="../js/analytics.js"></script>
</head>

<?php
    session_start();
		include "../php/LogEvent.php";
	 //Create a basic connection
$connection = include '../php/DBConnectionReturn.php';
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
					CustomLog($connection, $_SESSION['signedInUser'], 'User Action', "Changed name to $fNameinput $lNameinput");
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
else : echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/profilePage.php\";</script>";
endif;
mysqli_close($connection);
?>
</body>

</html>
