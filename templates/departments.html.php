<div class="div-card-full">
  <h2>Departments
  </h2>
  <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_DEPARTMENTS)): ?>
  <form>
    <input type="button" onclick="document.location.href='index.php?department/edit'" value="Add">
  </form>
  <?php endif; ?>
</div>
<div class="div-card-full">
  <table>
    <thead>
      <tr>
        <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_DEPARTMENTS)): ?>
        <th>Manage
        </th>
        <?php endif; ?>
        <th>Department Name
        </th>
        <th>Subjects
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($departments as $department): ?>
      <tr>
        <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_DEPARTMENTS)): ?>
        <td data-title="Manage">
          <form class="inline-block">
            <input type="button" onclick="document.location.href='index.php?department/edit?id=<?=$department->id?>'" value="Edit">
          </form> 
          <form action="index.php?department/delete" method="post" class="inline-block"> 
            <input type="hidden" name="id" value="<?=$department->id?>">
            <input type="submit" class="button-delete" value="Delete" onclick="return confirm('Are you sure you want to delete this department?');">
          </form>
        </td>
        <?php endif; ?>
        <td data-title="Department">
          <?=htmlspecialchars($department->name, ENT_QUOTES, 'UTF-8')?>
        </td>
        <td data-title="Subjects">      
          <?php foreach($subjects as $subject): ?>
          <?php foreach($subjectDepartments as $subjectDepartment):?>
          <?php if (($subject->id == $subjectDepartment->subjectid) && ($department->id == $subjectDepartment->departmentid)): ?>
          <?=$subject->code?> - 
          <?=$subject->name?>
          <br>
          <?php endif; ?>
          <?php endforeach; ?>
          <?php endforeach; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
