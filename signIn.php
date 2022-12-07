<!-- Require controller -->
<?php require("./php/signInC.php"); ?>

<!DOCTYPE html>
<html>

  <head>
    <title>Sign in</title>

    <!-- CSS -->
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signIn.css">

  </head>

  <body>
    <!-- Main Menu -->
    <?php require("./templates/mainMenu.php"); ?>

    <form action="./sign-in" method="post">
      <label>
        Atlhete
        <input type="radio" name="userType" value="athlete">
      </label>

      <label>
        Trainer
        <input type="radio" name="userType" value="trainer">
      </label>

      <label>
        Firstname:
        <input type="text" name="firstname" required>
      </label>

      <label>
        Lastname:
        <input type="text" name="lastname" required>
      </label>

      <label>
        Email:
        <input type="text" name="email" required>
      </label>

      <label>
        Birth date:
        <input type="date" name="birthDate" required>
      </label>

      <label>
        Trainer token:
        <input type="string" name="trainerToken" required>
      </label>

      <label>
        Username:
        <input type="text" name="username" required>
      </label>

      <label>
        Password:
        <input type="password" name="password" required>
      </label>

      <label>
        Repeat password:
        <input type="password" name="passwordCheck" required>
      </label>

      <input type="submit" value="Sign in">
    </form>

    <?php if ($feedback != "") echo $feedback; ?>
  </body>
</html>
