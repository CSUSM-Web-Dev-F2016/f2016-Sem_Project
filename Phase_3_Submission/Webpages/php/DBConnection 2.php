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


/* Testing Data Query 
    //Now, Do a sample query
    $sql_GetUser = "SELECT Email, FName, LName FROM Users";
    $result_Query1 = mysqli_query($connection ,$sql_GetUser);
    echo "<br>";

    //If data was retruned, get it 
    if($result_Query1-> num_rows > 0){
    //var_dump($connection);
        //Output data from each row
        while($row = mysqli_fetch_assoc($result_Query1)){
            echo "Email: " . $row["Email"] . "Name: " . $row["FName"] . " " . $row["LName"] . "<br>" ;
        }
    }else{
        echo "No results were found";
    }*/

    //Close the connection (For Now)
    $connection->close();

?>
