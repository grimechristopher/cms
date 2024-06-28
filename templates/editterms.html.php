<div class="div-card-full">
<?php if ($term): ?>
<h2>Edit Term</h2>
<?php else: ?>
<h2>Add new Term</h2>
<?php endif; ?>
</div>
<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>The Term could not be added. Check below for more information.</p>
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
		<input type="hidden" name="term[id]" value="<?=$term->id ?? $term['id'] ?? ''?>">
		<div class="form-row">
		<label for="termname">Term Name:</label>
		<input type="text" id="termname" name="term[termname]" value="<?=$term->termname ?? $term['termname'] ?? ''?>">
</div>
<div class="form-row">
		<label for="number">Number:</label>
		<?php if (!is_object($term)): ?>
    	<input type="text" id="number" name="term[number]" value="<?=$term->number ?? $term['number'] ?? ''?>" >
		<?php else : ?>
			<input type="text" id="number" name="term[number]" >
		<?php endif; ?>
	</div>
<div class="form-row">
		<label for="termstart">Start Date:</label>

		<input type="text" id="termstart" name="term[termstart]" value="<?=$term->termstart ?? $term['termstart'] ?? ''?> " placeholder="yyyy-mm-dd">
		</div>
	<div class="form-row">
		<label for="termend">End Date:</label>
    	<input type="text" id="termend" name="term[termend]" value="<?=$term->termend ?? $term['termend'] ?? ''?>" placeholder="yyyy-mm-dd">
	</div>

</div>
		<div class="div-card-full">
		<input type="submit" value="Submit" >
		</div>
</form>