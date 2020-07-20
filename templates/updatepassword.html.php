<div class="div-card-full">
<h2>Change Password</h2>
</div>

<?php if (!empty($errors)): ?>
    <div class="div-card-full">
	    <div class="errors">
		    <p>Password Could not be changed. Check below for errors.</p>
		    <ul>
		        <?php foreach ($errors as $error): ?>
			    <li><?= $error ?></li>
		        <?php endforeach; 	?>
		    </ul>
        </div>
    </div>
    <?php endif; ?>

<form action="" method="post">
<div class="div-card-full">
<div class="div-instructor-fields">
<input type="hidden" name="instructor[id]" value="<?=$instructor->id ?? $instructor['id'] ?? ''?>">
	<div class="form-row">
    <label for="new-password">New Password:</label>
    <input type="text" id="new-password" name="instructor[new-password]" value="">
	</div>
</div>
</div>
	<div class="div-card-full">
	<input type="submit" value="Submit" />
	</div>
</form>
