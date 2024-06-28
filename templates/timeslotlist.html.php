<div class="div-card-full">
	<h2>Timeslots</h2>
	
	<form>
                    <input type="button" onclick="document.location.href='index.php?timeslot/edit'" value="Add">
				</form>
				</div>
<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>Could not be deleted. Check below for more information.</p>
		<ul>
		<?php foreach ($errors as $error): ?>
			<li><?= $error ?></li>
		<?php endforeach; 	?>
		</ul>
	</div>
	</div>
<?php endif; ?>
<div class="div-card-full">
<table>
	<thead>
		<tr>
		<th>Manage</th>
		<th>Days</th>
		<th>Start Time</th>
		<th>End Time</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($timeslots as $timeslot): ?>
		<tr>
		<td data-title="Manage">
			<form class="inline-block">
                    <input type="button" onclick="document.location.href='index.php?timeslot/edit?id=<?=$timeslot->code;?>'" value="Edit">
                </form>                 
				<form action="index.php?timeslot/delete" class="inline-block" method="post"> <!-- / 6/3/18 JG MOD1L -->
                    <input type="hidden" name="code" value="<?=$timeslot->code?>">
                       <input type="submit" class="button-delete" value="Delete" onclick="return confirm('Are you sure you want to delete this timeslot?');">
                    </form></td>
			<td data-title="Days"><?=$timeslot->days;?></td>
			<td data-title="Start Time"><?=date('h:i a', strtotime(htmlspecialchars($timeslot->timestart, ENT_QUOTES, 'UTF-8'))); ?></td>	
			<td data-title="End Time"><?=date('h:i a', strtotime(htmlspecialchars($timeslot->timeend, ENT_QUOTES, 'UTF-8'))); ?></td>

		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>



