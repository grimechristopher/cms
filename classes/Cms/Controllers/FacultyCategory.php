<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;

class FacultyCategory {
	private $facultyCategoryTable;

	public function __construct(DatabaseTable $facultyCategoryTable, 
								DatabaseTable $instructorTable) {
		$this->facultyCategoryTable = $facultyCategoryTable;
		$this->instructorTable = $instructorTable;
	}

	public function list() {
		$facultyCategories = $this->facultyCategoryTable->findAll();
		return ['template' => 'facultycategorylist.html.php',
				'title' => 'Faculty Categories',
				'variables' => [
					'facultycategories' => $facultyCategories
					]
				];
	}

	public function delete() {
		$facultyCategories = $this->facultyCategoryTable->findAll();
		$instructors = $this->instructorTable->findAll();

		$valid = true;
		$errors = [];

		foreach ($instructor as $instructor) {
			if ($instructor->getFacultyCategory()->id == $_POST['id']) {
				$valid = false;
				$errors[] = 'This faculty category can not be deleted. Please change any instructors that are assigned this code';
			}
		}

		$title = 'Faculty Categories';

		if ($valid == true) {
			$this->facultyCategoryTable->delete($_POST['id']); 
        	header('location: index.php?facultycategory/list');  	
		}
		else {
			return ['template' => 'facultycategorylist.html.php', 
					'title' => $title,
					'variables' => [
						'facultycategories' => $facultyCategories,
						'errors' => $errors
						]
			   		]; 
		}		
	}

	public function saveEdit() {
		$facultyCategory = $_POST['facultycategory'];

		$valid = true;
		$errors = [];

		
		if (empty($facultyCategory['name'])){
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}
		if (!is_numeric($facultyCategory['payrate'])){
			$valid = false;
			$errors[] = 'Pay rate needs to be a number';
		}

		if ($valid == true) {
			$facultyCategory = $this->facultyCategoryTable->save($facultyCategory);
			header('location: index.php?facultycategory/list');
		}
		else {
			$title = 'Edit Faculty Category';
			return ['template' => 'editfacultycategory.html.php', 
				    'title' => $title,
				    'variables' => [
						'facultycategory' => $facultyCategory,
						'errors' => $errors
				    	]
					]; 
		}
	}	

	public function edit() {
		if (isset($_GET['id'])) {
			$facultyCategory = $this->facultyCategoryTable->findById($_GET['id']);
		}

		$title = 'Edit Faculty Category';

		return ['template' => 'editfacultycategory.html.php',
				'title' => $title,
				'variables' => [
					'facultycategory' => $facultyCategory ?? null,
					'instructor' => $instructor ?? null
					]
				];
	}		

}