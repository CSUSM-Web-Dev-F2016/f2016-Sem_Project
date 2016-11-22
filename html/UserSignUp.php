<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Sign Up Page</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="../css/UserSignUp.css">
        <link rel="stylesheet" type="text/css" href="../css/backgroundVideo.css">

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
    <body>
      <div class="is_overlay">
          <img src="http://beerhopper.me/img/bckImg.jpg" alt="Background img">
      </div>

      <div class="centerDiv">
          <div class="grid">
              <?php
                include '../php/create_user.php';

              // calls user that creates user in the db
              createUser();

              ?>

          </div>

        </div>

    </body>
</html>
