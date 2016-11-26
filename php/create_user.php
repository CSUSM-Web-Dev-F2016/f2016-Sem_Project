<?php
/**
 * Created by PhpStorm.
 * User: chrislarsen
 * Date: 11/17/16
 * Time: 3:00 PM
 */

//Creates user
/**
 * @param $FName
 * @param $LName
 * @param $birthday
 * @param $Email
 * @param $Password
 * @param $ProfilePicURl
 */
function createUser($FName, $LName, $birthday, $Email, $Password, $ProfilePicURl){
    echo "Creating User";
    //Create the user in an SQL Command, tehn, log them in.
    $createUserQuery = "INSERT INTO Users (Email, Password, FName, LName, DOB, ProfilePicURL)
        VALUES ('" . $Email . "', '" . $Password . "', '" . $FName . "', '" . $LName . "', '" . $birthday . "', '" . $ProfilePicURl . "')";

    // get database connection
    $connection = include 'DBConnectionReturn.php';

    if(mysqli_query($connection, $createUserQuery)){
        //The item was successful created, now change the login page.
        echo "<p style=\"text-align:center; color:green; width:100%; font-size:18px;\">Successfully inserted data</p>";

        //Now that user is created, only take them further if they are over 21.
        //Create a query to see if there are in the view
        $ageQuery = "SELECT Current_Age FROM valid_Users WHERE Email='" . $Email . "'";

        //Run the query. If no rows are returned, they must be too young (since we just created it);
        if($result = mysqli_query($connection, $ageQuery)){
            //Success, tak them to the main profile page., if there are more than 1 row
            if($result-> num_rows > 0){
                session_start();
                $_SESSION['currentUser'] = $_SESSION['signedInUser'] = $Email;
                header("Location:  ./profilePage.php");
            }else {
                echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">User is not yet 21. Please come back when you are.<b>";
            }

            //Free the result
            mysqli_free_result($result);
        }else{
            echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">Error Checking age<b>";
        }
    }else{
        echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">Error with creating account: <br>" . $connection->error . "</p>";
    }

    //Close the conection
    $connection ->close();
}
