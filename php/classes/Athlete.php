<?php

  class Athlete extends User {

    // Properties
    private int $athleteId;
    private string $trainerToken;
    private array $programsIds;

    // Constructor
    public function __construct($firstname, $lastname, $birthDate, $email, $username, $password, $athleteId, $trainerToken) {
      parent::__construct($firstname, $lastname, $birthDate, $email, $username, $password);

      // Privates
      $this->athleteId = $athleteId;
      $this->trainerToken = $trainerToken;

      $this->setProgramsIds();
    }


    // Methods

    // Getters

    // Setters

    private function setProgramsIds() {
      $query = "SELECT programId FROM programs WHERE athleteId = \"$this->athleteId\"";

      $result = getQueryResult($query);

      if (is_object($result) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $this->programsIds[] = $row["programId"];
        }
        return true;
      }
      return false;
    }


    // Main Methods
    public function addToDb() {
      // Set queries
      $query1 = "INSERT INTO athletes VALUES ($this->athleteId, \"$this->trainerToken\", \"$this->firstname\", \"$this->lastname\", \"$this->birthDate\", \"$this->email\")";
      $query2 = "INSERT INTO athletes_credentials VALUES ($this->athleteId, \"$this->username\", \"$this->password\")";

      $query1 = getQueryResult($query1);
      $query2 = getQueryResult($query2);

      if ($query1 and $query2) {
        return true;
      }

      return false;
    }



    // Echo methods

    public function printProgramsSelect() {
      if (isset($this->programsIds[0])) {
        foreach ($this->programsIds as $key => $value) {
          $program = getProgramFromId($value);
          echo "<option value = " . $value . ">" . $program->target . "</option>\n";
        }
      }
    }



  }



?>
