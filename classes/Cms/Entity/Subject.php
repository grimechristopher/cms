<?php
namespace Cms\Entity;

use Ninja\DatabaseTable;

class Subject {
	public $id;
	public $code;
	public $name;
	private $subjectTable;
	private $coursesTable;
	private $subjectDepartmentTable;

	public function __construct(DatabaseTable $subjectTable, DatabaseTable $coursesTable, DatabaseTable $subjectDepartmentTable) {
		$this->subjectTable = $subjectTable;
		$this->coursesTable = $coursesTable;
		$this->subjectDepartmentTable = $subjectDepartmentTable;
	}

	public function getCourses($limit = null, $offset) {
		$courses = $this->coursesTable->find('subjectid', $this->id, null, $limit, $offset);

		usort($courses, [$this, 'sortCourses']);

		return $courses;
	}

	public function getNumCourses() {
		return $this->coursesTable->total('subjectid', $this->id);
	}

	private function sortCourses($a, $b) {
		$aDate = new \DateTime($a->dateadded);
		$bDate = new \DateTime($b->dateadded);

		if ($aDate->getTimestamp() == $bDate->getTimestamp()) {
			return 0;
		}

		return $aDate->getTimestamp() < $bDate->getTimestamp() ? -1 : 1;
	}

	public function hasDepartment($departmentid) {
		$subjectDepartments = $this->subjectDepartmentTable->find('subjectid', $this->id);

		foreach ($subjectDepartments as $subjectDepartment) {
			if ($subjectDepartment->departmentid == $departmentid) {
				return true;
			}
		}
	}
	public function addDepartment($departmentid) {
		$subjectCat = ['subjectid' => $this->id, 'departmentid' => $departmentid];

		$this->subjectDepartmentTable->save($subjectCat);
	}
	public function clearDepartments() {
		$this->subjectDepartmentTable->deleteWhere('subjectid', $this->id);
	}

}