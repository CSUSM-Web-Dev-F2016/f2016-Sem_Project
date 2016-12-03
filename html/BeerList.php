<!DOCTYPE html>

<html lang="en-us">

    <head>
        <meta charset="utf-8">
        <!-- Link documents to style sheet and JS code -->
        <link rel="stylesheet" href="../css/masterPage.css" type="text/css">
        <script src="../js/loadBeerList.js"></script>
        <script src="../js/contentSwitch.js"></script>
        <link rel="stylesheet" href="../css/PageNotFound.css" type="text/css">
        <!-- Set title of page -->
        <title>Beer List</title>

    </head>

    <body>
      <?php
        //Connect to the DB
        $connection = include '../php/DBConnectionReturn.php';

        //For each beer in the beer list, create a beer view. We are given the breweryID
        $GetBeersFromBrewery = "SELECT * FROM Beers WHERE BreweryID=" . $_GET['breweryID'];
        $GetBeersResults = mysqli_query($connection, $GetBeersFromBrewery);

        if($GetBeersResults->num_rows > 0){
          //Loop trhough all beers, creating a new beer view for each.
          while($row = mysqli_fetch_assoc($GetBeersResults)){
            ?>
            <iframe id="contentFrame" src="../html/BeerInfo.php?BeerID=<?PHP echo $row['BeerID']; ?>" title="BeerView" style="width:100%; padding:0px; margin:0px;" onload="resizeIframe(this);"></iframe>
            <?PHP
          }
        }else{
          echo "<p style=\"color:white;\">No Beers Found</p>";
        }

       ?>
    </body>
</html>
