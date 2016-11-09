<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Sign Up Page</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="../css/UserSignUp.css">


	<!-- Analytics Script -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-83948702-3', 'auto');
  ga('send', 'pageview');

</script>

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

    //var_dump($connection);

    //Change the db to team3
    mysqli_select_db($connection, "team3");

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
    }

    //Close the connection (For Now)
    $connection->close();

?>

    </head>
    <body>

        <div class="container">
            <div class="sign-up-header">
                <div class="box-line"></div>
                <p>
                    Sign Up!
                </p>
                <div class="box-line"></div>
            </div>
            <form class="sign-up-form">
                <div class="outer-section">
                    <div class="inner-sections">
                        Name:
                        <br>
                        <input type="text" name="brewery-name" placeholder=<?php echo "Hello"; ?> >
                    </div>
                    <div class="inner-sections">
                        Address:
                        <br>
                        <input type="text" name="address">
                    </div>
                    <div class="inner-sections">
                        Email:
                        <br>
                        <input type="text" name="brewery-email">
                    </div>
                    <div class="inner-sections">
                        State:
                        <br>
                        <input type="text" name="state">
                    </div>
                    <div class="inner-sections">
                        Password:
                        <br>
                        <input type="password" name="password">
                    </div>
                    <div class="inner-sections">
                        Zip Code:
                        <br>
                        <input type="text" name="zip-code">
                    </div>
                    <div class="inner-sections">
                        Re-Enter Password:
                        <br>
                        <input type="password" name="re-enter-password">
                    </div>
                    <div class="inner-sections">
                        Phone Number:
                        <br>
                        <input type="text" name="phone-number">
                    </div>
                </div>
                <button type="submit" onclick="">Sign-Up</button>
            </form>
        </div>

    </body>
</html>
