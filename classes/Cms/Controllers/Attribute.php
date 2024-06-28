<?php
namespace Cms\Controllers;

class Attribute {
	private $attributesTable;
    private $courseAttributessTable;
	
	public function __construct(\Ninja\DatabaseTable $attributesTable, 
								\Ninja\DatabaseTable $courseAttributesTable) {
		$this->attributesTable = $attributesTable;
		$this->courseAttributesTable = $courseAttributesTable;
	}

	public function list() {
		$attributes = $this->attributesTable->findAll();
		$title = 'Course Attributes';
		return ['template' => 'attributes.html.php', 
			'title' => $title, 
			'variables' => [
				'attributes' => $attributes
				]
		];
	}

	public function edit() {
		if (isset($_GET['id'])) {
			$attribute = $this->attributesTable->findById($_GET['id']);
		}
		$title = 'Edit Attribute';
		return ['template' => 'editattribute.html.php',
				'title' => $title,
				'variables' => [
					'attribute' => $attribute ?? null
				]
		];
	}

	public function saveEdit() {
		$attribute = $_POST['attribute'];

		$valid = true;
		$errors = [];

		if (empty($attribute['name'])){
			$valid = false;
			$errors[] = 'Name can not be blank';
		}
		if (empty($attribute['description'])){
			$valid = false;
			$errors[] = 'Description can not be blank';
		}

		if ($valid == true) {
			$attribute = $this->attributesTable->save($attribute);
			header('location: index.php?attribute/list');
		}
		else {
			$title = "Edit Attribute";
			return ['template' => 'editattribute.html.php',
			'title' => $title,
			'variables' => [
				'attribute' => $attribute ?? null,
				'errors' => $errors
			]
	];
		}

	}

	public function delete() {
		$this->courseAttributesTable->delete($_POST['id']);
		$this->attributesTable->delete($_POST['id']);
		header('location: index.php?attribute/list'); 
	}
}