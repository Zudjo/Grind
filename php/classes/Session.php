<?php

  class Session {

    // - PROPERTIES -
    private int $sessionId;
    private int $programId;

    public string $name;

    // Constructor
    function __construct($sessionId, $programId, $name="") {
      $this->sessionId = Session::setId($sessionId);

      $this->programId = $programId;

      $this->name = $name;
    }

    // - METHODS -

    // Getters

    // Setters

    public static function setId($sessionId) {
      if (is_null($sessionId)) {
        $query = "SELECT MAX(sessionId) AS \"sessionId\" FROM sessions";

        $result = getQueryResult($query);
        $row = $result->fetch_assoc();

        // Checking if no sessions exists
        if (is_null($row["sessionId"])) $sessionId = 0;
        else $sessionId = $row["sessionId"] + 1;
      }

      return $sessionId;
    }

    // Statics

    // Main methods

    public function addToDb() {
      $query = "INSERT INTO sessions VALUES (\"$this->sessionId\", \"$this->programId\", \"$this->name\")";

      echo "<br>";
      echo $query;
      echo "<br>";

      $query = getQueryResult($query);

      if ($query) return true;
      return false;
    }

    // Echo methods

    public function printAsTable($nWeeks) {
      $query = "SELECT * FROM exercises WHERE sessionId = $this->sessionId";
      $result = getQueryResult($query);


      if (is_object($result) and $result->num_rows > 0) {
        $rowspan = $result->num_rows / $nWeeks + 1;

        echo "<th rowspan = " . $rowspan . ">" . $this->name . "</th>";

        echo "<tr>";

        while ($row = $result->fetch_assoc() and $row["week"] <= $nWeeks) {

          $exercise = new Exercise($row["exerciseId"], $row["sessionId"], $row["muscle"],
            $row["name"], $row["series"], $row["repetitions"], $row["seconds"],
            $row["weight"], $row["rpe"], $row["recovery"], $row["notes"], $row["week"]);

          $exercise->printAsTable();

          if ($row["week"] == $nWeeks) {
            echo "</tr>";
            echo "<tr>";
          }

        }
        echo "</tr>";

      } else {
        echo "<tr>";
        echo "<th>$this->name</th>";
        echo "<td>No exercises available.</td>";
        echo "</tr>";
      }
    }

    public static function printSessionTitlesTable() {
      echo "<th>MUSCLE</th>";
      echo "<th>EXERCISE NAME</th>";
      echo "<th>SERIES</th>";
      echo "<th>REPETITIONS</th>";
      echo "<th>SECONDS</th>";
      echo "<th>WEIGHT</th>";
      echo "<th>RPE</th>";
      echo "<th>RECOVERY</th>";
      echo "<th>NOTES</th>";
    }

    public function printAsOption($key="") {
      echo "<option value=\"$this->sessionId\">Session $key</option>";
    }

    /*
    public function printSessionTable($nWeeks) {
      if ($this->nExercises) {
        foreach ($this->exercises as $key=>$obj) {
          for ($i=0; $i < $nWeeks; $i++) {
            $obj->printExerciseInTable();
          }
          echo "</tr>";
          echo "<tr>";
        }
        echo "</tr>";
      }
    }
    */


  }



?>
