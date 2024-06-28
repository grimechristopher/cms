
<div class="div-card-full">
	<h2>Terms</h2>	
	<form>
        <input type="button" onclick="document.location.href='index.php?term/edit'" value="Add">
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
		<th>Number</th>
		<th>Term Name</th>
		<th>Start Date</th>
		<th>End Date</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($terms as $term): ?>
		<tr>
		<td data-title="Manage">
			<form class="inline-block">
                    <input type="button" onclick="document.location.href='index.php?term/edit?id=<?=$term->id;?>'" value="Edit">
                </form>     			
			<form action="index.php?term/delete" method="post" class="inline-block"> <!-- / 6/3/18 JG MOD1L -->
                    <input type="hidden" name="id" value="<?=$term->id?>">
                       <input type="submit" class="button-delete" value="Delete" onclick="return confirm('Are you sure you want to delete this term?');">
                    </form></td>
					<td data-title="Number"><?=htmlspecialchars($term->number, ENT_QUOTES, 'UTF-8'); ?></td>
			<td data-title="Term Name"><?=$term->termname;?></td>
			<td data-title="Start Date"><?=date('Y-m-d', strtotime(htmlspecialchars($term->termstart, ENT_QUOTES, 'UTF-8'))); ?></td>	
			<td data-title="End Date"><?=date('Y-m-d', strtotime(htmlspecialchars($term->termend, ENT_QUOTES, 'UTF-8'))); ?></td>

		</tr>
		<?php endforeach; ?>
</tbody>
</table>

</div>


