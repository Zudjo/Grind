<?php
  $dbServer = "127.0.0.1";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "grind3";

  function connectDb() {
    // Create connection
    $GLOBALS["conn"] = new mysqli($GLOBALS["dbServer"], $GLOBALS["dbUsername"], $GLOBALS["dbPassword"], $GLOBALS["dbName"]);

    // Check connection
    if ($GLOBALS["conn"]->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } else {
      return $GLOBALS["conn"];
    }
  }

  function disconnectDb() {
    $GLOBALS["conn"]->close();
  }

?>
