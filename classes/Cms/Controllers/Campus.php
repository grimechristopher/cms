<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;

class Campus {
	private $campusTable;
	private $courseTable;

	public function __construct(\Ninja\DatabaseTable $campusTable, 
								\Ninja\DatabaseTable $courseTable) {
		$this->campusTable = $campusTable;
		$this->courseTable = $courseTable;
	}

	public function list() {
		$campuses = $this->campusTable->findAll();
		return ['template' => 'campuslist.html.php',
				'title' => 'Campuses',
				'variables' => [
						'campuses' => $campuses
					]
				];
	}

	public function edit() {
		if (isset($_GET['id'])) {
			$campus = $this->campusTable->findById($_GET['id']);
		}

		$title = 'Edit Campus';

		return ['template' => 'editcampuses.html.php',
				'title' => $title,
				'variables' => [
					'course' => $course ?? null,
					'campus' => $campus ?? null
					]
				];
	}		

	public function saveEdit() {
		$campus = $_POST['campus'];

		$valid = true;
		$errors = [];

		if (empty($campus['name'])){
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}
		if ($valid == true) {
			$campus = $this->campusTable->save($campus);
			header('location: index.php?campus/list'); //5/25/18 JG NEW 1L  
		}
		else {
			$title = 'Edit Campus';
			return ['template' => 'editcampuses.html.php', 
				    'title' => $title,
				    'variables' => [
						'campus' => $campus,
						'errors' => $errors,
				    	]
				   ]; 
		}
	}	

	public function delete() {
		$campuses = $this->campusTable->findAll();
		$courses = $this->courseTable->findAll();

		$valid = true;
		$errors = [];

		foreach ($courses as $course) {
			if ($course->getCampus()->id == $_POST['id']) {
				$valid = false;
				$errors[] = 'This campus can not be deleted. Please change any courses using this campus';
			}
		}
		$title = 'Campuses';

		if ($valid == true) {
			$this->campusTable->delete($_POST['id']);
        	header('location: index.php?campus/list');
		}
		else {
			return ['template' => 'campuslist.html.php', 
					'title' => $title,
					'variables' => [
						'campuses' => $campuses,
						'errors' => $errors
					]
			]; 
		}		
	}

}