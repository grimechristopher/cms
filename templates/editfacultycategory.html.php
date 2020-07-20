<!--5-29-19 CGrime MOD : Changed all joke to course and author to instructor-->
<div class="div-card-full">
<?php if (is_object($facultycategory)): ?>
<h2>Edit <?=$facultycategory->name?></h2>
<?php else: ?>
<h2>Add new faculty category</h2>
<?php endif; ?>
</div>

<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>The faculty category could not be added. Check below for more information.</p>
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
		<input type="hidden" name="facultycategory[id]" value="<?=$facultycategory->id ?? $facultycategory['id'] ?? ''?>">
		<div class="form-row">
			<label for="name">Faculty Category Name:</label>
			<input type="text" id="name" name="facultycategory[name]" value="<?=$facultycategory->name ?? $facultycategory['name'] ?? ''?>">
		</div>
		<div class="form-row">
			<label for="code">Faculty Category Code:</label>
			<input type="text" id="code" name="facultycategory[code]" value="<?=$facultycategory->code ?? $facultycategory['code'] ?? ''?>">
		</div>
		<div class="form-row">
			<label for="payrate">Pay Rate:</label>
			<input type="text" id="payrate" name="facultycategory[payrate]" value="<?=$facultycategory->payrate ?? $facultycategory['payrate'] ?? ''?>">
		</div>
</div>
		<div class="div-card-full">
	<input type="submit" value="Submit" >
	</div>
</form>