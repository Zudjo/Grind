<?php

  class Exercise {

    // Properties
    private int $exerciseId;
    private int $sessionid;

    public string $muscle;
    public string $name;
    public int $series;
    public int $repetitions;
    public int $seconds;
    public int $weight;
    public int $rpe;
    public int $recovery;
    public string $notes;
    public int $week;

    // Constructor
    public function __construct($exerciseId, $sessionId, $muscle, $name, $series, $repetitions, $seconds, $weight, $rpe, $recovery, $notes, $week) {
      // Privates
      $this->exerciseId = Exercise::setId($exerciseId);

      $this->sessionId = $sessionId;

      // Pubblics
      $this->muscle = $muscle;
      $this->name = $name;
      $this->series = $series;
      $this->repetitions = $repetitions;
      $this->seconds = $seconds;
      $this->weight = $weight;
      $this->rpe = $rpe;
      $this->recovery = $recovery;
      $this->notes = $notes;
      $this->week = $week;
    }


    // Methods

    // Getters

    // Setters

    // Statics

    public static function setId($exerciseId) {
      if (is_null($exerciseId)) {
        $query = "SELECT MAX(exerciseId) AS \"exerciseId\" FROM exercises";

        $result = getQueryResult($query);
        $row = $result->fetch_assoc();

        // Checking if no exercises exist
        if (is_null($row["exerciseId"])) $exerciseId = 0;
        else $exerciseId = $row["exerciseId"] + 1;
      }

      return $exerciseId;
    }

    // Main Methods

    public function addToDb() {
      $query = "INSERT INTO exercises VALUES
        (\"$this->exerciseId\", \"$this->sessionId\", \"$this->muscle\",
        \"$this->name\", \"$this->series\", \"$this->repetitions\",
        \"$this->seconds\", \"$this->weight\", \"$this->rpe\",
        \"$this->recovery\", \"$this->notes\", \"$this->week\")";

      echo "<br>";
      echo $query;
      echo "<br>";

      $query = getQueryResult($query);


      if ($query) return true;
      return false;
    }

    // Echo methods
    public function printExercise() {
      echo "Exercise id: " . $this->exerciseId . "<br>";
      echo "Session id: " . $this->sessionId . "<br>";
      echo "Muscle: " . $this->muscle . "<br>";
      echo "Name: " . $this->name . "<br>";
      echo "Series: " . $this->series . "<br>";
      echo "Repetitions: " . $this->repetitions . "<br>";
      echo "Seconds: " . $this->seconds . "<br>";
      echo "Weight: " . $this->weight . "<br>";
      echo "RPE: " . $this->rpe . "<br>";
      echo "Recovery: " . $this->recovery . "<br>";
      echo "Notes: " . $this->notes . "<br>";
    }

    public function printAsTable() {
      $s = "";
      $s .= "<td>" . $this->muscle . "</td>";
      $s .= "<td>" . $this->name . "</td>";
      $s .= "<td>" . $this->series . "</td>";
      $s .= "<td>" . $this->repetitions . "</td>";
      $s .= "<td>" . $this->seconds . "</td>";
      $s .= "<td>" . $this->weight . "</td>";
      $s .= "<td>" . $this->rpe . "</td>";
      $s .= "<td>" . $this->recovery . "</td>";
      $s .= "<td>" . $this->notes . "</td>";
      return $s;
    }

    public static function printAsEmptyTable() {
      $s = "";
      $s .= "<td></td>";
      $s .= "<td></td>";
      $s .= "<td></td>";
      $s .= "<td></td>";
      $s .= "<td></td>";
      $s .= "<td></td>";
      $s .= "<td></td>";
      $s .= "<td></td>";
      $s .= "<td></td>";
      return $s;
    }
  }



?>
