<!-- Create PHP Login -->
<?php

    //Create a basic connection 
    $connection = mysqli_connect("localhost", "goule001", "goule001");

    //Check the connection
    if(mysqli_connect_errno()){
        die("Connection Failed. ERR: " . mysqli_connect_error());
    }
    //echo "Connected Successfully";
    //This code currently works :)

    //Change the db to team3
    mysqli_select_db($connection, "team3");

    //Return connection variable
    return $connection;

?>
