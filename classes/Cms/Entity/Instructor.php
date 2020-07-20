<?php
namespace Cms\Entity;

class Instructor {

	const MODIFY_COURSES = 1;
	const MODIFY_DEPARTMENTS = 2;
	const MODIFY_INSTRUCTORS = 4;
	const MODIFY_USER_ACCESS = 8;
	const MODIFY_COURSE_FIELDS = 16;
	const MODIFY_FACULTY_FIELDS = 32;
	const ACCESS_PAY_INFO = 64;
	const IMPORT_AND_EXPORT = 128;

	/*const EDIT_COURSES = 1;
	const DELETE_COURSES = 2;
	const ADD_DEPARTMENTS = 4;
	const EDIT_DEPARTMENTS = 8;
	const REMOVE_DEPARTMENTS = 16;
	const EDIT_USER_ACCESS = 32;
	const ADD_TIME_CODES = 64;
	const EDIT_TIME_CODES = 128;
	const DELETE_TIME_SLOTS = 256;
	const EDIT_CAMPUSES = 512;
	const ADD_CAMPUSES = 1024;
	const EDIT_SUBJECTS = 2048;
	const ADD_SUBJECTS = 4096;
	const ADD_ATTRIBUTES = 8192;
	const EDIT_ATTRIBUTES = 16384;
	const REMOVE_ATTRIBUTES = 32768;*/

	public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $password;
	private $coursesTable;
	private $facultyCategoryTable;
	private $facultyCategory;

	public function __construct(\Ninja\DatabaseTable $courseTable, \Ninja\DatabaseTable $facultyCategoryTable) {
		$this->coursesTable = $courseTable;
		$this->facultyCategoryTable = $facultyCategoryTable;
	}

	public function getPrimaryCourses() {
		return $this->coursesTable->find('primaryinstructor', $this->id);
	}
	public function getSecondaryCourses() {
		return $this->coursesTable->find('secondaryinstructor', $this->id);
	}
	public function getTertiaryCourses() {
		return $this->coursesTable->find('tertiaryinstructor', $this->id);
	}
	public function getFacultyCategory() {
		if (empty($this->facultyCategory)) {
			$this->facultyCategory = $this->facultyCategoryTable->findById($this->facultycategoryid);
		}
		return $this->facultyCategory;
	}

	public function addCourse($course) {
		$course['creatorid'] = $this->id;

		return $this->coursesTable->save($course);
	}

	public function hasPermission($permission) {
		return $this->permissions & $permission;  
	}
}