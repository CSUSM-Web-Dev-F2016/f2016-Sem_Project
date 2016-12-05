<!--
* @Author:              Justin Goulet
* @Date-Last-Modified:  November 28, 2016
* @Date-Created:        November 28, 2016
* @Purpose:             To create a simplified table/form creation process among pages
* @Method:              Read in the data required for the form. This includes:
*                         @param - $ResultsSet  = The set of results gathered from the query
*                         @param - $PK          = The primary key to use when clicked
*                         @param - $PictureURL  = The picture to fill the image circle
*                         @param - $CellName    = The name to display beneath the circle
*                         @param - $FormType    = To know how to redirect the user (Brewery/User)
*                       Once the data is gathered, it is displayed nicely in a form. the
*                       user can then click an item and they will be redirected to the appro.
*                       page.
-->

<?php
  /**
  * @Author:              Justin Goulet
  * @Date-Last-Modified:  November 28, 2016
  * @Date-Created:        November 28, 2016
  * @Purpose:             To create a button in which the user is not redirected, but shown a new frame
  * @Method:              Loop through the provided results and set teh appropriate information.
  *
  * @param - $ResultsSet  = The set of results gathered from the query
  * @param - $PK          = The primary key to use when clicked
  * @param - $PictureURL  = The picture to fill the image circle
  * @param - $CellName    = The name to display beneath the circle
  */
  //Provides a fuction that will create and output a table using a set of parameters
  function createClickableTable($ResultsSet, $PK, $PictureURL, $CellName){

    //Given the results, see if there are a proper number of rows provided.
    //If not, build a custom cell
    if($ResultsSet-> num_rows > 0){
      while($row = mysqli_fetch_assoc($ResultsSet)){
        //There are rows
        echo '<div class="smalltableCell">';
          echo "<a onclick=\"showBeerView(" . $row[$PK] . ")\">";
            echo '<div class="tableCell img">';
              echo	"<img class=\"smalltableCell\" src=\"" .  $row[$PictureURL] . "\"alt=\"" . $row[$CellName] . "\">";
            echo "</div>";
            echo "<div class=\"smalltableCell title\" style=\"padding-bottom:5px;\">" . $row[$CellName] . "</div>";
          echo "</a>";
        echo "</div>";
      }
    }else{
      //No rows yet; inform user;
      echo '<div class="smalltableCell">';
          echo "<a onclick=\"return false;\">";
            echo '<div class="tableCell img">';
              echo	"<img class=\"smalltableCell\" src=\"" .  "http://beerhopper.me/img/x.png" . "\"alt=\"" . "" . "\">";
            echo "</div>";
            echo "<div class=\"smalltableCell title\">" . "No Beers Yet" . "</div>";
          echo "</a>";
        echo "</div>";
    }

    //Free the results
    mysqli_free_result($ResultsSet);
  }

    /**
    * @Author:              Justin Goulet
    * @Date-Last-Modified:  November 28, 2016
    * @Date-Created:        November 28, 2016
    * @Purpose:             To create a form that redirects the user
    * @Method:              Loop the results and make a form for each. On click, the user is redirected.
    *
    * @param - $ResultsSet  = The set of results gathered from the query
    * @param - $PK          = The primary key to use when clicked
    * @param - $PictureURL  = The picture to fill the image circle
    * @param - $CellName    = The name to display beneath the circle
    * @param - $FormType    = To know how to redirect the user (Brewery/User)
    */
  function createBasicForm($ResultsSet, $PK, $PictureURL, $CellName, $FormType){
    if($ResultsSet-> num_rows > 0 ){
      //If there are some rows, loop through them
      while($row = mysqli_fetch_assoc($ResultsSet)){
        //Create a new element per row
        echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"" . $FormType . "\" >";
          echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"" . $FormType . "\">";
            echo "<div class=\"tableCell img\">";
              echo "<img class=\"smalltableCell\" src=\"" . $row[$PictureURL] . "\" alt=\"" . $row[$CellName] . "\">";
            echo "</div>";
            echo "<div class=\"smalltableCell title\" style=\"padding-bottom:0px; max-height:50px;\">" . $row[$CellName] . "</div>";
          echo "</button>";
          echo "<input type=\"hidden\" name=\"" . strtr($row[$PK], array('.' => '#-#')) . "\" value=\"\">";
        echo "</form>";
      }

      //Free the results
      mysqli_free_result($ResultsSet);

    }else{
      //Just print a text saying 'no items found';
      echo "<form action=\"\" class=\"stdForm\" name=\"user\" onsubmit=\"return false;\">";
          echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"\">";
            echo "<div class=\"tableCell img\">";
              echo "<img class=\"smalltableCell\" src=\"" . "http://beerhopper.me/img/x.png" . "\" alt=\"" . "" . "\">";
            echo "</div>";
            echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . "Not Followed By Anyone" . "</div>";
          echo "</button>";
        echo "</form>";
    }
  }

  function searchResultsTable($ResultsSet, $PK, $PictureURL, $CellName, $FormType){

    if($FormType === 'user'){
      $buttonName = $row[$PK];
    }else{
      $buttonName = $FormType;
    }

    if($ResultsSet-> num_rows > 0 ){
      //If there are some rows, loop through them
      while($row = mysqli_fetch_assoc($ResultsSet)){
        //echo "<script type=\"text/javascript\">window.alert(\"User Found: " . $row['UserEmail'] . "\");</script>";

        echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"" . $FormType . "\">";
          echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"" . $buttonName . "\">";
            echo "<div class=\"tableCell img\">";
              echo "<img class=\"smalltableCell\" src=\"" . $row[$PictureURL] . "\" alt=\"" . $row[$CellName] . "\">";
            echo "</div>";
            echo "<div class=\"smalltableCell title\" style=\"padding-top:10px; padding-bottom:15px; max-height:50px;\">" . $row[$CellName] . "</div>";
          echo "</button>";
          echo "<input type=\"hidden\" name=\"" . strtr($row[$PK], array('.' => '#-#')) . "\" value=\"\">";
        echo "</form>";

        //echo "<p style=\"color:white\">" . $row['UserEmail'];
      }

      //Clear the results
      mysqli_free_result($ResultsSet);

    }
    else{
      //Just print a text saying 'no items found';
      echo "<form action=\"\" class=\"stdForm\" name=\"user\" onsubmit=\"return false;\">";
          echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"\">";
            echo "<div class=\"tableCell img\">";
              echo "<img class=\"smalltableCell\" src=\"" . "http://beerhopper.me/img/x.png" . "\" alt=\"" . "" . "\">";
            echo "</div>";
            echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . "No " . $CellName . "'s Found!" . "</div>";
          echo "</button>";
        echo "</form>";
    }
  }

  function beersSearchTable($ResultsSet){
    if($ResultsSet-> num_rows > 0){
       //Use a while loop to build the form

       while($row = mysqli_fetch_assoc($ResultsSet)){
         echo "<form action=\"\" class=\"stdForm\" method=\"POST\" name=\"beer\">";
           echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"beer\">";
             echo "<div class=\"tableCell img\">";
               echo "<img class=\"smalltableCell\" src=\"" . $row['PictureURL'] . "\" alt=\"" . $row['BeerName'] . "\">";
             echo "</div>";
             echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . $row['BeerName'] . "</div>";
           echo "</button>";
           echo "<input type=\"hidden\" name=\"beerID\" value=\"" . $row['BeerID'] . "\">";
         echo "</form>";
       }

       //Free the memory
       mysqli_free_result($ResultsSet);

     }else{
       //Build custom when no rows are found
       echo "<form action=\"\" class=\"stdForm\" name=\"beer\" onsubmit=\"return false;\">";
           echo "<button type=\"submit\" class=\"defaultSetBtn\" name=\"" . "" . "\">";
             echo "<div class=\"tableCell img\">";
               echo "<img class=\"smalltableCell\" src=\"" . "http://beerhopper.me/img/x.png" . "\" alt=\"" . "" . "\">";
             echo "</div>";
             echo "<div class=\"smalltableCell title\" style=\"padding-bottom:15px; max-height:50px;\">" . "No Beers Found!" . "</div>";
           echo "</button>";
           //echo "<input type=\"hidden\" name=\"brewery\" value=\"\">";
         echo "</form>";
     }
  }




 ?>
