<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;

class Register {
	private $instructorsTable;
	private $authentication;
	private $facultyCategoryTable;
	private $courseTable;

	public function __construct(DatabaseTable $instructorsTable, DatabaseTable $facultyCategoryTable, DatabaseTable $courseTable, \Ninja\Authentication $authentication) {
		$this->instructorsTable = $instructorsTable;
		$this->facultyCategoryTable = $facultyCategoryTable;
		$this->courseTable = $courseTable;
		$this->authentication = $authentication;
	}

	public function registrationForm() {
		return ['template' => 'register.html.php', 
				'title' => 'Register an account'];
	}


	public function success() {
		return ['template' => 'registersuccess.html.php', 
			    'title' => 'Registration Successful'];
	}

	public function registerUser() {
		$instructor = $_POST['instructor'];

		//Assume the data is valid to begin with
		$valid = true;
		$errors = [];

		//But if any of the fields have been left blank, set $valid to false
		if (empty($instructor['firstname'])) {
			$valid = false;
			$errors[] = 'First name cannot be blank';
		}

		if (empty($instructor['lastname'])) {
			$valid = false;
			$errors[] = 'Last name cannot be blank';
		}

		if (empty($instructor['email'])) {
			$valid = false;
			$errors[] = 'Email cannot be blank';
		}
		else if (filter_var($instructor['email'], FILTER_VALIDATE_EMAIL) == false) {
			$valid = false;
			$errors[] = 'Invalid email address';
		}
		else { //if the email is not blank and valid:
			//convert the email to lowercase
			$instructor['email'] = strtolower($instructor['email']);

			//search for the lowercase version of `$instructor['email']`
			if (count($this->instructorsTable->find('email', $instructor['email'])) > 0) {
				$valid = false;
				$errors[] = 'That email address is already registered';
			}
		}


		if (empty($instructor['password'])) {
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}

		//If $valid is still true, no fields were blank and the data can be added
		if ($valid == true) {
			//Hash the password before saving it in the database
			$instructor['password'] = password_hash($instructor['password'], PASSWORD_DEFAULT);

			//When submitted, the $instructor variable now contains a lowercase value for email
			//and a hashed password
			$this->instructorsTable->save($instructor);

			//header('Location: /instructor/success'); 5/25/18 JG DEL1L  org
            header('Location: index.php?instructor/success'); //5/25/18 JG NEW1L  

		}
		else {
			//If the data is not valid, show the form again
			return ['template' => 'register.html.php', 
				    'title' => 'Register an account',
				    'variables' => [
				    	'errors' => $errors,
				    	'instructor' => $instructor
				    ]
				   ]; 
		}
	}

	public function updatePass() {

	}

	public function savePass() {
		$user = $this->authentication->getUser();
		$instructor = $_POST['instructor'];
		$errors = [];

		if (empty($instructor['new-password'])) {
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}

		//If $valid is still true, no fields were blank and the data can be added
		if ($valid == true) {
			//Hash the password before saving it in the database
			$instructor['new-password'] = password_hash($instructor['password'], PASSWORD_DEFAULT);

			//When submitted, the $instructor variable now contains a lowercase value for email
			//and a hashed password
			$this->instructorsTable->save($instructor);

			//header('Location: /instructor/success'); 5/25/18 JG DEL1L  org
            header('Location: index.php?instructor/success'); //5/25/18 JG NEW1L  

		}
		else {
			return ['template' => 'updatepassword.html.php', 
			'title' => 'Change Password',
			'variables' => [
				'errors' => $errors,
			]
		   ]; 
		}
	}

	public function list() {
		$instructors = $this->instructorsTable->findAll();
		$user = $this->authentication->getUser();

		return ['template' => 'instructorlist.html.php',
				'title' => 'Instructor List',
				'variables' => [
						'instructors' => $instructors,
						'user' => $user,
					]
				];
	}

