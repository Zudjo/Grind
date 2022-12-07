<?php


  // - VARIABLES -
  $feedback = "";

  // - FUNCTIONS -
  function getQueryResult($query) {
    connectDb();

    $result = $GLOBALS["conn"]->query($query);

    disconnectDb();
    return $result;

  }


  function escapeArguments($arguments) {
    connectDb();
    $i = 0;
    foreach ($argument as $value) {
      if (gettype($value) == "string") $argument[$i] = $GLOBALS["conn"]->real_escape_string($value);
    }
    disconnectDb();
    return $arguments;
  }

  function getUserObjectFromUsername($username, $userType) {
    $query = "SELECT username FROM $userType" . "s_credentials WHERE username = \"$username\"";

    $result = getQueryResult($query);

    if (is_object($result) and $result->num_rows == 1) {

      $query = "SELECT firstname, lastname, birthDate, email, username, password, $userType" . "s." . "$userType" . "Id, trainerToken FROM $userType" . "s_credentials JOIN $userType" . "s WHERE username = \"$username\"";
      $result = getQueryResult($query);
      $row = $result->fetch_assoc();

      if ($userType == "trainer") {
        $user = new Trainer($row["firstname"], $row["lastname"], $row["birthDate"], $row["email"], $row["username"], $row["password"], $row["trainerId"], $row["trainerToken"]);
      } else {
        $user = new Athlete($row["firstname"], $row["lastname"], $row["birthDate"], $row["email"], $row["username"], $row["password"], $row["athleteId"], $row["trainerToken"]);
      }
      return $user;
    }

    return false;
  }

  function getUserObjectFromId($id, $userType) {
    $query = "SELECT $userType" . "Id FROM $userType" . "s_credentials WHERE $userType" . "Id = $id";

    $result = getQueryResult($query);

    if (is_object($result) and $result->num_rows == 1) {

      $query = "SELECT firstname, lastname, birthDate, email, username, password, $userType" . "s." . "$userType" . "Id, trainerToken
        FROM $userType" . "s_credentials JOIN $userType" . "s ON $userType" . "s_credentials.$userType" . "Id = $userType" . "s.$userType" . "Id
        WHERE $userType" . "s." . "$userType" . "Id = $id";
      $result = getQueryResult($query);
      $row = $result->fetch_assoc();

      if ($userType == "trainer") {
        $user = new Trainer($row["firstname"], $row["lastname"], $row["birthDate"], $row["email"], $row["username"], $row["password"], $row["trainerId"], $row["trainerToken"]);
      } else {
        $user = new Athlete($row["firstname"], $row["lastname"], $row["birthDate"], $row["email"], $row["username"], $row["password"], $row["athleteId"], $row["trainerToken"]);
      }


      return $user;
    }
    return false;
  }

  function getProgramFromId($programId) {
    $query = "SELECT * FROM programs WHERE programId = $programId";
    $result = getQueryResult($query);

    if (is_object($result) and $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $program = new Program($row["programId"], $row["trainerId"], $row["athleteId"], $row["target"], $row["nWeeks"], $row["nSessions"]);

      return $program;
    }

    return false;
  }

  function getFirstIdAvailable($table, $id_field_name) {
    $query = "SELECT MAX($id_field_name) AS $id_field_name FROM $table";

    $result = getQueryResult($query);
    $row = $result->fetch_assoc();

    if (!is_null($row[$id_field_name])) {
      $id = $row[$id_field_name] + 1;
      $query = "ALTER TABLE $table AUTO_INCREMENT = " . $id;
      getQueryResult($query);

    } else {
      $query = "ALTER TABLE $table AUTO_INCREMENT = 1";
      getQueryResult($query);
      $id = 1;
    }

    return $id;
  }
?>
