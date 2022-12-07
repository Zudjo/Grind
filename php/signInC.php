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

  if (isset($_POST["firstname"])) {
    if (isUsernameAvailable($_POST["username"])) {
      if ($_POST["password"] == $_POST["passwordCheck"]) {
        if ($_POST["userType"] == "athlete") {
          if (isTrainerTokenAvailable($_POST["trainerToken"])) {
            $athleteId = getFirstIdAvailable("athletes", "athleteId");
            $user = new Athlete($_POST["firstname"], $_POST["lastname"], $_POST["birthDate"],
            $_POST["email"], $_POST["username"], $_POST["password"], $athleteId, $_POST["trainerToken"]);
          } else {
            $feedback = "<h4>This trainer token doesn't exist.</h4>";
          }
        } else {
          $trainerId = getFirstIdAvailable("trainers", "trainerId");
          $user = new Trainer($_POST["firstname"], $_POST["lastname"], $_POST["birthDate"],
          $_POST["email"], $_POST["username"], $_POST["password"], $trainerId, $_POST["trainerToken"]);
        }
        if ($feedback != "<h4>This trainer token doesn't exist.</h4>") {
          if ($user->addToDb()) $feedback = "<h4>Account created.</h4>";
          else $feedback = "<h4>Something went wrong.</h4>";
        }
      } else $feedback = "<h4>Passwords don't match.</h4>";
    } else $feedback = "<h4>This username is taken.</h4>";
  } else $feedback = "";

  // - MAIN END -

  // - FUNCTIONS -
  function isUsernameAvailable($username) {
    $query = "SELECT athletes_credentials.Username\n"
    . "FROM athletes_credentials\n"
    . "WHERE athletes_credentials.Username = \"$username\"\n"
    . "UNION\n"
    . "SELECT trainers_credentials.Username\n"
    . "FROM trainers_credentials\n"
    . "WHERE trainers_credentials.Username = \"$username\";";

    $result = getQueryResult($query);

    if(is_object($result) && $result->num_rows > 0) {
      return false; // Returns false if it is not available
    }

    return true; // Returns true if it is available
  }

  function getTrainerIdFromToken($trainerToken) {
    $query = "SELECT trainerId FROM trainers WHERE trainerToken = $trainerToken";

    $result = getQueryResult($query);

    if (is_object($result) and $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $id = $row["trainerId"];
      return $id;
    }

    return false;
  }

  function isTrainerTokenAvailable($trainerToken) {
    $query = "SELECT trainerToken FROM trainers WHERE trainerToken = \"$trainerToken\"";

    $result = getQueryResult($query);

    if(is_object($result) && $result->num_rows == 1) {
      return true;
    }

    return false;
  }


?>
