<!DOCTYPE html>

<html lang="en-us">

<head>
     <!-- This page will display 3 stdSections.
          One is a query for users,
          One is a query for breweries,
          One is a query for beers
          -->
          <!-- get Style Sheets -->
	<link rel="stylesheet" href="../css/masterPage.css" type="text/css">
</head>

<body>

     <!-- The rest is php. Build the tables on the fly -->
     <?php
          session_start();

          //Read the get variable (Should be text)
          echo "<script type=\"text/javascript\">window.alert(\"Beer Found!: " . $_GET['text'] . "\");</script>";
     ?>

</body>



</html>