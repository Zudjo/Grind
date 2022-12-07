<?php

  // - REQUIRES -
  // libraries
  require("./php/libraries/dbConnection.php");
  require("./php/libraries/queryHandler.php");
  // classes
  require("./php/classes/User.php");
  require("./php/classes/Trainer.php");
  require("./php/classes/Athlete.php");

  require("./php/classes/Program.php");
  require("./php/classes/Session.php");
  require("./php/classes/Exercise.php");

  // - MAIN START -
  session_start();
  $username = $_SESSION["username"];
  $userType = $_SESSION["userType"];

  $trainer = getUserObjectFromUsername($username, $userType);

  if (isset($_POST["target"])) { // Add program
    addProgram($trainer);
  }

  if (isset($_POST["muscle"])) { // Add exercise
    addExercise();
  }

  // - MAIN END -

  // - FUNCTIONS -
  function addProgram($trainer) {
    $program = new Program(null, $trainer->getTrainerId(), $_POST["athleteId"], $_POST["target"], $_POST["nWeeks"], $_POST["nSessions"]);

    if($program->addToDb()){
      $program->addSessionsToDb();
      //header("Location: ./home-trainer");
      echo "Program added.";
    }

  }

  function addExercise() {
    foreach ($_POST["series"] as $key => $value) {
      $exercise = new Exercise(null, $_POST["sessionId"], $_POST["muscle"][$key],
        $_POST["name"][$key], $_POST["series"][$key], $_POST["repetitions"][$key],
        $_POST["seconds"][$key], $_POST["weight"][$key], $_POST["rpe"][$key],
        $_POST["recovery"][$key], $_POST["notes"][$key], $key+1);

        if(!$exercise->addToDb()) {
          //header("Location: ./home-trainer");
          echo "Something went wrong.";
          return false;
        }
    }
    echo "Exercise added.";


  }

  // getters
  function getAthleteProgramsFromId($athleteId) {
    $query= "SELECT * FROM programs WHERE athleteId = $athleteId";

    $result = getQueryResult($query);

    if (is_object($result) && $result->num_rows > 0) return $result;
    else return false;
  }

?>
