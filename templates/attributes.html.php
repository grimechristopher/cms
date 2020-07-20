<div class="div-card-full">
  <h2>Attributes
  </h2>
  <form>
    <input type="button" onclick="document.location.href='index.php?attribute/edit'" value="Add"> 
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
</tr>
    </thead>
    <?php foreach($attributes as $attribute): ?>
    <tr>
      <td data-title="Manage">
        <form class="inline-block">
          <input type="button" onclick="document.location.href='index.php?attribute/edit?id=<?=$attribute->id?>'" value="Edit">
        </form>
        <form action="index.php?attribute/delete" method="post" class="inline-block">
          <input type="hidden" name="id" value="<?=$attribute->id?>">
          <input type="submit" value="Delete" class="button-delete" onclick="return confirm('Are you sure you want to delete this attribute?');"> 
        </form>
      </td>
      <td data-title="Name">
        <?=htmlspecialchars($attribute->name, ENT_QUOTES, 'UTF-8')?>
      </td>
    </tr>
    <?php endforeach; ?> 
  </table>
</div>
