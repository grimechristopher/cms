<?php
namespace Cms\Entity;

use Ninja\DatabaseTable;

class Department {
	public $id;
	public $name;
	private $subjectTable;
	private $subjectDepartmentsTable;

	public function __construct(DatabaseTable $subjectTable, DatabaseTable $subjectDepartmentsTable) {
		$this->subjectTable = $subjectTable;
		$this->subjectDepartmentsTable = $subjectDepartmentsTable;
	}

	public function getSubjects($limit = null, $offset = null) {
		$subjectDepartments = $this->subjectDepartmentsTable->find('departmentid', $this->id, null, $limit, $offset);
        print ('Department.php: 19 id = ' .$this->id. '<br>');  //DEBUG
		print ('Department.php: 20 limit = ' .$limit. '<br>');  //DEBUG
		print ('Department.php: 21 offset = ' .$offset. '<br>');  //DEBUG
		
		$subjects = [];

		foreach ($subjectDepartments as $subjectDepartment) {
			$subjects =  $this->subjectTable->findById($subjectDepartment->subjectid);
			
			if ($subject) {
				$subjects[] = $subject;
			}			
		}

		//usort($subjects, [$this, 'sortCourses']);

		return $subjects;
	}

	public function hasSubject($subjectid) {
		$subjectDepartments = $this->subjectDepartmentsTable->find('departmentid', $this->id);

		foreach ($subjectDepartments as $subjectDepartment) {
			if ($subjectDepartment->subjectid == $subjectid) {
				return true;
			}
		}
	}
	public function addSubject($subjectid) {
		$departmentCat = ['departmentid' => $this->id, 'subjectid' => $subjectid];

		$this->subjectDepartmentsTable->save($departmentCat);
	}
	public function clearSubjects() {
		$this->subjectDepartmentsTable->deleteWhere('departmentid', $this->id);
	}

	public function getNumCourses() {
		return $this->subjectDepartmentsTable->total('departmentid', $this->id);
	}

	private function sortCourses($a, $b) {
		$aDate = new \DateTime($a->subdate);
		$bDate = new \DateTime($b->coursedate);

		if ($aDate->getTimestamp() == $bDate->getTimestamp()) {
			return 0;
		}

		return $aDate->getTimestamp() < $bDate->getTimestamp() ? -1 : 1;
	}
}