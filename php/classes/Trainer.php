<?php

  class Trainer extends User {

    // Properties
    private int $trainerId;
    private string $trainerToken;
    private array $athletesIds;

    // Constructor
    public function __construct($firstname, $lastname, $birthDate, $email, $username, $password, $trainerId, $trainerToken) {
      parent::__construct($firstname, $lastname, $birthDate, $email, $username, $password);

      // Privates
      $this->trainerId = $trainerId;
      $this->trainerToken = $trainerToken;

      $this->setAthletesIds();
    }


    // Methods

    // Getters
    public function getNumAthletes() {
      return count($this->athletesIds);
    }

    public function getTrainerId() {
      return $this->trainerId;
    }

    // Setters
    private function setAthletesIds() {
      $query = "SELECT athleteId FROM athletes WHERE trainerToken = \"$this->trainerToken\"";

      $result = getQueryResult($query);

      if (is_object($result) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $this->athletesIds[] = $row["athleteId"];
        }
        return true;
      }
      return false;
    }

    // Main Methods
    public function addToDb() {
      // Set queries
      $query1 = "INSERT INTO trainers VALUES ($this->trainerId, \"$this->trainerToken\", \"$this->firstname\", \"$this->lastname\", \"$this->birthDate\", \"$this->email\")";
      $query2 = "INSERT INTO trainers_credentials VALUES ($this->trainerId, \"$this->username\", \"$this->password\")";

      $query1 = getQueryResult($query1);
      $query2 = getQueryResult($query2);

      if ($query1 and $query2) {
        return true;
      }

      return false;
    }


    // Echo Methods
    public function printAthletes() {
      if (isset($this->athletesIds)) {
          foreach ($this->athletesIds as $key => $value) {
            $athlete = getUserObjectFromId($value, "athlete");  
            echo "<option value = " . $value . ">" . $athlete->lastname . "</option>\n";
          }
      }
    }
  }



?>