<form method="post">
<div class="div-card-full">
<?php if ((!$course)|| empty($course->id)): ?>
    <h2>Add Course</h2>
    <?php elseif ($course): ?>
    <h2>Edit <?=$course->title?></h2>
<?php endif;?>
    <p>Enter the course details below:</p>
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


    <?php if (empty($course->id) || $user->id == $course->creatorid || $user->hasPermission(\Cms\Entity\Instructor::MODIFY_COURSES)): ?>
        <input type="hidden" name="course[id]" value="<?=$course->id ?? ''?>">
        <div class="div-card-full">
            <h3 class="form-row">Course Details:</h3>
            <div class="form-row"><label for="title">Course Title:</label><input type="text" id="title" name="course[title]" value="<?=$course->title ?? $course['title'] ?? ''?>"></div>
            <div class="form-row"><label for="crn">Course CRN:</label><input type="text" id="crn" name="course[crn]" value="<?=$course->crn ?? $course['crn'] ?? ''?>"></div>
            <div class="form-row"><label for="subjectid">Subject: </label>
                <select id="subjectid" name="course[subjectid]">
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?=$subject->id?>" <?php if($course){if(($course->subjectid ?? $course['subjectid'])  == $subject->id){ echo 'selected';}}?>><?=htmlspecialchars($subject->name, ENT_QUOTES, 'UTF-8');?></option>
                <?php endforeach; ?>
                </select></div>
            <div class="form-row"><label for="coursenumber">Course Number:</label><input type="text" id="coursenumber" name="course[coursenumber]" value="<?=$course->coursenumber ?? $course['coursenumber'] ?? ''?>"></div>
            <div class="form-row"><label for="section">Course Section:</label><input type="text" id="section" name="course[section]" value="<?=$course->section ?? $course['section'] ?? ''?>"></div>
            <div class="form-row"><label for="credithours">Credit Hours:</label><input type="text" id="credithours" name="course[credithours]" value="<?=$course->credithours ?? $course['credithours'] ?? ''?>"></div>
            
            <div class="form-row">Select the attributes of this course:</div>
                <?php foreach ($attributes as $attribute): ?>
                <div class="form-row form-checkboxes">

                        <input type="checkbox" name="attribute[]" value="<?=$attribute->id?>" /> 

                    <label><?=$attribute->name?></label>
</div>
                <?php endforeach; ?>

            <h3 class="form-row">Student Enrollment&nbsp;<small>(Optional)</small>: </h3>
            <div class="form-row"><label for="actual">Actual Enrollment:</label><input type="text" id="actual" name="course[actual]" value="<?=$course->actual ?? $course['actual'] ?? '0'?>" size="3">
                <label for="capacity">Capacity:</label><input type="text" id="capacity" name="course[capacity]" value="<?=$course->capacity ?? $course['capacity'] ?? '0'?>" size="3"></div>
            <div class="form-row"><label for="crosslistactual">Crosslist Actual:</label><input type="text" id="crosslistactual" name="course[crosslistactual]" value="<?=$course->crosslistactual ?? $course['crosslistactual'] ?? '0'?>" size="3">
                <label for="crosslistcapacity">Crosslist Capacity:</label><input type="text" id="crosslistcapacity" name="course[crosslistcapacity]" value="<?=$course->crosslistcapacity ?? $course['crosslistcapacity'] ?? '0'?>" size="3"></div>
            <h3 class="form-row">Time and Location:</h3>
            <div class="form-row"><label for="termid">Term: </label>
                <select id="termid" name="course[termid]">
                    <?php foreach ($terms as $term): ?>
                    <option value="<?=$term->id?>" <?php if($course){if(($course->termid ?? $course['termid'])  == $term->id){echo 'selected';}}?>>
                        <?=htmlspecialchars($term->termname, ENT_QUOTES, 'UTF-8');?></option>
                    <?php endforeach; ?>
                </select></div>
            <div class="form-row"><label for="building">Building <small>- Optional</small>:</label><input type="text" id="building" name="course[building]" value="<?=$course->building ?? $course['building'] ?? ''?>"></div>
            <div class="form-row"><label for="room">Room <small>- Optional</small>:</label><input type="text" id="room" name="course[room]" value="<?=$course->room ?? $course['room'] ?? ''?>"></div>

                <div class="form-row"><label for="timeslotcode">Timeslot:</label>
                <select id="timeslotcode" name="course[timeslotcode]">
                <?php foreach ($timeslots as $timeslot): ?>
                    <option value="<?=$timeslot->code?>" <?php if(isset($course)){if((isset($course->timeslotcode)) == $timeslot->code){echo 'selected';}}?>>
                        <?=htmlspecialchars($timeslot->days, ENT_QUOTES, 'UTF-8');?>  <?=date('h:i:s a', strtotime(htmlspecialchars($timeslot->timestart, ENT_QUOTES, 'UTF-8'))); ?> - 
                        <?=date('h:i:s a', strtotime(htmlspecialchars($timeslot->timeend, ENT_QUOTES, 'UTF-8'))); ?></option>
                <?php endforeach; ?>
                </select></div>
            <div class="form-row">
    <label for="campusid">Campus: </label>
    <select id="campusid" name="course[campusid]">
    <?php foreach ($campuses as $campus): ?>
        <option value="<?=$campus->id?>" <?php if($course){if(($course->campusid ?? $course['campusid']) == $campus->id){echo 'selected';}}?>>
            <?=htmlspecialchars($campus->name, ENT_QUOTES, 'UTF-8');?></option>
    <?php endforeach; ?>
    </select></div>
