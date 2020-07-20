<div class="div-card-full">  
<?php if ($user): ?>
<p>Welcome <?=$user->firstname?>, to the Course Timetabling Management System.</p>
<?php else : ?>
<p>Welcome to the Course Timetabling Managment System.</p>
<?php endif?>
</div>
<div class="flex-container">
<a href="index.php?course/list" class="div-card-reg">
    <div>
        <h2>View Courses</h2>
</div>
</a>
<a href="index.php?instructor/list" class="div-card-reg">
    <div>
        <h2>View Instructors</h2>
</div>
</a>
<a href="index.php?department/list" class="div-card-reg">
    <div>
        <h2>View Departments</h2>
</div>
</a>
</div>

