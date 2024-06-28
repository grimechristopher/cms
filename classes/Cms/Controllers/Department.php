<?php
namespace Cms\Controllers;

class Department {
	private $departmentsTable;
	private $subjectDepartmentsTable;
	private $subjectsTable;
	private $authentication;
	
	public function __construct(\Ninja\DatabaseTable $departmentsTable, 
								\Ninja\DatabaseTable $subjectDepartmentsTable, 
								\Ninja\DatabaseTable $subjectsTable, 
								\Ninja\Authentication $authentication) {
		$this->departmentsTable = $departmentsTable;
		$this->subjectDepartmentsTable = $subjectDepartmentsTable;
		$this->subjectsTable = $subjectsTable;
		$this->authentication = $authentication;
	}

	public function list() {
		$departments = $this->departmentsTable->findAll();
		$subjects = $this->subjectsTable->findAll();
		$subjectDepartments = $this->subjectDepartmentsTable->findAll();
		$user = $this->authentication->getUser();
		$title = 'Course Departments';
		return ['template' => 'departments.html.php', 
				'title' => $title, 
				'variables' => [
					'departments' => $departments,
					'subjects' => $subjects,
					'subjectDepartments' => $subjectDepartments,
					'user' => $user
			  	]
		];
	}

	public function edit() {
		if (isset($_GET['id'])) {
			$department = $this->departmentsTable->findById($_GET['id']);
		}
		$subjects = $this->subjectsTable->findAll();
		$title = 'Edit Department';
		return ['template' => 'editdepartment.html.php',
				'title' => $title,
				'variables' => [
					'department' => $department ?? null,
					'subjects' => $subjects
				]
		];
	}

	public function saveEdit() {
		$department = $_POST['department'];

		$valid = true;
		$errors = [];

		if (empty($department['name'])){
			$valid = false;
			$errors[] = 'The department name cannot be blank';
		}

		if ($valid == true) {
			$department = $this->departmentsTable->save($department);
			$department->clearSubjects();
			foreach ($_POST['subject'] as $subjectid) {
				$department->addSubject($subjectid);
			}
			header('location: index.php?department/list');  // 6/7/18 JG NEW 1L: 
		}
		else {
			if (isset($_GET['id'])) {
				$department = $this->departmentsTable->findById($_GET['id']);
			}
			$title = 'Edit Department';
			return ['template' => 'editdepartment.html.php', 
				    'title' => $title,
				    'variables' => [
						'department' => $department,
						'errors' => $errors,
						'subjects' => $this->subjectsTable->findAll()
				    	]
					]; 
		}
	}
	
	public function delete() {
		$this->subjectDepartmentsTable->delete($_POST['id']); 
		$this->departmentsTable->delete($_POST['id']); 
		header('location: index.php?department/list'); 
	}
}