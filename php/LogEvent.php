<?php

//Used for loggine EventBase
function CustomLog($connection, $user, $LogType, $LogEvent){

  //Now, run the query to the log file
  $logQuery = "INSERT INTO Log_History (Date_Submitted, UserEmail, LogType, LogEvent)
                VALUES (NOW(), '" . $user . "', '" . htmlspecialchars($LogType, ENT_QUOTES) . "', '" . htmlspecialchars($LogEvent, ENT_QUOTES) . "')";
  if(mysqli_query($connection, $logQuery)){
    //echo "<script type=\"text/javascript\">top.window.alert(\"Log Success\");</script>";
  }else{
      echo "<script type=\"text/javascript\">top.window.alert(\"Log Failed: " . $logQuery . "\");</script>";
  }

}



 ?>
