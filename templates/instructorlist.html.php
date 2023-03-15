<div class="div-card-full">
<h2>Instructors</h2>
<?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
<form><input type="button" onclick="document.location.href='index.php?instructor/permissions'" value="Add"></form>
<?php endif; ?>
</div>

<?php if (!empty($errors)): ?>
<div class="div-card-full">
	<div class="errors">
		<p>The following errors have occured:</p>
		<ul>
		<?php foreach ($errors as $error): ?>
			<li><?= $error ?></li>
		<?php endforeach; 	?>
		</ul>
    </div>
	</div>
<?php endif; ?>

<div class="div-card-full">
<div class="horizontal-scroll">
<table>
	<thead>
		<tr>
		<?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
		<th>Manage</th>
		<?php endif; ?>
		<th>Name</th>
		<th>Email</th>
		<th>Office Phone</th>
		<th>Faculty Category</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($instructors as $instructor): ?>
		<tr>
			<?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
				<td data-title="Edit">
				<form class="inline-block"> 
                    <input type="button" onclick="document.location.href='index.php?instructor/permissions?id=<?=$instructor->id;?>'" value="Edit">
                </form>
				<?php if ($user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
                    <form action="index.php?instructor/delete" class="inline-block" method="post"> <!-- / 6/3/18 JG MOD1L -->
                        <input type="hidden" name="id" value="<?=$instructor->id?>">
                       <input type="submit" class="button-delete" value="Delete" onclick="return confirm('Are you sure you want to delete this instructor?');">
                    </form></td> 
                <?php endif; ?>
			<?php endif; ?>
			<td data-title="Name"><a href="index.php?instructor/profile?id=<?=$instructor->id;?>"><?=$instructor->firstname;?> <?=$instructor->middlename ?? ''?> <?=$instructor->lastname;?></a></td>	
			<td data-title="Email"><a href="mailto:<?=htmlspecialchars($instructor->email, ENT_QUOTES, 'UTF-8'); ?>"> <?=$instructor->email;?></a></td>
			<td data-title="Office Phone"><?=$instructor->phone ?? "&nbsp;";?> </td>
			<td data-title="Faculty Category"><?php if ($instructor->getFacultyCategory() != null) {echo htmlspecialchars($instructor->getFacultyCategory()->name, ENT_QUOTES, 'UTF-8');} ?>&nbsp; </td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
</div>

