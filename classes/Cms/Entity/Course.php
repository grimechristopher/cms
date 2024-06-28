<?php
namespace Cms\Entity;

class Course {
	public $id;
	public $instructorId;
	public $coursedate;
	public $coursesubject;
	public $coursenumber;
	public $courseunits;
	public $days;
	public $start;
	public $end;

	private $instructorsTable;
	private $instructor;
	private $pinstructor;
	private $sinstructor;
	private $tinstructor;
	private $timeslot;
	private $timeslotTable;
	private $term;
	private $termTable;
	private $campus;
	private $campusTable;
	private $subjectTable;
	private $attributeTable;
	private $courseDepartmentsTable;
	private $courseAttributesTable;

	public function __construct(\Ninja\DatabaseTable $instructorsTable, 
								\Ninja\DatabaseTable $courseDepartmentsTable, 
								\Ninja\DatabaseTable $timeslotTable, 
								\Ninja\DatabaseTable $termTable,
								\Ninja\DatabaseTable $campusTable,
								\Ninja\DatabaseTable $subjectTable,
								\Ninja\DatabaseTable $attributeTable,
								\Ninja\DatabaseTable $courseAttributesTable) {
		$this->instructorsTable = $instructorsTable;
		$this->courseDepartmentsTable = $courseDepartmentsTable;
		$this->timeslotTable = $timeslotTable;
		$this->termTable = $termTable;
		$this->campusTable = $campusTable;
		$this->subjectTable = $subjectTable;
		$this->attributeTable = $attributeTable;
		$this->courseAttributesTable = $courseAttributesTable;
	}

	public function getCreator() {
		if (empty($this->instructor)) {
			$this->instructor = $this->instructorsTable->findById($this->creatorid);
		}
		
		return $this->instructor;
	}
	public function getPrimaryInstructor() {
		if (empty($this->pinstructor)) {
			$this->pinstructor = $this->instructorsTable->findById($this->primaryinstructor);
		}
		
		return $this->pinstructor;
	}
	public function getSecondaryInstructor() {
		if (empty($this->sinstructor)) {
			$this->sinstructor = $this->instructorsTable->findById($this->secondaryinstructor);
		}
		
		return $this->sinstructor;
	}
	public function getTertiaryInstructor() {
		if (empty($this->tinstructor)) {
			$this->tinstructor = $this->instructorsTable->findById($this->tertiaryinstructor);
		}
		
		return $this->tinstructor;
	}

	public function getTimeslot() {
		if (empty($this->timeslot)) {
			$this->timeslot = $this->timeslotTable->findById($this->timeslotcode);
		}
		
		return $this->timeslot;
	}

	public function getTerm() {
		if (empty($this->term)) {
			$this->term = $this->termTable->findById($this->termid);
		}
		
		return $this->term;
	}

	public function getSubject() {
		if (empty($this->subject)) {
			$this->subject = $this->subjectTable->findById($this->subjectid);
		}
		
		return $this->subject;
	}

	public function getCampus() {
		if (empty($this->campus)) {
			$this->campus = $this->campusTable->findById($this->campusid);
		}
		
		return $this->campus;
	}

	public function addDepartment($departmentid) {
		$courseCat = ['courseid' => $this->id, 'departmentid' => $departmentid];

		$this->courseDepartmentsTable->save($courseCat);
	}

	public function hasDepartment($departmentid) {
		$courseDepartments = $this->courseDepartmentsTable->find('courseid', $this->id);

		foreach ($courseDepartments as $courseDepartment) {
			if ($courseDepartment->departmentid == $departmentid) {
				return true;
			}
		}
	}
	
	public function addAttribute($attributeid) {
		$courseCat = ['courseid' => $this->id, 'attributeid' => $attributeid];

		$this->courseAttributesTable->save($courseCat);
	}

	public function hasAttribute($attributeid) {
		$courseAttributes = $this->courseAttributesTable->find('courseid', $this->id);

		foreach ($courseAttributes as $courseAttribute) {
			if ($courseAttribute->attributeid == $attributeid) {
				return true;
			}
		}
	}

	public function clearDepartments() {
		$this->courseDepartmentsTable->deleteWhere('courseid', $this->id);
	}
		
}