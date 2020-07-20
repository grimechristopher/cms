<?php
namespace Cms\Entity;

use Ninja\DatabaseTable;

class Term {
	public $id;
	public $termname;
	public $termstart;
	public $termend;
	private $termTable;
	private $coursesTable;

	public function __construct(DatabaseTable $termTable, DatabaseTable $coursesTable) {
		$this->termTable = $termTable;
		$this->coursesTable = $coursesTable;
	}

	public function getCourses($limit = null, $offset) {
		$courses = $this->coursesTable->find('termid', $this->id, null, $limit, $offset);
        //print ('Department.php: 19 id = ' .$this->id. '<br>');  //DEBUG
		//print ('Department.php: 20 limit = ' .$limit. '<br>');  //DEBUG
		//print ('Department.php: 21 offset = ' .$offset. '<br>');  //DEBUG

		usort($courses, [$this, 'sortCourses']);

		return $courses;
	}

	public function getNumCourses() {
		return $this->coursesTable->total('termid', $this->id);
	}

	private function sortCourses($a, $b) {
		$aDate = new \DateTime($a->coursedate);
		$bDate = new \DateTime($b->coursedate);

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