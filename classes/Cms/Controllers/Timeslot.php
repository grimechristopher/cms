<?php
namespace Cms\Controllers;
use \Ninja\DatabaseTable;

class Timeslot {
	private $timeslotTable;
	private $termTable;
	private $courseTable;

	public function __construct(DatabaseTable $timeslotTable, DatabaseTable $termTable, DatabaseTable $courseTable) {
		$this->timeslotTable = $timeslotTable;
		$this->termTable = $termTable;
		$this->courseTable = $courseTable;
	}

	public function list() {
		$timeslots = $this->timeslotTable->findAll();
		$terms = $this->termTable->findAll();
		return ['template' => 'timeslotlist.html.php',
				'title' => 'Timeslot and Terms',
				'variables' => [
						'timeslots' => $timeslots,
						'terms' => $terms
					]
				];
	}

	public function deleteTimeslot() {
		$timeslots = $this->timeslotTable->findAll();
		$courses = $this->courseTable->findAll();

		$valid = true;
		$errors = [];

		foreach ($courses as $course) {
			if ($course->getTimeslot()->code == $_POST['code']) {
				$valid = false;
				$errors[] = 'This Time Slot can not be deleted. Please change any courses using this Time Slot';
			}
		}
			$title = 'Time Slots and Terms';

			if ($valid == true) {
				$this->timeslotTable->delete($_POST['code']);   
        		header('location: index.php?timeslot/list');	
			}
			else {
				return ['template' => 'timeslotlist.html.php', 
				'title' => $title,
				'variables' => [
					'timeslots' => $timeslots,
					'errors' => $errors
					]
			   ]; 
			}		
	}

	public function saveEdit() {
		$timeslot = $_POST['timeslot'];

		$valid = true;
		$errors = [];

		if (empty($timeslot['days'])){
			$valid = false;
			$errors[] = 'Days cannot be blank';
		}

		if (empty($timeslot['timestart'])){
			$valid = false;
			$errors[] = 'Start Time cannot be blank';
		}
		else if (!preg_match('/\\d{2}\\:\\d{2}/', $timeslot['timestart'])){
			$valid = false;
			$errors[] = 'Start Time is not in the correct format (HH:MM)';
		}
		else if ($timeslot['timestart'] < 0 || $timeslot['timestart'] >= 24) {
			$valid = false;
			$errors[] = 'Start Time is not a valid time';
		}

		if (empty($timeslot['timeend'])){
			$valid = false;
			$errors[] = 'End Time cannot be blank';
		}
		else if (!preg_match('/\\d{2}\\:\\d{2}/', $timeslot['timeend'])){
			$valid = false;
			$errors[] = 'End Time is not in the correct format (HH:MM)';
		}
		else if ($timeslot['timeend'] < 0 || $timeslot['timeend'] >= 24) {
			$valid = false;
			$errors[] = 'End Time is not a valid time';
		}

		if ($timeslot['timestart'] >= $timeslot['timeend']){
			$valid = false;
			$errors[] = 'Start time must be before the end time';
		}

		if ($valid == true) {
			$this->timeslotTable->save($timeslot);

			header('location: index.php?timeslot/list'); 
		}
		else {
			$title = 'Edit Time Slot';
			return ['template' => 'edittimeslots.html.php', 
				    'title' => $title,
				    'variables' => [
						'timeslot' => $timeslot,
						'errors' => $errors,
				    	]
				   ]; 
		}
	}	

	public function edit() {
		if (isset($_GET['id'])) {
			$timeslot = $this->timeslotTable->findById($_GET['id']);
		}

		$title = 'Edit Time Slot';

		return ['template' => 'edittimeslots.html.php',
				'title' => $title,
				'variables' => [
					'course' => $course ?? null,
					'timeslot' => $timeslot ?? null
					]
				];
	}
	
}