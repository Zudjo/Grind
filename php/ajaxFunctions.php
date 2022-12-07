<?php

// REQUIRES
// libraries
require("./libraries/dbConnection.php");
require("./libraries/queryHandler.php");
// classes
require("./classes/Program.php");
require("./classes/Session.php");
require("./classes/Exercise.php");

require("./classes/User.php");
require("./classes/Athlete.php");
require("./classes/Trainer.php");

// Executing the function in the "func" parameter
$_POST["func"]();

function printProgramsSelect() {
  $athleteId = $_POST["athleteId"];

  if ($athleteId != "") {
    $athlete = getUserObjectFromId($athleteId, "athlete");

    echo "<option value=-1>-- Select program --</option>";

    $athlete->printProgramsSelect();
  }
}

function printSessionsSelect() {
  $programId = $_POST["programId"];

  if ($programId != "") {
    $program = getProgramFromId($programId);

    if ($program) {
      echo "<option value=\"-1\">-- Select session --</option>";
      $program->printSessionsIdsAsOptions();
    } else {
      echo "No sessions found";
    }
  }




}

function printProgram() {
  $programId = $_POST["programId"];

  if ($programId != "") {
    $result = getAthleteProgramFromId($programId);

    if ($result) {
      $programs = getProgramObjectsArrayFromResult($result);
      printPrograms($programs);
    } else {
      echo "No programs found";
    }
  }
}

function printExerciseFactors() {
  $programId = $_POST["programId"];

  if ($programId != "") {
    $result = getAthleteProgramFromId($programId);

    if ($result) {
      $program = getProgramObjectFromResult($result);
      $nWeeks = $program->nWeeks;
      printExercisesFactors($nWeeks);

    } else {
      echo "No programs found";
    }
  }
}

// ----------------------

function getAthleteProgramsFromAthleteId($athleteId) {
  $query= "SELECT * FROM programs WHERE athleteId = $athleteId";

  $result = getQueryResult($query);

  if (is_object($result) && $result->num_rows > 0) {
    return $result;
  } else {
    return false;
  }
}

function getAthleteProgramFromId($programId) {
  $query = "SELECT * FROM programs WHERE programId = $programId";

  $result = getQueryResult($query);

  if (is_object($result) && $result->num_rows == 1) {
    return $result;
  } else {
    return false;
  }
}

function getProgramObjectsArrayFromResult($result) {
  while ($row = $result->fetch_assoc()) {
    $programs[] = new Program($row["programId"], $row["trainerId"], $row["athleteId"], $row["target"], $row["nWeeks"], $row["nSessions"]);
  }
  return $programs;
}

function getProgramObjectFromResult($result) {
  $row = $result->fetch_assoc();

  $program = new Program($row["programId"], $row["trainerId"], $row["athleteId"], $row["target"], $row["nWeeks"], $row["nSessions"]);

  return $program;
}

function printPrograms($programs) {
  foreach ($programs as $key => $program) {
    require("../templates/program.php");
  }
}

function printExercisesFactors($nWeeks) {
  for ($i=1; $i <= $nWeeks; $i++) {
    echo "<b>Week " . $i . "</b><br>";
    require("../templates/exerciseFactors.php");
    echo "<br><br>";
  }
}

?>
