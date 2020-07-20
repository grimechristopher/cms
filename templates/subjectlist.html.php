<div class="div-card-full">
<h2>Subjects</h2>
<form><input type="button" onclick="document.location.href='index.php?subject/edit'" value="Add"></form>
</div>
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
<table>
<thead>
<tr>
<th>Manage</th>
<th>Short Code</th>
<th>Subject Name</th>
</tr>
</thead>
<tbody>
<?php foreach($subjects as $subject): ?>

<tr>
<td data-title="Manage">
<form class="inline-block"><input type="button" onclick="document.location.href='index.php?subject/edit?id=<?=$subject->id?>'" value="Edit"></form>
  <form action="index.php?subject/delete" class="inline-block" method="post"> <!-- 6/3/18 JG MOD1L -->
    <input type="hidden" name="id" value="<?=$subject->id?>">
    <input type="submit" value="Delete" class="button-delete" onclick="return confirm('Are you sure you want to delete this subject?');">
  </form>
  </td>
<td data-title="Short Code"> 
  <?=htmlspecialchars($subject->code, ENT_QUOTES, 'UTF-8')?></td>
  <td data-title="Subject Name"><?=htmlspecialchars($subject->name, ENT_QUOTES, 'UTF-8')?></td>
  </tr>

<?php endforeach; ?>
</tbody>
</table>
</div>