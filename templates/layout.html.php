<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="google" content="notranslate">
		<title><?=$title?></title>
		<meta name=viewport content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="courses.css">
		<script src="courses.js"></script>
	</head>
	<body>
	<header>
		<a href="index.php"><h3>Course Management System</h3></a>
			<input type="checkbox" id="menutoggle">
			<div class="menuicon">
				<div></div>
				<div></div>
				<div></div>
			</div>
	</header>
	<nav><span>Menu</span>
		<ul>
		<li><a href="index.php?course/list">Courses</a></li>
		<li><a href="index.php?instructor/list">Instructors</a></li>
		<li><a href="index.php?department/list">Departments</a></li>
			</ul>
			<?php if ($loggedIn): ?>
			<?php if ($this->routes->checkPermission(\Cms\Entity\Instructor::MODIFY_COURSE_FIELDS)) : ?>
			<span>Course Fields</span>
			<ul>
			<li><a href="index.php?timeslot/list">Time Slots</a></li>
					  <?php endif; ?>
					  <?php if ($this->routes->checkPermission(\Cms\Entity\Instructor::MODIFY_COURSE_FIELDS)) : ?>
						<li><a href="index.php?term/list">Terms</a></li>
					<?php endif; ?>
					<?php if ($this->routes->checkPermission(\Cms\Entity\Instructor::MODIFY_COURSE_FIELDS)) : ?>
						<li><a href="index.php?campus/list">Campuses</a></li>
					<?php endif; ?>
					<?php if ($this->routes->checkPermission(\Cms\Entity\Instructor::MODIFY_COURSE_FIELDS)) : ?>
						<li><a href="index.php?subject/list">Subjects</a></li>
					<?php endif; ?>
					<?php if ($this->routes->checkPermission(\Cms\Entity\Instructor::MODIFY_COURSE_FIELDS)) : ?>
						<li><a href="index.php?attribute/list">Attributes</a></li>
					<?php endif; ?>
			</ul>
			<?php endif; ?>
			<?php if ($this->routes->checkPermission(\Cms\Entity\Instructor::MODIFY_FACULTY_FIELDS)) : ?>
			<span>Instructor Fields</span>
			<ul>
			<li><a href="index.php?facultycategory/list">Faculty Categories</a></li>
			</ul>
			<?php endif; ?>
			<?php if ($this->routes->checkPermission(\Cms\Entity\Instructor::IMPORT_AND_EXPORT)) : ?>
				<span>Import/Export</span>
			<ul>
			<li><a href="index.php?import/upload">Upload Courses</a></li>
			<li><a href="index.php?export/courses">Export Courses</a></li>
			</ul>
			<?php endif; ?>
			<span></span>
			<ul>
			<?php if ($loggedIn): ?>   
				<li><a href="index.php?logout" class="link-login">Log out</a></li>
			<?php else: ?>
				<li><a href="index.php?login" class="link-login">Login/Register</a></li>
			<?php endif; ?>
			</ul>
	</nav>

	<main>
	<?=$output?>
	</main>

	<footer>
	<div class="div-card-full">
		<p>See project on <a href="https://github.com/grimechristopher/cms">Github</a></p>
	</div>
	</footer>
	</body>
</html>