<div class="div-card-full">
<?php if ($instructor): ?>
<h2>Edit Instructor <?=$instructor->firstname ?? ''?> <?=$instructor->lastname ?? ''?></h2>
<?php else: ?>
<h2>Add new Instructor</h2>
<?php endif; ?>
</div>

<?php if (!empty($errors)): ?>
    <div class="div-card-full">
	    <div class="errors">
		    <p>The course could not be added. Check below for more information.</p>
		    <ul>
		        <?php foreach ($errors as $error): ?>
			    <li><?= $error ?></li>
		        <?php endforeach; 	?>
		    </ul>
        </div>
    </div>
    <?php endif; ?>

<form  method="post">
<div class="div-card-full">
	<div class="div-instructor-fields">
<input type="hidden" name="instructor[id]" value="<?=$instructor->id ?? $instructor['id'] ?? ''?>">
<h3 class="form-row">Instructor Info:</h3>
    <div class="form-row">
    <label for="firstname">Instructor's First Name:</label>
    <input type="text" id="firstname" name="instructor[firstname]" value="<?=$instructor->firstname ?? $instructor['firstname'] ?? ''?>">
	</div>
	<div class="form-row">
    <label for="middlename">Instructor's Middle Name/Initial <small>(Optional)</small></label>
    <input type="text" id="middlename" name="instructor[middlename]" value="<?php if(isset($instructor->middlename)) {echo ($instructor->middlename ?? $instructor['middlename'] ?? '');}?>">
	</div>
	<div class="form-row">
    <label for="lastname">Instructor's Last Name:</label>
    <input type="text" id="lastname" name="instructor[lastname]" value="<?=$instructor->lastname ?? $instructor['lastname'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="email">Email:</label>
    <input type="text" id="email" name="instructor[email]" value="<?=$instructor->email ?? $instructor['email'] ?? ''?>" >
	</div>
	<div class="form-row">
	<label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="instructor[phone]" value="<?=$instructor->phone ?? $instructor['phone'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="degree">Degree:</label>
    <input type="text" id="degree" name="instructor[degree]" value="<?=$instructor->degree ?? $instructor['degree'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="position">Position:</label>
    <input type="text" id="position" name="instructor[position]" value="<?=$instructor->position ?? $instructor['position'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="contract">Contract:</label>
    <input type="text" id="contract" name="instructor[contract]" value="<?=$instructor->contract ?? $instructor['contract'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="workloadcap">Workload Cap:</label>
    <input type="text" id="workloadcap" name="instructor[workloadcap]" value="<?=$instructor->workloadcap ?? $instructor['workloadcap'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="courserelease">Course Release:</label>
    <input type="text" id="courserelease" name="instructor[courserelease]" value="<?=$instructor->courserelease ?? $instructor['courserelease'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="officehours">Office Hours:</label>
    <input type="text" id="officehours" name="instructor[officehours]" value="<?=$instructor->officehours ?? $instructor['officehours'] ?? ''?>">
	</div>

	<h3 class="form-row">Pay info:</h3>
	<div class="form-row">
	<label for="rate345">Pay Rate 3,4,5:</label>
    <input type="text" id="rate345" name="instructor[rate345]" value="<?=$instructor->rate345 ?? $instructor['rate345'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="rate2">Pay Rate 2:</label>
    <input type="text" id="rate2" name="instructor[rate2]" value="<?=$instructor->rate2 ?? $instructor['rate2'] ?? ''?>">
	</div>
	<div class="form-row">
	<label for="rate1">Pay Rate 1:</label>
    <input type="text" id="rate1" name="instructor[rate1]" value="<?=$instructor->rate1 ?? $instructor['rate1'] ?? ''?>">
	</div>

	<div class="form-row"><label for="facultycategoryid">Faculty Category:</label>
                <select id="facultycategoryid" name="instructor[facultycategoryid]">
				<option value="NULL"> -- Select -- </option>
                <?php foreach ($facultycategories as $facultycategory): ?>
                    <option value="<?=$facultycategory->id?>" <?php if($instructor){if((isset($instructor->facultycategoryid) ?? $instructor['facultycategoryid'] ?? ' ') == $facultycategory->id){echo 'selected';}}?>>
                        <?=htmlspecialchars($facultycategory->name, ENT_QUOTES, 'UTF-8');?></option>
                <?php endforeach; ?>
                </select></div>
    

	<div class="form-row">
	<label for="academicappointment">Academic Appointment:</label>
    <input type="text" id="academicappointment" name="instructor[academicappointment]" value="<?=$instructor->academicappointment ?? $instructor['academicappointment'] ?? ''?>">
	</div>
</div>
<?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_USER_ACCESS)): ?>
<div class="div-permissions">
	<h3 class="form-row">Edit Permissions</h3>
	<?php foreach ($permissions as $name => $value): ?>
	<div class="form-row">
		<input name="permissions[]" type="checkbox" value="<?=$value?>" <?php if (is_object($instructor) && $instructor->hasPermission($value)) echo 'checked'; ?> />
		<label><?=ucwords(strtolower(str_replace('_', ' ', $name)))?></label>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if ($user == $instructor): ?>

<?php endif; ?>
</div>
	<div class="div-card-full">
	<input type="submit" value="Submit" />
	</div>
</form>
