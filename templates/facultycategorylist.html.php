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
	<h2>Faculty Categories</h2>
	<form>
		<input type="button" onclick="document.location.href='index.php?facultycategory/edit'" value="Add"></form>
	</div>
	<div class="div-card-full">
<table>
	<thead>
		<tr>
		<th>Manage</th>
		<th>Name</th>
		<th>Code</th>
		<th>Pay Rate</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($facultycategories as $facultycategory): ?>
		<tr>
		<td data-title="Manage">
		<form class="inline-block"><input type="button" onclick="document.location.href='index.php?facultycategory/edit?id=<?=$facultycategory->id?>'" value="Edit"></form>
			<form action="index.php?facultycategory/delete" method="post" class="inline-block"> <!-- / 6/3/18 JG MOD1L -->
                    <input type="hidden" name="id" value="<?=$facultycategory->id?>">
                       <input type="submit" value="Delete" class="button-delete" onclick="return confirm('Are you sure you want to delete this faculty category?');">
                    </form></td>
			<td data-title="Name"><?=$facultycategory->name;?></td>
			<td data-title="Code"><?=$facultycategory->code;?></td>
			<td data-title="Pay Rate"><?=$facultycategory->payrate;?></td>
		</tr>           

		<?php endforeach; ?>
	</tbody>
</table>
</div>


