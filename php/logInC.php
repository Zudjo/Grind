<?php
  // - REQUIRES -
  // libraries
  require("./php/libraries/dbConnection.php");
  require("./php/libraries/queryHandler.php");
  // classes
  require("./php/classes/User.php");
  require("./php/classes/Trainer.php");
  require("./php/classes/Athlete.php");

  // - MAIN START -

  if (isset($_REQUEST["username"])) {
    $userId = checkLogin($_POST["username"], $_POST["password"]);

    if($userId > 0) {
      session_start();
      $_SESSION["username"] = $_POST["username"];
      $_SESSION["userType"] = $_POST["userType"];
      if ($_POST["userType"] == "trainer") {
        header("Location: ./home-trainer");
      } else {
        header("Location: ./home-athlete");
      }
    } elseif ($userId == -1) {
      $feedback = "<h4>Wrong password. Please try again.</h4>";
    } elseif ($userId == -2) {
      $feedback = "<h4>This account doesn't exist. Please try again.</h4>";
    }
  }

  // - MAIN END -

  // - FUNCTIONS -
  function checkLogin($username, $password) {

    $query = "SELECT athletes_credentials.username, athletes_credentials.password
              FROM athletes_credentials WHERE athletes_credentials.username = \"$username\"
              UNION
              SELECT trainers_credentials.username, trainers_credentials.password
              FROM trainers_credentials WHERE trainers_credentials.username = \"$username\"";

    $result = getQueryResult($query);

    echo is_object($result);


    if (is_object($result) && $result->num_rows === 1) {
      $row = $result->fetch_assoc();
      echo $row["password"];
      echo "<br>";
      echo $password;
      if ($row["password"] === $password) {
        return 1;
      }
      return -1; // Account exists but wrong password
    }

    return -2; // Account doesn't exist
  }
?>
