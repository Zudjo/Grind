<?php

  abstract class User {

    // Properties
    public string $firstname;
    public string $lastname;
    public string $birthDate;
    public string $email;

    protected string $username;
    protected string $password;

    // Constructor
    public function __construct($firstname, $lastname, $birthDate, $email, $username, $password) {
      // Pubblics
      $this->firstname = $firstname;
      $this->lastname = $lastname;
      $this->birthDate = $birthDate;
      $this->email = $email;

      // Privates
      $this->username = $username;
      $this->password = $password;
    }

    // Methods

    // Getters

    // Setters

    // Main Methods
    abstract public function addToDb();

  }



?>
