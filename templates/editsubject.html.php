<div class="div-card-full">
<?php if ($subject): ?>
<h2>Edit subject</h2>
<?php else: ?>
<h2>Add new subject</h2>
<?php endif; ?>
</div>
<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>The Subject could not be added. Check below for more information.</p>
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
	<input type="hidden" name="subject[id]" value="<?=$subject->id ?? $subject['id'] ?? ''?>">
	<div class="form-row">
	<label for="code">Enter Subject Code:</label>
	<input type="text" id="code" name="subject[code]" value="<?=$subject->code ?? $subject['code'] ?? ''?>" />
	</div>
	<div class="form-row">
	<label for="name">Enter Subject name:</label>
	<input type="text" id="name" name="subject[name]" value="<?=$subject->name ?? $subject['name'] ?? ''?>" />
	</div>
</div>

	<div class="div-card-full">
	<input type="submit" name="submit" value="Save">
	</div>
</form>
