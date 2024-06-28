<?php
namespace Cms\Entity;

class Timeslot {
	public $code;
	public $timestart;
	public $timeend;
	public $days;

	public function __construct(\Ninja\DatabaseTable $courseTable) {
		$this->coursesTable = $courseTable;
	}

	public function getCourses() {
		return $this->coursesTable->find('timeslotcode', $this->code);
	}

}

