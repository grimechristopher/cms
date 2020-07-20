<!--5-29-19 CGrime MOD : Changed all joke to course and author to instructor-->
<div class="div-card-full">
<?php if ($timeslot): ?>
<h2>Edit Timeslot</h2>
<?php else: ?>
<h2>Add new Timeslot</h2>
<?php endif; ?>
</div>

<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>The Time Slot could not be added. Check below for more information.</p>
		<ul>
		<?php foreach ($errors as $error): ?>
			<li><?= $error ?></li>
		<?php endforeach; 	?>
		</ul>
    </div>
	</div>
<?php endif; ?>
<form method="post">
<div class="div-card-full">
		<input type="hidden" name="timeslot[code]" value="<?=$timeslot->code ?? $timeslot['code'] ?? '&nbsp;'?>">
		<div class="form-row">
		<label for="slotdays">Days (Entered as MTWRFSU):</label>
		<input type="text" id="slotdays" name="timeslot[days]" value="<?=$timeslot->days ?? $timeslot['days'] ?? ''?>">
</div>
	<div class="form-row">
		<label for="slotstart">Start Time (Enter in 24h time):</label>

		<?php if (isset($timeslot->timestart) || isset($timeslot['timestart'])): ?>
		<input type="text" id="slotstart" name="timeslot[timestart]" value="<?=date('H:i', strtotime($timeslot->timestart ?? $timeslot['timestart'])) ?? ' '?>" placeholder="00:00">
		<?php else: ?>
			<input type="text" id="slotstart" name="timeslot[timestart]" value="" placeholder="00:00">
		<?php endif; ?>
		</div>
		<div class="form-row">
		<label for="slotend">End Time (Enter in 24h time):</label>
		<?php if (isset($timeslot->timeend) || isset($timeslot['timeend'])): ?>
			<input type="text" id="slotend" name="timeslot[timeend]" value="<?=date('H:i', strtotime($timeslot->timeend ?? $timeslot['timeend'] ?? '' )) ?>" placeholder="00:00">
		<?php else: ?>
			<input type="text" id="slotend" name="timeslot[timeend]" value="" placeholder="00:00">
		<?php endif; ?>
		</div>
		</div>
		<div class="div-card-full">
		<input type="submit" value="Submit" >
		</div>
</form>
