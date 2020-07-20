<div class="div-card-full"> 
  <h2>Courses
  </h2>
  <form class="form-inline">
    <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_COURSES)): ?>
     <input type="button" onclick="document.location.href='index.php?course/edit'" value="Add">
    <?php endif; ?>
    <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::IMPORT_AND_EXPORT)): ?>
    <input type="button" onclick="document.location.href='index.php?import/upload'" value="Import">
    <input type="button" onclick="document.location.href='index.php?export/courses'" value="Export">
    <?php endif; ?>
  </form>
</div>
<div class="div-card-full">
  <details>
    <summary>Filters
    </summary>
    <div style="max-width:35em;">
      <div class="form-row">
        <label>Filter by Term: 
        </label>
        <select id="termselect"  onchange="document.location.href=this.value">
          <option value='index.php?course/list'>Show All
          </option>
          <?php foreach($terms as $term): ?>
          <option value='index.php?course/list?term=<?=$term->id?>' 
                  <?php if (isset($_GET['term'])){if ($_GET['term']  == $term->id){echo 'selected';}}?>> 
          <?=$term->termname?>
          </option>
        <?php endforeach; ?>
        </select>
      <br>
    </div>
    <div class="form-row">
      <label>Filter by Attribute: 
      </label>
      <select id="attributeselect" onchange="document.location.href=this.value">
        <option value='index.php?course/list'>Show All
        </option>
        <?php foreach($attributes as $attribute): ?>
        <option value='index.php?course/list?attribute=<?=$attribute->id?>' 
                <?php if (isset($_GET['attribute'])){if ($_GET['attribute'] == $attribute->id){echo 'selected';}}?>>
        <?=$attribute->name?>
        </option>
      <?php endforeach; ?>
      </select>
    <br>
    </div>
  <div class="form-row">
    <label>Filter by Subject: 
    </label>
    <select id="subjectselect" onchange="document.location.href=this.value">
      <option value='index.php?course/list'>Show All
      </option>
      <?php foreach($subjects as $subject): ?>
      <option value='index.php?course/list?subject=<?=$subject->id?>' 
              <?php if (isset($_GET['subject'])){if ($_GET['subject'] == $subject->id){echo 'selected';}}?>>
      <?=$subject->name?>
      </option>
    <?php endforeach; ?>
    </select>
  <br>
