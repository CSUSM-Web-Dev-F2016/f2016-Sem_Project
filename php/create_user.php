<?php
session_start();
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
    $createUserQuery = "INSERT INTO Users (Email, Password, FName, LName, DOB, ProfilePicURL, LastLogin)
        VALUES ('" . $Email . "', '" . $Password . "', '" . $FName . "', '" . $LName . "', '" . $birthday . "', '" . $ProfilePicURl . "', UTC_TIMESTAMP())";

    // get database connection
    $connection = include 'DBConnectionReturn.php';

    if(mysqli_query($connection, $createUserQuery)){
        //The item was successful created, now change the login page.
<<<<<<< HEAD
        echo "<p style=\"text-align:center; color:green; width:100%; font-size:18px;\">Successfully inserted data: $Email</p>";
        $_SESSION['currentUser'] = $_SESSION['signedInUser'] = $Email;

        //Now, set the authorization token value so we know the user is logged in
=======
        $_SESSION['currentUser'] = $_SESSION['signedInUser'] = $Email;

        //Now, set the autoriazation token value so we know the user is logged in
>>>>>>> master
        $_SESSION['loginToken'] = "yes";

        //Redirect to the main profile page
        header('Location: ../html/profilePage.php');
        exit();

    }else{
        echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">Error with creating account: <br>" . $connection->error . "</p>";
    }
    $connection->close();
<<<<<<< HEAD
}
=======
}
>>>>>>> master
