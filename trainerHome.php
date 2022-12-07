<!-- Require controller -->
<?php require("./php/trainerHomeC.php"); ?>

<!DOCTYPE html>
<html>

	<head>
		<title>Home</title>

		<!-- CSS -->
		<link rel="stylesheet" href="./css/base.css">
		<link rel="stylesheet" href="./css/trainerHome.css">

		<!-- JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="./javascript/jquery/trainerHome.js"></script>
	</head>

	<body>

	<!-- Trainer Menu -->
	<?php require("./templates/mainTrainerMenu.php"); ?>

	<!-- Add program form -->
	<form action="./home-trainer" method="post">

		<!-- Select athlete input -->
		<label>
		Your athletes
		<select name="athleteId" id="athletesSelect" required>
			<option value="-1">-- Select athlete --</option>
			<?php $trainer->printAthletes(); ?>
		</select>

		</label>

		<!-- Add program input -->
		<details>
		<summary>Add program</summary>
		<br>

			<label>
				Target:
				<input type="text" name="target" required>
			</label>

			<label>
				Number of weeks:
				<input type="number" name="nWeeks" required>
			</label>

			<label>
				Number of sessions per week:
				<input type="number" name="nSessions" required>
			</label>

			<input type="submit" value="Add" id="addProgramSubmit" disabled>

		<br>
		</details>
		</form>

		<!-- Add exercise form -->
		<form action="./home-trainer" method="post">

		<!-- Select program input -->
		<label>
			Programs
			<select name="programId" id="programsSelect" required></select>
		</label>

		<!-- Add exercise input -->
		<details>
			<summary>Add exercise</summary>

			<br>

			<label>
				Session:
				<select id="sessionsSelect" name="sessionId" required></select>
			</label>

			<div id="exerciseFactors">

			</div>

			<input type="submit" value="Add" id="addExerciseSubmit" disabled>

		</form>
		<br>

		</details>

	<div class="programs" id="programDisplay">

	</div>

	<div id="feedback">

	</div>

	</body>
</html>
