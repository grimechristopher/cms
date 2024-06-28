<!--5-29-19 CGrime MOD : Changed all joke to course and author to instructor-->
<div class="div-card-full">
<?php if ($campus): ?>
<?php else: ?>
<h2>Add new Campus</h2>
<?php endif; ?>
</div>

<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>The Campus could not be added. Check below for more information.</p>
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
		<input type="hidden" name="campus[id]" value="<?=$campus->id ?? $campus['id'] ?? ''?>">
		<div class="form-row">
		<label for="name">Campus Name:</label>
		<input type="text" id="name" name="campus[name]" value="<?=$campus->name ?? $campus['name'] ?? ''?>">
		</div>
		<div class="form-row">
		<label for="code">Campus Code:</label>
		<input type="text" id="name" name="campus[code]" value="<?=$campus->code ?? $campus['code'] ?? ''?>">
		</div>

</div>
		<div class="div-card-full">
	<input type="submit" value="Submit" >
	</div>
</form>