

// MAIN -- START --

$(document).ready(function(){
  // VARIABLES -- START --
  // VARIABLES -- END --

  $("#athletesSelect").change(function(){
    ajaxPrintProgramsSelect();

  });

  $("#programsSelect").change(function(){
    ajaxPrintProgram();
    ajaxPrintSessionsSelect();
    $("#exerciseFactors").html("");

  });

  $("#sessionsSelect").change(function(){
    ajaxPrintExerciseFactors();

  });



});
// MAIN -- FINISH --

// FUNCTIONS -- START --

function ajaxPrintProgramsSelect() {
  let selectedAthleteId = $("#athletesSelect option:selected").val();

  // Print select of programs from athleteId in selectAthletes
  let jqxhr = $.post(
    "./php/ajaxFunctions.php",
    {athleteId : selectedAthleteId,
    func : "printProgramsSelect"}
  )

  jqxhr.done(function(data) {
    $("#programDisplay").html("");
    $("#sessionsSelect").html("");

    if (selectedAthleteId != "-1") {
      $("#addProgramSubmit").prop("disabled", false);
      $("#programsSelect").html(data);

    } else {
      $("#addProgramSubmit").prop("disabled", true);
      $("#programsSelect").html("");
    }
  })

  jqxhr.fail(function() {
    $("#feedback").html("Something went wrong.");
  })

}

function ajaxPrintProgram() {
  let selectedProgramId = $("#programsSelect option:selected").val();

  // Print program from programId selected in selectPrograms
  let jqxhr = $.post(
    "./php/ajaxFunctions.php",
    {programId : selectedProgramId,
    func : "printProgram"}
  )

  jqxhr.done(function(data) {
    if (selectedProgramId != "-1") {
      $("#addExerciseSubmit").prop("disabled", false);
      $("#programDisplay").html(data);

    } else {
      $("#addExerciseSubmit").prop("disabled", true);
      $("#programDisplay").html("");
    }
  })

  jqxhr.fail(function() {
    $("#feedback").html("Something went wrong.");
  })
}

function ajaxPrintSessionsSelect() {
  let selectedProgramId = $("#programsSelect option:selected").val();

  // Print program from programId selected in selectPrograms
  let jqxhr = $.post(
    "./php/ajaxFunctions.php",
    {programId : selectedProgramId,
    func : "printSessionsSelect"}
  )

  jqxhr.done(function(data) {
    if (selectedProgramId != "-1") {
      $("#sessionsSelect").html(data);

    } else {
      $("#sessionsSelect").html("");

    }
  })

  jqxhr.fail(function() {
    $("#feedback").html("Something went wrong.");
  })
}

function ajaxPrintExerciseFactors() {
  let selectedProgramId = $("#programsSelect option:selected").val();

  // Print ExerciseFactors forms from programId selected in selectPrograms
  var jqxhr = $.post(
    "./php/ajaxFunctions.php",
    {programId : selectedProgramId,
    func : "printExerciseFactors"}
  )

  jqxhr.done(function(data) {
    if (selectedProgramId != "-1") {
      $("#exerciseFactors").html(data);
      $(":checkbox").change(function () {
        exerciseSelector();
      });

    } else {
      $("#exerciseFactors").html("No weeks.");
    }
    return true;
  })

  jqxhr.fail(function() {
    $("#feedback").html("Something went wrong.");
    return false;
  })
}

function exerciseSelector() {

  $("div:has(:checkbox:not(:checked)).exerciseFactorsInput input:not(:checkbox)").attr("disabled", "");
  $("div:has(:checkbox:checked).exerciseFactorsInput input:not(:checkbox)").removeAttr("disabled");

}

// FUNCTIONS -- FINISH --