<h3 class="form-row">Instructor Information: </h3>
    <div class="form-row">
    <label for="primaryinstructor">Primary Instructor: </label>
    <select id="primaryinstructor" name="course[primaryinstructor]">
    <option value="NULL"> --- </option>
    <?php foreach ($instructors as $instructor): ?>
        <option value="<?=$instructor->id?>" <?php if($course){if(($course->primaryinstructor ?? '') == $instructor->id){echo 'selected';}}?>>
            <?=htmlspecialchars($instructor->firstname, ENT_QUOTES, 'UTF-8');?> <?=htmlspecialchars($instructor->lastname, ENT_QUOTES, 'UTF-8');?></option>
    <?php endforeach; ?>
    </select></div>
        <div class="form-row"><label for="primarypercentage">Primary Percentage:</label><input type="text" id="primarypercentage" name="course[primarypercentage]" value="<?=$course->primarypercentage ?? $course['primarypercentage'] ?? '0'?>"></div>
    

    <div class="form-row">
    <label for="secondaryinstructor">Secondary Instructor: </label>
    <select id="secondaryinstructor" name="course[secondaryinstructor]">
        <option value="NULL"> --- </option>
    <?php foreach ($instructors as $instructor): ?>
        <option value="<?=$instructor->id?>" <?php if($course){if(($course->secondaryinstructor ?? '') == $instructor->id){echo 'selected';}}?>>
            <?=htmlspecialchars($instructor->firstname, ENT_QUOTES, 'UTF-8');?> <?=htmlspecialchars($instructor->lastname, ENT_QUOTES, 'UTF-8');?></option>
    <?php endforeach; ?>
    </select></div>
    <div class="form-row"><label for="secondarypercentage">Secondary Percentage:</label><input type="text" id="secondarypercentage" name="course[secondarypercentage]" value="<?=$course->secondarypercentage ?? $course['secondarypercentage'] ?? '0'?>"></div>


    <div class="form-row">
    <label for="tertiaryinstructor">Tertiary Instructor: </label>
    <select id="tertiaryinstructor" name="course[tertiaryinstructor]">
    <option value="NULL"> --- </option>
    <?php foreach ($instructors as $instructor): ?>
        <option value="<?=$instructor->id?>" <?php if($course){if(($course->tertiaryinstructor ?? '') == $instructor->id){echo 'selected';}}?>>
            <?=htmlspecialchars($instructor->firstname, ENT_QUOTES, 'UTF-8');?> <?=htmlspecialchars($instructor->lastname, ENT_QUOTES, 'UTF-8');?></option>
    <?php endforeach; ?>
    </select></div>
    <div class="form-row"><label for="tertiarypercentage">Tertiary Percentage:</label><input type="text" id="tertiarypercentage" name="course[tertiarypercentage]" value="<?=$course->tertiarypercentage ?? $course['tertiarypercentage'] ?? '0'?>"></div>

    </div><!--End of div card  -->

    <div class="div-card-full">
    <p><input type="submit" name="submit" value="Save"></p>
    </div>
<?php else: ?>
    <p>You may only edit courses that you posted.</p>
<?php endif; ?>
</form>