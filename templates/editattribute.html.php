<div class="div-card-full">
<?php if ($attribute): ?>
<h2>Edit attribute</h2>
<?php else: ?>
<h2>Add new attribute</h2>
<?php endif; ?>
</div>

<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>The Attribute could not be added. Check below for more information.</p>
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
	<input type="hidden" name="attribute[id]" value="<?=$attribute->id ?? $attribute['id'] ?? ''?>">
	<div class="form-row">  
	<label for="name">Enter attribute name:</label>
	<input type="text" id="name" name="attribute[name]" value="<?=$attribute->name ?? $attribute['name'] ?? ''?>" />
	</div>
	<div class="form-row">  
	<label for="description">Enter Description:</label>
	<input type="text" id="description" name="attribute[description]" value="<?=$attribute->description ?? $attribute['description'] ?? ''?>" />
	</div>
	</div>
	<div class="div-card-full">
	<input type="submit" name="submit" value="Save">
	</div>
</form>
