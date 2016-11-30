<!-- Create PHP Login -->
<?php

    //Create a basic connection
    $connection = mysqli_connect("localhost", "goule001", "goule001", "team3");

    //Check the connection
    if(mysqli_connect_errno()){
        die("Connection Failed. ERR: " . mysqli_connect_error());
    }


    function closeConnection(){
      mysqli_close($connection);
    }

    function clearVar($var){
      mysqli_free_result($var);
    }
?>
