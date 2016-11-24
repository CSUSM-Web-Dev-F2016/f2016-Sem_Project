

<!-- Nothing going on here.. Just php -->
<?php
     //Start the session in order to access it
     session_start();

     //Reset all session vars
     session_unset();
     session_destroy();

     //The above didn't work.. Let's remove the vars by hand.
     $_SESSION = NULL;

     //Set the new page to the index page
     header("Location: ../index.php");

     exit();
?>