	public function delete() {
		$instructors = $this->instructorsTable->findAll();
		$courses = $this->courseTable->findAll();
		$user = $this->authentication->getUser();
		$instructor = $this->instructorsTable->findById($_POST['id']);

		$valid = true;
		$errors = NULL;
		$errors = [];

			if ( $instructor->getPrimaryCourses() != null ||  $instructor->getSecondaryCourses() != null || $instructor->getTertiaryCourses() != null) {
				$valid = false;
				$errors[] = 'This instructor can not be deleted. There are courses that belong to this instructor.';
			}

		$title = 'Instructors';

		if ($valid == true) {
			$this->instructorsTable->delete($_POST['id']);   
        	header('location: index.php?instructor/list');   	
		}
		else {
			return ['template' => 'instructorlist.html.php', 
					'title' => $title,
					'variables' => [
						'instructors' => $instructors,
						'errors' => $errors,
						'user' => $user
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

	public function profile() {
		$instructor = $this->instructorsTable->findById($_GET['id']);
		$primarycourses = $instructor->getPrimaryCourses();
		$secondarycourses = $instructor->getSecondaryCourses();
		$tertiarycourses = $instructor->getTertiaryCourses();
		$user = $this->authentication->getUser();

		return ['template' => 'profileinstructor.html.php',
				'title' => 'Instructor Page',
				'variables' => [
						'instructor' => $instructor ?? null,
						'primarycourses' => $primarycourses,
						'secondarycourses' => $secondarycourses,
						'tertiarycourses' => $tertiarycourses,
						'user' => $user
					]
				];	
	}

	public function permissions() {
		$user = $this->authentication->getUser();
		if (isset($_GET['id'])) {
			$instructor = $this->instructorsTable->findById($_GET['id']);
		}
		$reflected = new \ReflectionClass('\Cms\Entity\Instructor');
		$constants = $reflected->getConstants();
		$facultycategories = $this->facultyCategoryTable->findAll();

		return ['template' => 'permissions.html.php',
				'title' => 'Edit Permissions',
				'variables' => [
						'instructor' => $instructor ?? null,
						'permissions' => $constants,
						'facultycategories' => $facultycategories,
						'user' => $user
					]
				];	
	}

	public function savePermissions() {
		$instructor = $_POST['instructor'];
		$instructor['permissions'] = array_sum($_POST['permissions'] ?? []);
		$user = $this->authentication->getUser();

		$valid = true;
		$errors = [];

		if (empty($instructor['firstname'])){
			$valid = false;
			$errors[] = 'First name cannot be blank';
		}
		if (empty($instructor['lastname'])){
			$valid = false;
			$errors[] = 'Last name cannot be blank';
		}
		if (empty($instructor['email'])){
			$valid = false;
			$errors[] = 'Email cannot be blank';
		}

		if ($instructor["facultycategoryid"] == "NULL"){
			$instructor["facultycategoryid"] = null;
		}

		if ($valid == true) {
			if (($user == $instructor) && (!empty($instructor['password']))) {
				$instructor['password'] = password_hash($instructor['password'], PASSWORD_DEFAULT);
			}
			else {
				//$instructor['password'] = $instructor->password;
				print("Hello");
			}
			$this->instructorsTable->save($instructor);
			header('location: index.php?instructor/list');
		}

		else {
			$title = 'Edit Instructor';
			$reflected = new \ReflectionClass('\Cms\Entity\Instructor');
			$constants = $reflected->getConstants();
			if (isset($_GET['id'])) {
				$instructor = $this->instructorsTable->findById($_GET['id']);
			}

			$facultycategories = $this->facultyCategoryTable->findAll();

			return ['template' => 'permissions.html.php', 
				    'title' => $title,
				    'variables' => [
						'instructor' => $instructor,
						'errors' => $errors,
						'permissions' => $constants,
						'facultycategories' => $facultycategories,
						'user' => $user
				    	]
				   ]; 
		}
	}
}