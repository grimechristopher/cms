<!--5-29-19 CGrime MOD : Changed all joke to course and author to instructor-->
<!--<h2>CMS</h2>-->
<div class="div-card-full">
  <h2>Instructor Details
  </h2>
</div>
<div class="div-card-full">  
  <h2>
    <?=$instructor->firstname?> 
    <?=$instructor->middlename?> 
    <?=$instructor->lastname?>
  </h2>
  <h4>Title: 
    <?=$instructor->getFacultyCategory()->name ?? ' ' ?>
  </h4>
  <h4>Office Phone: 
    <?=$instructor->officephone ?? ' '?>
  </h4>
  <h4>Email: 
    <a href="mailto:<?=htmlspecialchars($instructor->email, ENT_QUOTES, 'UTF-8'); ?>"> 
      <?=$instructor->email;?>
    </a>
  </h4>
  <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::ACCESS_PAY_INFO)): ?>
  <h3>Pay Info: 
  </h3>
  <h4>Workload Capacity: 
    <?=$instructor->workloadcap?>
  </h4>
  <h4>Pay rate for 3 or more units: 
    <?=$instructor->rate345?>
  </h4>
  <h4>Pay rate for 2 units: 
    <?=$instructor->rate2?>
  </h4>
  <h4>Pay rate for 1 units: 
    <?=$instructor->rate1?>
  </h4>
  <?php endif; ?>
