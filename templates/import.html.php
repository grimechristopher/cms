<div class="flex-container">
<div class="div-card-full">
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
<div class="horizontal-scroll">
<table class="horizontal-scroll">
<tr>
<th>crn</th>
<th>subject</th>
<th>number</th>
<th>section</th>
<th>campus</th>
<th>credit hours</th>
<th>title</th>
<th>time start</th>
<th>time end</th>
<th>building</th>
<th>room</th>
<th>cap</th>
<th>actual</th>
<th>xl cap</th>
<th>xl actual</th>
<th>Primary Instructor</th>
<th>Secondary Instructor</th>
<th>Tertiary Instructor</th>
<th>Valid</th>
<th>Subject Id</th>
<th>Campus Id</th>
</tr>
<?php for($i = 1; $i < count($courses); $i++): ?>
    <tr>
    <td><?=htmlspecialchars($courses[$i]['crn'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['subject'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['coursenumber'], ENT_QUOTES, 'UTF-8')?></td> 
    <td><?=htmlspecialchars($courses[$i]['section'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['campus'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['credithours'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['title'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['timestart'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['timeend'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['building'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['room'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['capacity'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['actual'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['crosslistcapacity'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['crosslistactual'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['primaryinstructor'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['secondaryinstructor'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['tertiaryinstructor'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?php if ($courses[$i]['valid'] == true){echo "Valid";}?></td>
    <td><?=htmlspecialchars($courses[$i]['subjectid'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['campusid'], ENT_QUOTES, 'UTF-8')?></td>
    </tr>
<?php endfor; ?>
</table>
</div>
</div>
</div>