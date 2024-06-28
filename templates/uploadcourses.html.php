<div class="div-card-full">
    <h2>Upload courses with CSV file</h2>
</div>
<div class="div-card-full">
    <form method="POST" enctype="multipart/form-data">
        <?php if (isset($filename)):?>
        <h3>Importing from "<?=$filename?>" to term <?=$term->termname?></h3>
            <?php else: ?>
            <label for="term"><strong>Select a Term</strong></label>
                <select id="term" name="term">
                <?php foreach ($terms as $term): ?>
                    <option value="<?=$term->id?>">
                        <?=htmlspecialchars($term->termname, ENT_QUOTES, 'UTF-8');?></option>
                <?php endforeach; ?>
                </select>
                <input type="file" name="csv">
                <input type="submit" value="Submit">
                <p>The uploaded file should be a csv file with the following header.</p>
                    <blockquote>Select,CRN,Subj,Crse,Sec,Cmp,Cred,,Title,Days,Time,Location,Cred,Cap,Act,Rem,XL Cap,XL Act,XL Rem,Primary Instructor,Secondary Instructor,Tertiary Instructor
</blockquote>
                
                <a href="../public/uploads/uploadtemplate.csv">Download a template CSV.</a>
        <?php endif; ?>
    </form>
</div>

<?php if (!empty($errors)): ?>
    <div class="div-card-full">
	    <div class="errors">
		    <p>The following errors occured. The courses will not be added. Please fix the errors in the CSV files to add the courses.</p>
		    <ul>
		        <?php foreach ($errors as $error): ?>
			    <li><?= $error ?></li>
		        <?php endforeach; 	?>
		    </ul>
        </div>
    </div>
    <?php endif; ?>

<?php if (isset($filename)):?>
    <div class="div-card-full">
    <p>The following courses will be added.</p>
<div class="horizontal-scroll">
    <table>
    <tr>
    <th>crn</th>
    <th>subject</th>
<th>number</th>
<th>section</th>
<th>campus</th>
<th>credit hours</th>
<th>title</th>
<th>days</th>
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
    <td><?=htmlspecialchars($courses[$i]['days'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['timestart'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['timeend'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['building'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['room'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['capacity'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['actual'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['crosslistcapacity'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['crosslistactual'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['pinstructor'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['sinstructor'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=htmlspecialchars($courses[$i]['tinstructor'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?php if ($courses[$i]['valid'] == true){echo "Valid";}?></td>
    </tr>
<?php endfor; ?>
</table>
</div>
</div>
<?php if (!empty($warnings)): ?>
    <div class="div-card-full">
	    <div class="warnings">
		    <p>The following warnings were found. The courses will still be added but with modified values.</p>
		    <ul>
		        <?php foreach ($warnings as $warning): ?>
			    <li><?=$warning?></li>
		        <?php endforeach; 	?>
		    </ul>
        </div>
    </div>
<?php endif; ?>
<form>
<div class="div-card-full">
    <p>The courses marked valid have been added to the database.</p>
</div>
</form>
<?php endif; ?>

