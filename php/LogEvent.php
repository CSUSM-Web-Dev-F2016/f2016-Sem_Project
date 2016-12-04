<?php

//Used for loggine EventBase
function CustomLog($connection, $user, $LogType, $LogEvent){

  //Now, run the query to the log file
  $logQuery = "INSERT INTO Log_History VALUES (NULL, NOW(), '" . $user . "', '" . $LogType . "', '" . $LogEvent . "', NULL)";
  //$logQuery = "INSERT INTO Log_History VALUES (NULL, NOW(), 'jstngoulet@me.com', 'Test', 'This is just to test basic Logging')";
  if(!mysqli_query($connection, $logQuery)){
    //return false;
  }

  //return true;
  return true;
}



 ?>
