<!DOCTYPE html>

<html lang="en">
<head>
    <title>Edit Brewery Profile Picture</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/EditForm.css" type="text/css">
    <!-- Analytics Script -->
    <script src="../js/analytics.js"></script>
</head>

<?php
/**
 * Created by PhpStorm.
 * User: chrislarsen
 * Date: 12/3/16
 * Time: 6:34 PM
 */

session_start();
//Create a basic connection
$connection = include '../php/DBConnectionReturn.php';
$id = $_GET['id'];

$getOwnerQuery = "SELECT UserEmail FROM BreweryOwner WHERE BreweryID=$id";
$resultOwner = mysqli_query($connection,$getOwnerQuery);
$row=mysqli_fetch_assoc($resultOwner);
$ownerEmail = $row["UserEmail"];

$signedInUser = $_SESSION['signedInUser'];
?>

<body>
<?php
    if(($ownerEmail == $signedInUser)):
?>
<div class="container">
    <div class="edit-header">
        <div class="box-line"></div>

        <h1>Edit Brewery Hours</h1>
        <div class="box-line"></div>
    </div>
    <form class="edit-form" id="editHoursForm" method="POST">
        <div class="outer-section">
            <div class="inner-sections">
                Enter the hours for your brewery:
                <br><input type="text" name="mo" title="Monday"/>
                <br><input type="text" name="tu" title="Tuesday"/>
                <br><input type="text" name="we" title="Wednesday"/>
                <br><input type="text" name="th" title="Thursday"/>
                <br><input type="text" name="fr" title="Friday"/>
                <br><input type="text" name="sat" title="Saturday"/>
                <br><input type="text" name="sun" title="Sunday"/>
            </div>
        </div>
        <button type="submit" name="submit" onclick="">Submit</button>
    </form>
    <?php
    $picURL = $_POST['picURL'];
    if(isset($_POST['submit'])){
        //making sure URL has .png or .jpg extension
        if((strpos($picURL, '.png') !== false) || (strpos($picURL, '.jpg') !== false)){
            $changePicQuery = "UPDATE BreweryTable SET ProfilePicURL='" . $picURL . "' WHERE BreweryID=$id";
            if(mysqli_query($connection, $changePicQuery)){
                //Updated. Now, refresh parent page
                echo "<script type=\"text/javascript\"> top.window.location.href = \"../html/breweryPage.php?id=$id\";</script>";
            }
            else {
                echo "Error updating brewery picture.";
            }
        }
        else {
            echo "ERROR: Picture extension must be .png or .jpg.";
        }

    }
    echo "</div>";
    endif;
    mysqli_close($connection);
    ?>
</body>
</html>
