<?php
namespace Cms\Entity;
use Ninja\DatabaseTable;

class Attribute {
	public $id;
	public $name;
	private $coursesTable;
	private $courseAttributesTable;

	public function __construct(DatabaseTable $coursesTable, DatabaseTable $courseAttributesTable) {
		$this->coursesTable = $coursesTable;
		$this->courseAttributesTable = $courseAttributesTable;
	}

	public function getCourses($limit = null, $offset = null) {
		$courseAttributes = $this->courseAttributesTable->find('attributeid', $this->id, null, $limit, $offset);
        //print ('Attribute.php: 19 id = ' .$this->id. '<br>');  //DEBUG
		//print ('Attribute.php: 20 limit = ' .$limit. '<br>');  //DEBUG
		//print ('Attribute.php: 21 offset = ' .$offset. '<br>');  //DEBUG
		
		$courses = [];

		foreach ($courseAttributes as $courseAttribute) {
			$course =  $this->coursesTable->findById($courseAttribute->courseid);
			
			if ($course) {
				$courses[] = $course;
			}			
		}

		usort($courses, [$this, 'sortCourses']);

		return $courses;
	}

	public function getNumCourses() {
		return $this->courseAttributesTable->total('attributeid', $this->id);
	}

	private function sortCourses($a, $b) {
		$aDate = new \DateTime($a->coursedate);
		$bDate = new \DateTime($b->coursedate);

		if ($aDate->getTimestamp() == $bDate->getTimestamp()) {
			return 0;
		}

		return $aDate->getTimestamp() < $bDate->getTimestamp() ? -1 : 1;
	}
}