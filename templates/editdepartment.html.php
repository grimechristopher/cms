<div class="div-card-full">
<?php if ((!$department)|| empty($department->id)): ?>
    <h2>Add Department</h2>
    <?php elseif ($department): ?>
    <h2>Edit <?=$department->name?></h2>
<?php endif;?>
</div>

<?php if (!empty($errors)): ?>
    <div class="div-card-full">
	    <div class="errors">
		    <p>The department could not be added. Check below for more information.</p>
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
<div class="form-row">
	<input type="hidden" name="department[id]" value="<?=$department->id ?? ''?>">
	<label for="departmentname">Enter department name:</label>
	<input type="text" id="departmentname" name="department[name]" value="<?=$department->name ?? ''?>" />
    </div>


<div class="form-row">Select subjects that are a part of this department:</div>
    <?php foreach ($subjects as $subject): ?>
    <div class="form-row form-checkboxes">
    <?php if (is_object($department) && $department->hasSubject($subject->id)): ?>
        <input type="checkbox" checked name="subject[]" value="<?=$subject->id?>" /> 
    <?php else: ?>
        <input type="checkbox" name="subject[]" value="<?=$subject->id?>" /> 
    <?php endif; ?>

    <label><?=$subject->name?></label>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="div-card-full">
    <input type="submit" name="submit" value="Save">
    </div>
</form>
