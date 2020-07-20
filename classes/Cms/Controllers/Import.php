<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Import {
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

	public function upload() {
		$title = 'Upload CSV File';
		$warnings = [];

		//https://www.tutorialspoint.com/php/php_file_uploading.htm
		if(isset($_FILES['csv'])){
			$errors= [];
			$file_name = $_FILES['csv']['name'];
			$file_name = $this->authentication->getUser()->id . $file_name; // Working
			$file_size =$_FILES['csv']['size'];
			$file_tmp =$_FILES['csv']['tmp_name'];
			$file_type=$_FILES['csv']['type'];
			$tmp = explode('.', $file_name);
			$file_ext=strtolower(end($tmp));
			
			$extensions= array("csv");
			
			if(in_array($file_ext,$extensions)=== false){
			   $errors[]="extension not allowed, please choose a CSV file.";
			}
			
			if($file_size > 2097152){
			   $errors[]='File size must be less than 2 MB';
			}
			
			if(empty($errors)==true){
			   move_uploaded_file($file_tmp,"uploads/".$file_name);
			   //echo "Success";
			}else{
			   print_r($errors);
			}
			$courses = [];
			$term = $this->termTable->findById($_POST['term']);
			$file = fopen("uploads/" . $file_name, "r");

			//Need to add checking for if the first line has the correct fields.
			while ($row = fgetcsv($file, 0, ",")) {
				$c['id'] = NULL;
				$c['crn'] = $row[1];
				//find subjectid with subject DONE
				$c['subject'] = $row[2];
				$c['coursenumber'] = $row[3];
				$c['section'] = $row[4];
				//find campusid whith campus DONE
				$c['campus'] = $row[5];
				$c['credithours'] = $row[6];
				$c['title'] = $row[8]; 
				$c['days'] = $row[9];
				$time = explode("-", "$row[10]-", 2);
				$c['timestart'] = $time[0];
				$c['timeend'] = $time[1];
				//find timeslotcode with time info
				$c['termid'] = 1;
				//$location = str_replace(' ', '-', );
				$location = explode(" ", "$row[11] ", 2); //No clue why that works
				$room = $location[1];
				$c['building'] = $location[0];
				$c['room'] = $location[1];
				$c['capacity'] = $row[13];
				$c['actual'] = $row[14];
				$c['crosslistcapacity'] = $row[16];
				$c['crosslistactual'] = $row[17];
				//check if we can find the instructors
				$c['pinstructor']  = $row[19];
				$c['sinstructor'] = $row[20];
				$c['tinstructor']  = $row[21] ?? " ";
				$c['primaryinstructor']  = NULL;
				$c['secondaryinstructor'] = NULL;
				$c['tertiaryinstructor']  = NULL;
				$c['creatorid'] = NULL;
				$c['dateadded'] = NULL;
				$c['timeslotcode'] = NULL;

				$c['termid'] = $term->id;
				$c['valid'] = true;
				$courses[] = $c;			}
				$errors = [];
				for($i = 1; $i < sizeof($courses); $i++) {
					$column = 'code';
					$value = $courses[$i]['subject'];
					$subject = $this->subjectTable->find($column, $value, $orderBy = null, $limit = null, $offset = null);
					if ($subject){
						$courses[$i]['subjectid'] = $subject[0]->id;
					}
					else {
						$errors[] = "Subject " .$courses[$i]['subject'] . ' does not exist. Course will not be added';
					}
					$column = "Concat(firstname,' ', Ifnull(middleName,' '), lastname)";
					$column = "CONCAT_WS(' ', firstname, middlename, lastname)";
					$value = $courses[$i]['pinstructor'];
					$primaryinstructor = $this->instructorsTable->find($column, $value, $orderBy = null, $limit = null, $offset = null);

					if ($primaryinstructor){
						$courses[$i]['primaryinstructor'] = $primaryinstructor[0]->id;
					}
					elseif ($courses[$i]['pinstructor']) {
						$warnings[] = 'Instructor ' . $courses[$i]['pinstructor'] . '  could not be found. Course will be added with no primary instructor';
					}
					$column = "CONCAT(firstname, ' ', middlename+' ', lastname)";
					$value = $courses[$i]['sinstructor'];
					$secondaryinstructor = $this->instructorsTable->find($column, $value, $orderBy = null, $limit = null, $offset = null);
					if ($secondaryinstructor){
						$courses[$i]['secondaryinstructor'] = $secondaryinstructor[0]->id;
					}
					elseif ($courses[$i]['sinstructor']) {
						$warnings[] = 'Instructor ' . $courses[$i]['sinstructor'] . '  could not be found. Course will be added with no secondary instructor';
					}

					$column = "CONCAT(firstname, ' ', middlename+' ', lastname)";
					$value = $courses[$i]['tinstructor'];
					$tertiaryinstructor = $this->instructorsTable->find($column, $value, $orderBy = null, $limit = null, $offset = null);
					if ($secondaryinstructor){
						$courses[$i]['tertitaryinstructor'] = $tertiaryinstructor[0]->id;
					}
					elseif ($courses[$i]['tinstructor']) {
						$warnings[] = 'Instructor ' . $courses[$i]['tinstructor'] . '  could not be found. Course will be added with no tertiary instructor';
					}

					$column = 'code';
					$value = $courses[$i]['campus'];
					$campus = $this->campusTable->find($column, $value, $orderBy = null, $limit = null, $offset = null);
					if ($campus){
						$courses[$i]['campusid'] = $campus[0]->id;
					}
					else {
						$errors[] = "Campus " . $courses[$i]['campus'] . ' does not exist. Course will not be added';
						$courses[$i]['valid'] = false;
					}

					$stime = date('H:i',strtotime($courses[$i]['timestart']));
					$etime = date('H:i',strtotime(substr($courses[$i]['timeend'], 0, -1)));
					$column = "CONCAT(timestart, ' ', timeend)";
					$value = $stime . ":00" . " ". $etime . ":00";
					$timeslot = $this->timeslotTable->find($column, $value, $orderBy = null, $limit = null, $offset = null);
					if ($timeslot){
						foreach ($timeslot as $timeslot) {
							if ($timeslot->days == $courses[$i]['days']) {
								$courses[$i]['timeslotcode'] = $timeslot->code;
							}
						}
					}
					else {
						$warnings[] = "Timeslot " . $courses[$i]['days'] . " " . $courses[$i]['timestart'] . "-" . $courses[$i]['timeend'] . ' could not be found. Course will be added without a time';
					}

					if (empty($courses[$i]['coursenumber']) ){
						$courses[$i]['valid'] = false;
						$errors[] = 'Course number cannot be blank';
					}
					else if (!is_numeric($courses[$i]['coursenumber'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Course number ' . $courses[$i]['coursenumber'] . ' must be a number. The course will not be added';
					}
					if (empty($courses[$i]['credithours'])  && $courses[$i]['credithours'] != 0){
						$courses[$i]['valid'] = false;
						$errors[] = 'Credit Hours cannot be blank';
					}
					else if (!is_numeric($courses[$i]['credithours'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Credit Hours ' . $courses[$i]['credithours'] . ' must be a number. The course will not be added'; 
					}
					if (empty($courses[$i]['crn'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'CRN cannot be blank';
					}
					else if (!is_numeric($courses[$i]['crn'])){
						$courses[$i]['valid']= false;
						$errors[] = 'CRN ' . $courses[$i]['crn'] . ' must be a number. The course will not be added';
					}
					if (empty($courses[$i]['section'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Section cannot be blank';
					}
					else if (!is_numeric($courses[$i]['section'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Section ' . $courses[$i]['section'] . ' must be a number';
					}
					if (empty($courses[$i]['title'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Title cannot be blank';
					}
					if (empty($courses[$i]['building'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Building cannot be blank';
					}
					if (!is_numeric($courses[$i]['capacity']) && !empty($courses[$i]['capacity'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Capacity ' . $courses[$i]['capacity'] . ' must be a number. The course will not be added';
					}
					if (!is_numeric($courses[$i]['crosslistcapacity']) && !empty($courses[$i]['crosslistcapacity'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Crosslist Capacity ' . $courses[$i]['crosslistcapacity'] . ' must be a number. The course will not be added';
					}
					if (!is_numeric($courses[$i]['actual']) && !empty($courses[$i]['actual'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Actual Enrollment ' . $courses[$i]['actual'] . ' must be a number. The course will not be added';
					}
					if (!is_numeric($courses[$i]['crosslistactual']) && !empty($courses[$i]['crosslistactual'])){
						$courses[$i]['valid'] = false;
						$errors[] = 'Crosslist Actual ' . $courses[$i]['crosslistactual'] . ' must be a number. The course will not be added';
					}

					//Duplicate Check.
					$savedCourses = $this->coursesTable->findAll();
					foreach ($savedCourses as $course) {
						if (($course->title == $courses[$i]['title']) &&
							($course->crn == $courses[$i]['crn']) ) {
								$courses[$i]['valid'] = false;
								$errors[] = 'A duplicate course already is in the database for this term. The duplicate course will not be added.';
						}
					}
				}
				$final = $courses;
				for ($i = 0; $i < sizeof($final); $i++) {
					if ($final[$i]['valid'] == true) {
						unset($final[$i]['subject']);
						unset($final[$i]['campus']);
						unset($final[$i]['pinstructor']);
						unset($final[$i]['sinstructor']);
						unset($final[$i]['tinstructor']);
						unset($final[$i]['days']);
						unset($final[$i]['timestart']);
						unset($final[$i]['timeend']);
						unset($final[$i]['valid']);

						$final[$i]['dateadded'] = new \DateTime();
						$instructor = $this->authentication->getUser(); 
						$courseEntity = $instructor->addCourse($final[$i]);
					}
				}

			fclose($file);

			return ['template' => 'uploadcourses.html.php', 
			'title' => $title, 
			'variables' => [
				'filename' => $file_name,
				'courses' => $courses,
				'errors' => $errors,
				'warnings' => $warnings,
				'term' => $term			
				]
			];

		}
	
		else {
			return ['template' => 'uploadcourses.html.php', 
			'title' => $title, 
			'variables' => [
				'terms' => $this->termTable->findAll()
				]
			];
		}
	}
}