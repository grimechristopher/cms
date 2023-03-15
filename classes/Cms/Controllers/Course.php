<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Course {
	private $instructorsTable;
	private $coursesTable;
	private $departmentsTable;
	private $courseDepartmentsTable;
	private $timeslotTable;
	private $termTable;
	private $campusTable;
	private $subjectTable;
	private $attributeTable;
	private $courseAttributeTable;
	private $authentication;

	public function __construct(DatabaseTable $coursesTable, 
								DatabaseTable $instructorsTable, 
								DatabaseTable $departmentsTable, 
								DatabaseTable $courseDepartmentsTable, 
								DatabaseTable $timeslotTable,
								DatabaseTable $termTable,
								DatabaseTable $campusTable,
								DatabaseTable $subjectTable,
								DatabaseTable $attributeTable,
								DatabaseTable $courseAttributeTable,
								Authentication $authentication) { 
    	$this->coursesTable = $coursesTable;
		$this->instructorsTable = $instructorsTable;
		$this->departmentsTable = $departmentsTable;
		$this->courseDepartmentsTable = $courseDepartmentsTable;
		$this->timeslotTable = $timeslotTable;
		$this->termTable = $termTable;
		$this->campusTable = $campusTable;
		$this->subjectTable = $subjectTable;
		$this->attributeTable = $attributeTable;
		$this->courseAttributeTable = $courseAttributeTable;
		$this->authentication = $authentication;
	}

	public function home() {
		$title = 'Course Timetabling';
		$instructor = $this->authentication->getUser();
		return ['template' => 'home.html.php',
				'title' => $title, 
				'variables' => [
					'user' => $instructor]
			];
	}

	public function list() {
		$page = $_GET['page'] ?? 1;
		$offset = (intval($page)-1)*10;

		if (isset($_GET['department'])) {
			$department = $this->departmentsTable->findById($_GET['department']); 
			$courses = $department->getCourses(10, $offset);
			$totalCourses = $department->getNumCourses();
		}
		else if (isset($_GET['term'])) {
			$term = $this->termTable->findById($_GET['term']); 
			$courses = $term->getCourses(10, $offset);
			$totalCourses = $term->getNumCourses();
		}
		else if (isset($_GET['subject'])) {
			$subject = $this->subjectTable->findById($_GET['subject']); 
			$courses = $subject->getCourses(10, $offset);
			$totalCourses = $subject->getNumCourses();
		}
		else if (isset($_GET['attribute'])) {
			$attribute = $this->attributeTable->findById($_GET['attribute']); 
			$courses = $attribute->getCourses(10, $offset);
			$totalCourses = $attribute->getNumCourses();
		}
		else {
			$courses = $this->coursesTable->findAll('dateadded DESC', 10, $offset);
			$totalCourses = $this->coursesTable->total();
		}		

		$title = 'Course list';
		$instructor = $this->authentication->getUser();
		//$courses = $this->coursesTable->findAll('dateadded DESC', 10, $offset);

		$warnings = array();

		//Get instructors courses SQL
		//Get timeslots of each course
		//with each timeslot get the days start and end time
		//Go through each instructors timeslots to see if it conflits
		//If there is a conflict add a warning
		
		$instructors = $this->instructorsTable->findAll();
		foreach ($instructors as $instructor) {
			$instructorscourses = $instructor->getPrimaryCourses();
			foreach ($instructorscourses as $ic) {
				$conflictingDays = str_split($ic->getTimeslot()->days);
				$conflictingStart = $ic->getTimeslot()->timestart;
				$conflictingEnd = $ic->getTimeslot()->timeend;
				foreach ($instructorscourses as $cc) {
					if ($ic != $cc) {
						if (($conflictingStart >= $cc->getTimeslot()->timestart && $conflictingStart <= $cc->getTimeslot()->timeend) || ($conflictingEnd >= $cc->getTimeslot()->timestart && $conflictingEnd <= $cc->getTimeslot()->timeend) ) {
							//Check Days
							foreach($conflictingDays as $cd) {
								if (strpos($cc->getTimeslot()->days, $cd) !== false) {
									//If the day is found then break loop give warning
									// If the 'day' contains the word weekly -> Ignore it.
									if ($cc->getTimeslot()->days != "weekly") {
									    $warnings[] = $instructor->firstname . " " . $instructor->lastname . "'s " . $ic->title . " has a time conflicting with " . $cc->title;
									}
									break;
								}
							}
						}
					}
				}
			}
		}

		return ['template' => 'courses.html.php', 
				'title' => $title, 
				'variables' => [
						'totalCourses' => $totalCourses,
						'courses' => $courses,
						'user' => $this->authentication->getUser(),
						'departments' => $this->departmentsTable->findAll(),
						'subjects' => $this->subjectTable->findAll(),
						'terms' => $this->termTable->findAll(),
						'attributes' => $this->attributeTable->findAll(),
						'currentPage' => $page,
						'departmentid' => $_GET['department'] ?? null,
						'subjectid' => $_GET['subject'] ?? null,
						'termid' => $_GET['term'] ?? null,
						'attributeid' => $_GET['attribute'] ?? null,
						'warnings' => $warnings,
					]
				];
	}
	
	public function delete() {
		$instructor = $this->authentication->getUser();
		$course = $this->coursesTable->findById($_POST['id']);

		if ($course->creatorid != $instructor->id && !$instructor->hasPermission(\Cms\Entity\Instructor::DELETE_COURSES) ) {
			return;
		}

		$this->courseAttributeTable->deleteWhere('courseid', $_POST['id']);

		$this->coursesTable->delete($_POST['id']);   
        header('location: index.php?course/list');  
	}

	public function edit() {
		$instructor = $this->authentication->getUser();
		$departments = $this->departmentsTable->findAll();
		$timeslots = $this->timeslotTable->findAll();
		$terms = $this->termTable->findAll();
		$campuses = $this->campusTable->findAll();

		if (isset($_GET['id'])) {
			$course = $this->coursesTable->findById($_GET['id']);
		}

		$title = 'Edit course';

		return ['template' => 'editcourse.html.php',
				'title' => $title,
				'variables' => [
						'course' => $course ?? null,
						'user' => $instructor,
						'departments' => $departments,
						'timeslots' => $timeslots,
						'terms' => $this->termTable->findAll(),
						'campuses' => $this->campusTable->findAll(),
						'subjects' => $this->subjectTable->findAll(),
						'attributes' => $this->attributeTable->findAll(),
						'instructors' => $this->instructorsTable->findAll()
					]
				];
	}

	public function saveEdit() {
		$instructor = $this->authentication->getUser();
		
		$course = $_POST['course'];

		$valid = true;
		$errors = [];

		if (empty($course['title'])){
			$valid = false;
			$errors[] = 'The course title cannot be blank';
		}

		if (empty($course['crn'])){
			$valid = false;
			$errors[] = 'CRN cannot be blank';
		}
		else if (!is_numeric($course['crn'])){
			$valid = false;
			$errors[] = 'CRN must be a number';
		}

		if (empty($course['coursenumber']) ){
			$valid = false;
			$errors[] = 'The course number cannot be blank';
		}
		else if (!is_numeric($course['coursenumber'])){
			$valid = false;
			$errors[] = 'The course number must be a number';
		}

		if (empty($course['section'])){
			$valid = false;
			$errors[] = 'Section cannot be blank';
		}
		else if (!is_numeric($course['section'])){
			$valid = false;
			$errors[] = 'Section must be a number';
		}

		if (empty($course['credithours'])  && $course['credithours'] != 0){
			$valid = false;
			$errors[] = 'Credit hours cannot be blank';
		}
		else if (!is_numeric($course['credithours']) && $course['credithours'] <= 0){
			$valid = false;
			$errors[] = 'Credit hours must be a number'; // Add Verification for posititve numbers?
		}

		if (!is_numeric($course['capacity']) && !empty($course['capacity'])){
			$valid = false;
			$errors[] = 'Course capacity must be a number';
		}

		if (!is_numeric($course['actual']) && !empty($course['actual'])){
			$valid = false;
			$errors[] = 'Actual enrollment must be a number';
		}

		if (!is_numeric($course['crosslistcapacity']) && !empty($course['crosslistcapacity'])){
			$valid = false;
			$errors[] = 'Crosslist capacity must be a number';
		}

		if (!is_numeric($course['crosslistactual']) && !empty($course['crosslistactual'])){
			$valid = false;
			$errors[] = 'Crosslist actual must be a number';
		}

		if ($course["primaryinstructor"] == "NULL"){
			$course["primaryinstructor"] = null;
		}
		if ($course["secondaryinstructor"] == "NULL"){
			$course["secondaryinstructor"] = null;
		}
		if ($course["tertiaryinstructor"] == "NULL"){
			$course["tertiaryinstructor"] = null;
		}

		if ($valid == true) {
			$course['dateadded'] = new \DateTime();
			$courseEntity = $instructor->addCourse($course);
			foreach ($_POST['attribute'] as $attributeid) {
				$courseEntity->addAttribute($attributeid);
			}
			header('location: index.php?course/list'); 
		}
		else {
			$title = 'Edit course';
			return ['template' => 'editcourse.html.php', 
				    'title' => $title,
				    'variables' => [
						'course' => $course,
						'errors' => $errors,
						'user' => $instructor,
						'departments' =>  $this->departmentsTable->findAll(),
						'timeslots' => $this->timeslotTable->findAll(),
						'terms' => $this->termTable->findAll(),
						'campuses' => $this->campusTable->findAll(),
						'subjects' => $this->subjectTable->findAll(),
						'attributes' => $this->attributeTable->findAll(),
						'instructors' => $this->instructorsTable->findAll()
				    	]
				   ]; 
		}
	}	
	
}