<?php if (!empty($errors)): ?>
<div class="div-card-full">
  <div class="errors">
    <p>Could not be deleted. Check below for more information.
    </p>
    <ul>
      <?php foreach ($errors as $error): ?>
      <li>
        <?= $error ?>
      </li>
      <?php endforeach; 	?>
    </ul>
  </div>
</div>
<?php endif; ?>
<!--<div class="flex-half">-->
<div class="div-card-full">
  <h2>Campuses
  </h2>
  <form >
    <input type="button" onclick="document.location.href='index.php?campus/edit'" value="Add">
  </form>
</div>
<div class="div-card-full">
  <table>
    <thead>
      <tr>
      <th>Manage
      </th>
      <th>Name
      </th>
      <th>Code
      </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($campuses as $campus): ?>
      <tr>
        <td data-title="Manage">
          <form class="inline-block">
            <input type="button" onclick="document.location.href='index.php?campus/edit?id=<?=$campus->id?>'" value="Edit">
          </form>
          <form action="index.php?campus/delete" class="inline-block" method="post"> 
            <input type="hidden" name="id" value="<?=$campus->id?>">
            <input type="submit" value="Delete" class="button-delete" onclick="return confirm('Are you sure you want to delete this campus?');">
          </form>
        </td>
        <td data-title="Name">
          <?=$campus->name;?>
        </td>
        <td data-title="Code">
          <?=$campus->code;?>
        </td>
      </tr>           
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<!--End of flex-container-->
