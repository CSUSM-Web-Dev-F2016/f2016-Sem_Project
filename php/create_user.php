<?php
/**
 * Created by PhpStorm.
 * User: chrislarsen
 * Date: 11/17/16
 * Time: 3:00 PM
 */



                //Define variables and set to empty values
                $FName = $LName = $birthday = $Email  = $Password = $Password2 = $ZipCode = $ProfilePicURl = "";

                //Creates user after checking form input
                function createUser(){
                    echo "Creating User";
                    //Create the user in an SQL Command, tehn, log them in.
                    $createUserQuery = "INSERT INTO Users (Email, Password, FName, LName, DOB, ProfilePicURL) VALUES ('" . $Email . "', '" . $Password . "', '" . $FName . "', '" . $LName . "', '" . $birthday . "', '" . $ProfilePicURl . "')";

                    // get database connection
                    $connection = include 'DBConnectionReturn.php';

                    if(mysqli_query($connection, $createUserQuery)){
                        //The item was successfull created, now change the login page.
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
                        }else{
                            echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">Error Checking age<b>";
                        }
                    }else{
                        echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">Error with creating account: <br>" . $connection->error . "</p>";
                    }
                    $connection ->close();
                }

                //Checks form input
                function test_input($data) {
                    $data = trim($data);            // Remove whitespace from both ends of text
                    $data = stripslashes($data);    // Removes all slashes from text
                    $data = htmlspecialchars($data);// Sets special chars
                    return $data;                   // Return results
                }

                //Before the info is sent, we want to check all the vars
                if($_SERVER["REQUEST_METHOD"] == "POST"){

                    $errorString = "";
                    //Verify that none are empty. If they are, echo it on the screen using a massive string
                    //Check the first name
                    if(empty($_POST["name"])){
                        $errorString = $errorString . "First Name is required.<br>";
                    }else{
                        $FName = test_input($_POST["name"]);
                    }

                    //Check the last name
                    if(empty($_POST["LName"])){
                        $errorString = $errorString . "Last Name is required.<br>";
                    }else{
                        $LName = test_input($_POST["LName"]);
                    }

                    //Check the birthday
                    if(empty($_POST["birthday"])){
                        $errorString = $errorString . "A Birthday is required (21+ Only)<br>";
                    }else{
                        //Do the parsing here for dob
                        $birthday = test_input($_POST["birthday"]);
                    }

                    //Check the email.. This is imperitive
                    if(empty($_POST["email"])){
                        $errorString = $errorString . "Email is required. We will not SPAM.<br>";
                    }else{
                        $Email = test_input($_POST["email"]);
                    }

                    //Verify the password. They must also be equal
                    if(empty($_POST["password"])){
                        $errorString = $errorString . "Password is required.<br>";
                    }else{
                        $Password = test_input($_POST["password"]);
                    }
                    if(empty($_POST["re-enter-password"])){
                        $errorString = $errorString . "Verify your password<br>";
                    }else{
                        $Password2 = test_input($_POST["re-enter-password"]);
                    }
                    if($Password != $Password2){
                        $errorString = $errorString . "Passwords do not match<br>";
                    }


                    //Get the profile pic url (optional)
                    if(empty($_POST["ProfilePicURL"])){
                        //$errorString = $errorString . "State is required to find breweries near you.<br>";
                        $ProfilePicURl = "https://pbs.twimg.com/profile_images/1665394718/image.jpg";
                    }else{
                        $ProfilePicURl = test_input($_POST["ProfilePicURL"]);
                    }

                    //Display the error string
                    echo "<p style=\"text-align:center; color:red; width:100%; font-size:18px;\">" . $errorString . "</p>";

                    //If the length of the error string is 0, create user.
                    if(strlen($errorString) == 0){
                        $FName = $_POST["FName"];
                        $LName = $_POST["LName"];
                        $Password = $_POST["password"];
                        $Email = $_POST["email"];


                    }
                }