<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;

class Subject {
	private $subjectTable;
	private $courseTable;
	private $departmentsTable;
	private $subjectDepartmentsTable;

	public function __construct(DatabaseTable $subjectTable, DatabaseTable $courseTable, DatabaseTable $departmentsTable, DatabaseTable $subjectDepartmentsTable) {
		$this->subjectTable = $subjectTable;
		$this->courseTable = $courseTable;
		$this->departmentsTable = $departmentsTable;
		$this->subjectDepartmentsTable= $subjectDepartmentsTable;
	}

	public function list() {
		$subjects = $this->subjectTable->findAll();
		return ['template' => 'subjectlist.html.php',
				'title' => 'Subjects',
				'variables' => [
						'subjects' => $subjects
					]
				];
	}

	public function delete() {
		$subjects = $this->subjectTable->findAll();
		//$timeslots = $this->timeslotTable->findAll();
		//$terms = $this->termTable->findAll();
		$courses = $this->courseTable->findAll();

		$valid = true;
		$errors = [];

		foreach ($courses as $course) {
			if ($course->getSubject()->id == $_POST['id']) {
				$valid = false;
				$errors[] = 'This subject can not be deleted. Course: ' . $course->title . ' is using this subject.';
			}
		}

		$title = 'Subjects';

		if ($valid == true) {
			$this->subjectDepartmentsTable->deleteWhere('subjectid', $_POST['id']);
			$this->subjectTable->delete($_POST['id']);   
        	header('location: index.php?subject/list');   	
		}
		else {
			return ['template' => 'subjectlist.html.php', 
					'title' => $title,
					'variables' => [
						'subjects' => $subjects,
						'errors' => $errors
						]
			 		]; 
		}	

		$valid = true;
		$errors = [];

		foreach ($courses as $course) {
			//print ('timeslot.php: 35  timeslotcode = ' . $course->getTimeslot()->code . "<br>");

			if ($course->getSubject()->id == $_POST['id']) {
				$valid = false;
				$errors[] = 'This Subject can not be deleted. Please change any courses using subject';
			}
		}
			$title = 'Subjects';

			if ($valid == true) {
				        //$this->courseDepartmentsTable->deleteWhere('courseid', $_POST['id']); // 6/13/18 JG NEW 1L:  first DELETE all rows with $_POST['id'] related to a child table
		                                               						 // otherwise DB problem and course display problem for [1] 2 3 etc.	
				$this->subjectTable->delete($_POST['id']);   // 6/13/18 JG delete a row at the parent table
        		header('location: index.php?subject/list');   // 5/25/18 JG NEW 1L  	
			}
			else {
				return ['template' => 'subjectlist.html.php', 
				'title' => $title,
				'variables' => [
					'subjects' => $subjects,
					'errors' => $errors
					]
			   ]; 
			}		

		}

	public function saveEdit() {
		$subject = $_POST['subject'];

		$valid = true;
		$errors = [];

		if (empty($subject['code'])){
			$valid = false;
			$errors[] = 'Code can not be blank';
		}
		else if (strlen($subject['code']) > 4){
			$valid = false;
			$errors[] = 'Code can not be more than 4 characters';
		}
		
		$subject['code'] = strtoupper($subject['code']);
		
		if (empty($subject['name'])){
			$valid = false;
			$errors[] = 'Name can not be blank';
		}

		if ($valid == true) {
			$subject = $this->subjectTable->save($subject);
			$subject->clearDepartments();
			header('location: index.php?subject/list'); 
		}
		else {
			$title = 'Edit Subject';
			return ['template' => 'editsubject.html.php', 
				    'title' => $title,
				    'variables' => [
						'subject' => $subject,
						'departments' =>  $this->departmentsTable->findAll(),
						'errors' => $errors
				    	]
				   ]; 
		}
	}	

	public function edit() {
		$departments = $this->departmentsTable->findAll();

		if (isset($_GET['id'])) {
			$subject = $this->subjectTable->findById($_GET['id']);
		}

		$title = 'Edit Subject';

		return ['template' => 'editsubject.html.php',
				'title' => $title,
				'variables' => [
					'course' => $course ?? null,
					'departments' => $departments,
					'subject' => $subject ?? null
					]
				];
	}

}