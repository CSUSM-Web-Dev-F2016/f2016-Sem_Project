<!DOCTYPE html>
<html lang="en">

<head>
	<title>Brewery Sign Up Page</title>
	<meta name="description" content="Create your own Brewery" />
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/BrewerySignUp.css">


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
	 //Create a basic connection
    $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

    //Check the connection
    if(mysqli_connect_errno()){
        die("Connection Failed. ERR: " . mysqli_connect_error());
    }
    //echo "Connected Successfully";
    //This code currently works :)
?>
<body>

	<div class="holder">
		<div class="container">
			<div class="sign-up-header">
				<div class="box-line"></div>
				<p>
					Sign Up Your Brewery
				</p>
				<div class="box-line"></div>
			</div>
			<form class="sign-up-form">
				<div class="outer-section">
					<div class="inner-sections">
						Brewery Name:
						<br>
						<input type="text" name="brewery-name">
					</div>
					<div class="inner-sections">
						Address:
						<br>
						<input type="text" name="address">
					</div>
					<div class="inner-sections">
						Brewery Email:
						<br>
						<input type="text" name="brewery-email">
					</div>
					<div class="inner-sections">
						State:
						<br>
						<input type="text" name="state">
					</div>
					<div class="inner-sections">
						Password:
						<br>
						<input type="password" name="password">
					</div>
					<div class="inner-sections">
						Zip Code:
						<br>
						<input type="text" name="zip-code">
					</div>
					<div class="inner-sections">
						Re-Enter Password:
						<br>
						<input type="password" name="re-enter-password">
					</div>
					<div class="inner-sections">
						Phone Number:
						<br>
						<input type="text" name="phone-number">
					</div>
				</div>
				<button type="submit" onclick="">Sign-Up</button>
			</form>

			<!-- PHP for button action to create account -->
			<?php

			function createUserAccount(){
				//Create a user account if all forms are correctly filled out

			}
			?>
		</div>
	</div>

</body>

</html>