</div>
</div>
</details>
</div>
<div class="div-card-full">
  <div class="horizontal-scroll">
    <table id="table-course">
      <thead>
        <tr>
          <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_COURSES)): ?>
          <th>Manage
          </th>
          <?php endif; ?>
          <th>CRN
          </th>
          <th>Subject
          </th>
          <th>Number
          </th>
          <th>Section
          </th>
          <th>Campus
          </th>
          <th>Credits
          </th>
          <th>Title
          </th>
          <th>Days
          </th>
          <th>Time
          </th>
          <th>Actual
          </th>
          <th>Cap
          </th>
          <th>Remaining
          </th>
          <th>XL Actual
          </th>
          <th>XL Cap
          </th>
          <th>XL Rem
          </th>
          <th>Date
          </th>
          <th>Instructor
          </th>
          <th>Location
          </th> 
          <th>Term
          </th> 
        </tr>
      </thead>
      <tbody>
        <?php foreach($courses as $course): ?>
        <tr>
          <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_COURSES)): ?>
          <td data-title="Actions"> 
            <?php if ($user->id == $course->instructorId || $user->hasPermission(\Cms\Entity\Instructor::MODIFY_COURSES)): ?>
            <form>
              <input type="button" onclick="document.location.href='index.php?course/edit?id=<?=$course->id?>'" value="Edit">
            </form>
            <?php endif; ?>
            <?php if ($user->id == $course->instructorId || $user->hasPermission(\Cms\Entity\Instructor::MODIFY_COURSES)): ?>
            <form action="index.php?course/delete" method="post"> 
              <!-- / 6/3/18 JG MOD1L -->
              <input type="hidden" name="id" value="<?=$course->id?>">
              <input type="submit" value="Delete" class="button-delete" onclick="return confirm('Are you sure you want to delete this course?');">
            </form>
            <?php endif; ?>
          </td>
          <?php endif; ?>
          <td data-title="CRN">
            <?=htmlspecialchars($course->crn, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Subject">
            <?=htmlspecialchars($course->getSubject()->code, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Number">
            <?=htmlspecialchars($course->coursenumber, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Section">
            <?=htmlspecialchars($course->section, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Campus">
            <?=htmlspecialchars($course->getCampus()->name, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Credits">
            <?=htmlspecialchars($course->credithours, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Title">
            <?=htmlspecialchars($course->title, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Days">
            <?=htmlspecialchars($course->getTimeslot()->days ?? ' ', ENT_QUOTES, 'UTF-8');?>&nbsp;
          </td>
          <td data-title="Time">
            <?php if (!is_null($course->timeslotcode)): ?>
            <?=date('h:ia', strtotime(htmlspecialchars($course->getTimeslot()->timestart ?? '00:00', ENT_QUOTES, 'UTF-8'))); ?> -
            <?=date('h:ia', strtotime(htmlspecialchars($course->getTimeslot()->timeend ?? '00:00', ENT_QUOTES, 'UTF-8'))); ?>
            <?php else: ?>
            &nbsp;
            <?php endif; ?>
          </td>
          <td data-title="Actual">
            <?=htmlspecialchars($course->actual, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Capacity">
            <?=htmlspecialchars($course->capacity, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Remaining">
            <?=htmlspecialchars($course->capacity - $course->actual, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Crosslist Actual">
            <?=htmlspecialchars($course->crosslistactual, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Crosslist Cap">
            <?=htmlspecialchars($course->crosslistcapacity, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Crosslist Remaining">
            <?=htmlspecialchars($course->crosslistcapacity - $course->crosslistactual, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Date">
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termstart, ENT_QUOTES, 'UTF-8'))); ?>&nbsp;-&nbsp;
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termend, ENT_QUOTES, 'UTF-8'))); ?>
          </td>
          <td data-title="Instructor">
            <?php if ($course->primaryinstructor != null):?>
            <a href="mailto:<?=htmlspecialchars($course->getPrimaryInstructor()->email, ENT_QUOTES, 'UTF-8'); ?>"> 
              <?=htmlspecialchars($course->getPrimaryInstructor()->firstname, ENT_QUOTES, 'UTF-8'); ?>
              <?=htmlspecialchars($course->getPrimaryInstructor()->lastname, ENT_QUOTES, 'UTF-8'); ?> 
              <span title="Primary Instructor">(P)
              </span>
            </a>&nbsp;
            <?php endif; ?>
            <?php if ($course->secondaryinstructor != null):?>, 
            <a href="mailto:<?=htmlspecialchars($course->getSecondaryInstructor()->email, ENT_QUOTES, 'UTF-8'); ?>"> 
              <?=htmlspecialchars($course->getSecondaryInstructor()->firstname, ENT_QUOTES, 'UTF-8'); ?>
              <?=htmlspecialchars($course->getSecondaryInstructor()->lastname, ENT_QUOTES, 'UTF-8'); ?> 
              <span title="Secondary Instructor">(S)
              </span>
            </a>
            <?php endif; ?>
            <?php if ($course->tertiaryinstructor != null):?>, 
            <a href="mailto:<?=htmlspecialchars($course->getTertiaryInstructor()->email, ENT_QUOTES, 'UTF-8'); ?>"> 
              <?=htmlspecialchars($course->getTertiaryInstructor()->firstname, ENT_QUOTES, 'UTF-8'); ?>
              <?=htmlspecialchars($course->gettertiaryInstructor()->lastname, ENT_QUOTES, 'UTF-8'); ?> 
              <span title="Tertiary Instructor">(T)
              </span>
            </a>
            <?php endif; ?>&nbsp;
          </td>
          <td data-title="Location">
            <?=htmlspecialchars($course->building, ENT_QUOTES, 'UTF-8'); ?> 
            <?=htmlspecialchars($course->room, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Term">
            <?=htmlspecialchars($course->getTerm()->termname, ENT_QUOTES, 'UTF-8'); ?> 
          </td>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <!--END OF horizontal scroll -->
  <?php echo $totalCourses ?'Select page:': ''?> 
  <?php
$numPages = ceil($totalCourses/10);
for ($i = 1; $i <= $numPages; $i++):
if ($i == $currentPage):
?>
  <a class="currentpage" href="index.php?course/list?page=<?=$i?><?=!empty($subjectid) ? '&subject=' . $subjectid : '' ?><?=!empty($termid) ? '&term=' . $termid : '' ?>">
    <?=$i?>
  </a> 
  <?php else: ?>
  <a href="index.php?course/list?page=<?=$i?><?=!empty($subjectid) ? '&subject=' . $subjectid : '' ?><?=!empty($termid) ? '&term=' . $termid : '' ?>">
    <?=$i?>
  </a> 
  <?php endif; ?>
  <?php endfor; ?>
</div>


<?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_COURSES)): ?>
<?php if (!empty($warnings)): ?>
<div class="div-card-full">
	<div class="warnings">
		<p>The following warnings have been found: </p>
		<ul>
		<?php foreach ($warnings as $warning): ?>
			<li><?= $warning ?></li>
		<?php endforeach; 	?>
		</ul>
    </div>
	</div>
<?php endif; ?>
<?php endif; ?>