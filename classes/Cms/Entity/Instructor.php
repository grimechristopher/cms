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