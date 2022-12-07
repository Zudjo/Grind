<?php

  class Program {

    // - PROPERTIES -
    private int $programId;
    private int $trainerId;
    private int $athleteId;

    public string $target;
    public int $nWeeks;
    public int $nSessions;
    public array $sessions;

    // Constructor
    public function __construct($programId, $trainerId, $athleteId, $target, $nWeeks, $nSessions) {

      // If programId is null, the program doesn't exist in the DB
      // so the id is set with setId()
      $this->programId = Program::setId($programId);

      $this->trainerId = $trainerId;
      $this->athleteId = $athleteId;

      $this->target = $target;
      $this->nWeeks = $nWeeks;
      $this->nSessions = $nSessions;

      $this->setSessions();
    }


    // - METHODS -

    // Getters

    // Setters

    private function setSessions() {
      $query = "SELECT * FROM sessions WHERE programId = $this->programId";
      $result = getQueryResult($query);

      if (is_object($result) and $result->num_rows > 0) { // if sessions exist in the DB
        while ($row = $result->fetch_assoc()) {
          $session = new Session($row["sessionId"], $this->programId, "Session");
          $this->sessions[] = $session;
        }
      } else { // if sessions DON'T exist in the DB
        $sessionId = Session::setId(null);
        for ($i=0; $i < $this->nSessions; $i++) {
          $session = new Session($sessionId, $this->programId, "Session");
          echo "Session added.";
          $this->sessions[] = $session;
          $sessionId++;
        }
      }

    }

    // Statics
    public static function setId($programId) {
      if (is_null($programId)) {
        $query ="SELECT MAX(programId) AS \"programId\" FROM programs";

        $result = getQueryResult($query);
        $row = $result->fetch_assoc();

        // Checking if no programs exists
        if (is_null($row["programId"])) $programId = 0;
        else $programId = $row["programId"] + 1;
      }

      return $programId;
    }

    // Main Methods
    public function addToDb() {
      $query = "INSERT INTO programs VALUES (\"$this->programId\", \"$this->trainerId\", \"$this->athleteId\", \"$this->target\", \"$this->nWeeks\", \"$this->nSessions\")";

      $query = getQueryResult($query);

      if ($query) return true;
      return false;
    }

    public function addSessionsToDb() {
      if ($this->sessions) {
        foreach ($this->sessions as $key => $session) {
          $session->addToDb();
        }
        return true;
      }
      return false;
    }

    // Echo methods

    public function printAsTable() {
      $query = "SELECT * FROM sessions WHERE programId = $this->programId";
      $result = getQueryResult($query);

      if (is_object($result) and $result->num_rows > 0) {
        $sessionNumber = 1;
        while ($row = $result->fetch_assoc()) {
          $sessionName = $row["name"] . " " . $sessionNumber;
          $session = new Session($row["sessionId"], $row["programId"], $sessionName);
          $session->printAsTable($this->nWeeks);
          $sessionNumber++;
        }
      } else {
        echo "<td>No sessions available.</td>";
      }
    }

    public function printSessionsIdsAsOptions() {
      if ($this->sessions) {
        foreach ($this->sessions as $key => $session) {
          $session->printAsOption($key+1);
        }
      }
    }

    public function printWeeksRow() {
      echo "<tr>";
      echo "<td></td>";
      for ($i=1; $i <= $this->nWeeks; $i++) {
        echo "<th colspan=\"9\">WEEK " . $i . "</th>\n";
      }
      echo "</tr>";
    }

    public function printHeadersRow() {
      echo "<tr>";
      echo "<td></td>";
      for ($i=0; $i < $this->nWeeks; $i++) {
        Session::printSessionTitlesTable();
      }
      echo "</tr>";
    }

    /*

    private function setSessions() {
      $query = "SELECT * FROM sessions WHERE programId = $this->programId AND athleteId = $this->athleteId";
      $result = getQueryResult($query);

      if (is_object($result) and $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $session = new Session($row["sessionId"], $this->programId, $this->athleteId);
          $this->addSession($session);
        }
      } else {
        $sessionId = Session::getFirstIdAvailable($this->programId, $this->athleteId);
        for ($i=0; $i < $this->nSessions; $i++) {
          $session = new Session($sessionId, $this->programId, $this->athleteId);
          $session->addToDb();
          $this->addSession($session);
          $sessionId++;
        }
      }

    }


    public function printProgram() {
      if (isset($this->sessions[0])) {
        foreach ($this->sessions as $key=>$obj) {

          if ($key == 0) {
            $this->printWeeksRow();
            $this->printHeadersRow();
          }

          $this->printExerciseRows($obj);
        }

        $this->printHeadersRow();
        $this->printWeeksRow();
      } else {
        echo "No sessions available";
      }
    }

    public function printSessions() {
      foreach ($this->sessions as $obj) {
        $obj->printSessionTable();
      }
    }

    public function printWeeksRow() {
      echo "<tr>";
      echo "<td></td>";
      for ($i=1; $i <= $this->nWeeks; $i++) {
        echo "<th colspan=\"9\">WEEK " . $i . "</th>\n";
      }
      echo "</tr>";
    }

    public function printHeadersRow() {
      echo "<tr>";
      echo "<td></td>";
      for ($i=0; $i < $this->nWeeks; $i++) {
        Session::printSessionTitlesTable();
      }
      echo "</tr>";
    }

    public function printExerciseRows($session) {
      echo "<tr>";

      if ($nExercises = $session->nExercises) {
        echo "<th rowspan = \"$nExercises\">SESSION " . $session->getSessionId() . "</th>";
      } else {
        echo "<th>SESSION " . $session->getSessionId() . "</th>";
      }

      $session->printSessionTable($this->nWeeks);
      echo "</tr>";
    }

    //  rowspan = \"$session->nExercises\"

    */


  }



?>
