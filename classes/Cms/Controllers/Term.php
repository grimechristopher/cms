<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;

class Term {
	private $termTable;
	private $courseTable;

	public function __construct( DatabaseTable $termTable, DatabaseTable $courseTable) {
		$this->termTable = $termTable;
		$this->courseTable = $courseTable;
	}

	public function list() {
		$terms = $this->termTable->findAll();
		return ['template' => 'termlist.html.php',
				'title' => 'Terms',
				'variables' => [
						'terms' => $terms
					]
				];
	}

	public function delete() {
		$terms = $this->termTable->findAll();
		$courses = $this->courseTable->findAll();

		$valid = true;
		$errors = [];

		foreach ($courses as $course) {
			if ($course->getTerm()->id == $_POST['id']) {
				$valid = false;
				$errors[] = 'This Term can not be deleted. Course: ' . $course->id . ' is using this term.';
			}
		}
		$title = 'Terms';
		if ($valid == true) {	
			$this->termTable->delete($_POST['id']);  
        	header('location: index.php?term/list');  	
		}
		else {
			return ['template' => 'termlist.html.php', 
					'title' => $title,
					'variables' => [
						'errors' => $errors,
						'terms' => $terms
						]
			   		]; 
		}		
	}

	public function saveEdit() {
		$term = $_POST['term'];

		$valid = true;
		$errors = [];

		if (empty($term['termname'])){
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}

		if (empty($term['termstart'])){
			$valid = false;
			$errors[] = 'Start date cannot be blank';
		}
		else if  (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$term['termstart'])) {
			$valid = false;
			$errors[] = 'Start date is not in the correct format (yyyy-mm-dd)';
		}

		if (empty($term['termend'])){
			$valid = false;
			$errors[] = 'End date cannot be blank';
		}
		else if  (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $term['termend'])) {
			$valid = false;
			$errors[] = 'End date is not in the correct format (yyyy-mm-dd)';
		}

		if ($term['termstart'] > $term['termend']){
			$valid = false;
			$errors[] = 'Start date must be before the end date';
		}
		
		if ($valid == true) {
			$this->termTable->save($term);
			header('location: index.php?term/list');   
		}
		else {
			$title = 'Edit Term';
			return ['template' => 'editterms.html.php', 
				    'title' => $title,
				    'variables' => [
						'term' => $term,
						'errors' => $errors,
				    	]
				   ]; 
		}
	}	

	public function edit() {
		if (isset($_GET['id'])) {
			$term = $this->termTable->findById($_GET['id']);
		}
	
		$title = 'Edit Term';
	
		return ['template' => 'editterms.html.php',
				'title' => $title,
				'variables' => [
						'course' => $course ?? null,
						'term' => $term ?? null
						]
				];
	}

}