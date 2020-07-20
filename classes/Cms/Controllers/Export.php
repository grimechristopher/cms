<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Export {
	private $instructorsTable;
	private $coursesTable;
	private $departmentsTable;
	private $courseDepartmentsTable; 
	private $timeslotTable;
	private $termTable;
	private $campusTable;
	private $subjectTable;
	private $attributeTable;
	private $courseAttributeTable;
	private $authentication;

	public function __construct(DatabaseTable $coursesTable, 
								DatabaseTable $instructorsTable, 
								DatabaseTable $departmentsTable, 
								DatabaseTable $courseDepartmentsTable, 
								DatabaseTable $timeslotTable,
								DatabaseTable $termTable,
								DatabaseTable $campusTable,
								DatabaseTable $subjectTable,
								DatabaseTable $attributeTable,
								DatabaseTable $courseAttributeTable,
								Authentication $authentication) { 
    	$this->coursesTable = $coursesTable;
		$this->instructorsTable = $instructorsTable;
		$this->departmentsTable = $departmentsTable;
		$this->courseDepartmentsTable = $courseDepartmentsTable; 
		$this->timeslotTable = $timeslotTable;
		$this->termTable = $termTable;
		$this->campusTable = $campusTable;
		$this->subjectTable = $subjectTable;
		$this->attributeTable = $attributeTable;
		$this->courseAttributeTable = $courseAttributeTable;
		$this->authentication = $authentication;
	}

	public function courses() {
		//configure data
		$courses = $this->coursesTable->findAll();
		$data = array();
		$data[] = array('Select','CRN','Subj','Crse','Sec','Cmp','Cred','','Title','Days','Time','Location','Cred','Cap','Act','Rem','XL Cap','XL Act','XL Rem','Primary Instructor','Secondary Instructor','Tertiary Instructor','Date (MM/DD)');
		foreach ($courses as $course) {
			$priname = "";
			$secname = "";
			$tername = "";

			if ($course->getPrimaryInstructor() != NULL) {
				if ($course->getPrimaryInstructor()->firstname != NULL) {
					$priname .= $course->getPrimaryInstructor()->firstname . ' ';
				}
				if ($course->getPrimaryInstructor()->middlename != NULL) {
					$priname .= $course->getPrimaryInstructor()->middlename. ' ';
				}
				if ($course->getPrimaryInstructor()->lastname != NULL) {
					$priname .= $course->getPrimaryInstructor()->lastname;
				}
			}
			if ($course->getSecondaryInstructor() != NULL) {
				if ($course->getSecondaryInstructor()->firstname != NULL) {
					$secname .= $course->getSecondaryInstructor()->firstname . ' ';
				}
				if ($course->getSecondaryInstructor()->middlename != NULL) {
					$secname .= $course->getSecondaryInstructor()->middlename. ' ';
				}
				if ($course->getSecondaryInstructor()->lastname != NULL) {
					$secname .= $course->getSecondaryInstructor()->lastname;
				}
			}
			if ($course->getTertiaryInstructor() != NULL) {
				if ($course->getTertiaryInstructor()->firstname != NULL) {
					$tername .= $course->getTertiaryInstructor()->firstname . ' ';
				}
				if ($course->getTertiaryInstructor()->middlename != NULL) {
					$tername .= $course->getTertiaryInstructor()->middlename. ' ';
				}
				if ($course->getTertiaryInstructor()->lastname != NULL) {
					$tername .= $course->getTertiaryInstructor()->lastname;
				}
			}

			$days = "";
			$startime = "";
			$endtime = ""; 
			if ($course->getTimeslot() != null) {
				$days = $course->getTimeslot()->days;
				$startime = $course->getTimeslot()->timestart;
				$endtime = $course->getTimeslot()->timeend;
			}

			$d = array(
				//Select,CRN,Subj,Crse,Sec,Cmp,Cred,,Title,Days,Time,Location,Cred,
				//Cap,Act,Rem,XL Cap,XL Act,XL Rem,Primary Instructor,Secondary Instructor,Tertiary Instructor,Date (MM/DD)
				'',$course->crn,$course->getSubject()->code,$course->coursenumber,$course->section,$course->getCampus()->code,$course->credithours,'',$course->title,
				$days ,$startime . '-' .$endtime, $course->building . ' ' . $course->room,
				'',$course->capacity, $course->actual, '', $course->crosslistcapacity, $course->crosslistactual,'', 
				$priname,
				$secname,
				$tername,
				$course->getTerm()->termstart . '-' . $course->getTerm()->termend, ''
			);
			$data[] = $d;
		}
		$csv = fopen('coursesexport.csv', 'w');
		
		foreach ($data as $lines) {
			fputcsv($csv, $lines);
		}
		fclose($csv);
		//return finished page
		return ['template' => 'exportcourses.html.php', 
		'title' => 'Export Success', 
		'variables' => [
			]
		];
	}

}