</div>
<div class="div-card-full"> 
  <div class="horizontal-scroll">
    <?php if (!empty($primarycourses)): ?>
    <h3>The instructor is a primary instructor of the following courses: 
    </h3>
    <table id="table-course">
      <thead>
        <tr>
          <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
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
        </tr>
      </thead>
      <!--<blockquote><th>Subject</th>&nbsp;<th>Number</th>&nbsp;<th>Units</th>&nbsp;<th>Instructor</th>&nbsp;<th>Date</th></blockquote>-->
      <tbody>
        <?php foreach ($primarycourses as  $course): ?>
        <tr>
          <?php if ($user): ?>
          <td data-title="Actions"> 
            <?php if ($user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
            <form>
              <input type="button" onclick="document.location.href='index.php?course/edit?id=<?=$course->id?>'" value="Edit">
            </form>
            <?php endif; ?>
            <?php if ($user->id == $course->instructorId || $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
            <form action="index.php?course/delete" method="post"> 
              <!-- / 6/3/18 JG MOD1L -->
              <input type="hidden" name="id" value="<?=$course->id?>">
              <input type="submit" class="button-delete" value="Delete" onclick="return confirm('Are you sure you want to delete this course?');">
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
          <td>
            <?=htmlspecialchars($course->campusid, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Credits">
            <?=htmlspecialchars($course->credithours, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Title">
            <?=htmlspecialchars($course->title, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Days">
            <?=htmlspecialchars($course->getTimeslot()->days, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Time">
            <?=date('h:i:s a', strtotime(htmlspecialchars($course->getTimeslot()->timestart, ENT_QUOTES, 'UTF-8'))); ?> 
            <br> - 
            <?=date('h:i:s a', strtotime(htmlspecialchars($course->getTimeslot()->timeend, ENT_QUOTES, 'UTF-8'))); ?>
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
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termstart, ENT_QUOTES, 'UTF-8'))); ?> - 
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termend, ENT_QUOTES, 'UTF-8'))); ?>
          </td>
          <td data-title="Instructor">
            <?php if ($course->primaryinstructor != null):?>
            <a href="mailto:<?=htmlspecialchars($course->getPrimaryInstructor()->email, ENT_QUOTES, 'UTF-8'); ?>"> 
              <?=htmlspecialchars($course->getPrimaryInstructor()->firstname, ENT_QUOTES, 'UTF-8'); ?>
              <?=htmlspecialchars($course->getPrimaryInstructor()->lastname, ENT_QUOTES, 'UTF-8'); ?> 
              <span title="Primary Instructor">(P)
              </span>
            </a>
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
            <?php endif; ?>
          </td>
          <td data-title="Location">
            <?=htmlspecialchars($course->building, ENT_QUOTES, 'UTF-8'); ?> 
            <?=htmlspecialchars($course->room, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <!--<td data-title=" ">
<?//php $date = new DateTime($course->dateadded);
//echo $date->format('jS F Y'); ?>
</td>-->
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <p>This instructor is not the primary instructor of any courses.
    </p>
    <?php endif; ?>
    <!------------------------------------------------------------------------------------------------->
    <?php if (!empty($secondarycourses)): ?>
    <h3>The instructor is a secondary instructor of the following courses: 
    </h3>
    <table id="table-course">
      <thead>
        <tr>
          <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
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
        </tr>
      </thead>
      <tbody>
        <?php foreach ($secondarycourses as  $course): ?>
        <tr>
          <?php if ($user): ?>
          <td data-title="Actions"> 
            <?php if ($user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
            <form>
              <input type="button" onclick="document.location.href='index.php?course/edit?id=<?=$course->id?>'" value="Edit">
            </form>
            <?php endif; ?>
            <?php if ($user->id == $course->instructorId || $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
            <form action="index.php?course/delete" method="post"> 
              <input type="hidden" name="id" value="<?=$course->id?>">
              <input type="submit" class="button-delete" value="Delete" onclick="return confirm('Are you sure you want to delete this course?');">
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
          <td>
            <?=htmlspecialchars($course->campusid, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Credits">
            <?=htmlspecialchars($course->credithours, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Title">
            <?=htmlspecialchars($course->title, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Days">
            <?=htmlspecialchars($course->getTimeslot()->days, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Time">
            <?=date('h:i:s a', strtotime(htmlspecialchars($course->getTimeslot()->timestart, ENT_QUOTES, 'UTF-8'))); ?> 
            <br> - 
            <?=date('h:i:s a', strtotime(htmlspecialchars($course->getTimeslot()->timeend, ENT_QUOTES, 'UTF-8'))); ?>
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
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termstart, ENT_QUOTES, 'UTF-8'))); ?> - 
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termend, ENT_QUOTES, 'UTF-8'))); ?>
          </td>
          <td data-title="Instructor">
            <?php if ($course->primaryinstructor != null):?>
            <a href="mailto:<?=htmlspecialchars($course->getPrimaryInstructor()->email, ENT_QUOTES, 'UTF-8'); ?>"> 
              <?=htmlspecialchars($course->getPrimaryInstructor()->firstname, ENT_QUOTES, 'UTF-8'); ?>
              <?=htmlspecialchars($course->getPrimaryInstructor()->lastname, ENT_QUOTES, 'UTF-8'); ?> 
              <span title="Primary Instructor">(P)
              </span>
            </a>
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
            <?php endif; ?>
          </td>
          <td data-title="Location">
            <?=htmlspecialchars($course->building, ENT_QUOTES, 'UTF-8'); ?> 
            <?=htmlspecialchars($course->room, ENT_QUOTES, 'UTF-8'); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <p>This instructor is not the secondary instructor of any courses.
    </p>
    <?php endif; ?>
    <!-------------------------------------------------------------------------------------------------->
    <?php if (!empty($tertiarycourses)): ?>
    <h3>The instructor is a tertiary instructor of the following courses: 
    </h3>
    <table id="table-course">
      <thead>
        <tr>
          <?php if ($user && $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
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
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tertiarycourses as  $course): ?>
        <tr>
          <?php if ($user): ?>
          <td data-title="Actions"> 
            <?php if ($user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
            <form>
              <input type="button" onclick="document.location.href='index.php?course/edit?id=<?=$course->id?>'" value="Edit">
            </form>
            <?php endif; ?>
            <?php if ($user->id == $course->instructorId || $user->hasPermission(\Cms\Entity\Instructor::MODIFY_INSTRUCTORS)): ?>
            <form action="index.php?course/delete" method="post"> 
              <input type="hidden" name="id" value="<?=$course->id?>">
              <input type="submit" class="button-delete" value="Delete" onclick="return confirm('Are you sure you want to delete this course?');">
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
          <td>
            <?=htmlspecialchars($course->campusid, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Credits">
            <?=htmlspecialchars($course->credithours, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Title">
            <?=htmlspecialchars($course->title, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Days">
            <?=htmlspecialchars($course->getTimeslot()->days, ENT_QUOTES, 'UTF-8'); ?>
          </td>
          <td data-title="Time">
            <?=date('h:i:s a', strtotime(htmlspecialchars($course->getTimeslot()->timestart, ENT_QUOTES, 'UTF-8'))); ?> 
            <br> - 
            <?=date('h:i:s a', strtotime(htmlspecialchars($course->getTimeslot()->timeend, ENT_QUOTES, 'UTF-8'))); ?>
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
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termstart, ENT_QUOTES, 'UTF-8'))); ?> - 
            <?=date('m/d/y', strtotime(htmlspecialchars($course->getTerm()->termend, ENT_QUOTES, 'UTF-8'))); ?>
          </td>
          <td data-title="Instructor">
            <?php if ($course->primaryinstructor != null):?>
            <a href="mailto:<?=htmlspecialchars($course->getPrimaryInstructor()->email, ENT_QUOTES, 'UTF-8'); ?>"> 
              <?=htmlspecialchars($course->getPrimaryInstructor()->firstname, ENT_QUOTES, 'UTF-8'); ?>
              <?=htmlspecialchars($course->getPrimaryInstructor()->lastname, ENT_QUOTES, 'UTF-8'); ?> 
              <span title="Primary Instructor">(P)
              </span>
            </a>
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
            <?php endif; ?>
          </td>
          <td data-title="Location">
            <?=htmlspecialchars($course->building, ENT_QUOTES, 'UTF-8'); ?> 
            <?=htmlspecialchars($course->room, ENT_QUOTES, 'UTF-8'); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <p>This instructor is not the tertiary instructor of any courses.
    </p>
    <?php endif; ?>
  </div>
</div>
</div>
