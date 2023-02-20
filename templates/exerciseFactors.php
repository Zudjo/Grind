<div class="exerciseFactorsInput">
<label>
  Selected:
  <input type="checkbox" name="selected[]" checked>
</label>

<label>
  Exercise name:
  <input type="string" name="name[]" required>
</label>

<label>
  Muscle:
  <input type="string" name="muscle[]" required>
</label>

<label>
  Series:
  <input type="number" name="series[]" required>
</label>

<label>
  Repetitions:
  <input type="number" name="repetitions[]" required>
</label>

<label>
  Seconds:
  <input type="number" name="seconds[]" required>
</label>

<label>
  Weight:
  <input type="number" name="weight[]" required>
</label>

<label>
  RPE:
  <input type="number" name="rpe[]" required>
</label>

<label>
  Recovery:
  <input type="number" name="recovery[]" required>
</label>

<label>
  Notes:
  <input type="string" name="notes[]" required>
</label>

<input type="number" name="week[]" value="<?php echo $week; ?>" hidden>
</div>
