<!-- Require controller -->
<?php require("./php/logInC.php"); ?>

<!DOCTYPE html>
<html>

  <head>
    <title>Log in</title>

    <!-- CSS -->
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/logIn.css">

  </head>

  <body>
    <!-- Main menu -->
    <?php require("./templates/mainMenu.php"); ?>

    <!-- Log in form -->
    <form action="./log-in" method="post">
      <label>
        Username:
        <input type="text" name="username" required>
      </label>

      <label>
        Password:
        <input type="password" name="password" required>
      </label>

      <label>
        Atlhete
        <input type="radio" name="userType" value="athlete" required>
      </label>

      <label>
        Trainer
        <input type="radio" name="userType" value="trainer" required>
      </label>

      <input type="submit" value="Log in">
    </form>

    <?php if ($feedback != "") echo $feedback; ?>
  </body>
</html>
