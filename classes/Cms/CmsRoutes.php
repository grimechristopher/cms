<?php
namespace Cms;

class CmsRoutes implements \Ninja\Routes {
	private $instructorsTable;
	private $coursesTable;
	private $departmentsTable;
	private $subjectDepartmentsTable;
	private $timeslotTable;
	private $termTable;
	private $campusTable;
	private $facultyCategoryTable;
	private $subjectTable;
	private $attributeTable;
	private $courseAttributesTable;
	private $authentication;

	public function __construct() {
		include __DIR__ . '/../../includes/DatabaseConnection.php';

		$this->coursesTable = new \Ninja\DatabaseTable($pdo, 'course', 'id', '\Cms\Entity\Course', [&$this->instructorsTable, &$this->subjectDepartmentsTable, &$this->timeslotTable, &$this->termTable, &$this->campusTable, &$this->subjectTable, &$this->attributeTable, &$this->courseAttributesTable]);
 		$this->instructorsTable = new \Ninja\DatabaseTable($pdo, 'instructor', 'id', '\Cms\Entity\Instructor', [&$this->coursesTable, &$this->facultyCategoryTable]);
 		$this->departmentsTable = new \Ninja\DatabaseTable($pdo, 'department', 'id', '\Cms\Entity\Department', [&$this->subjectTable, &$this->subjectDepartmentsTable]);
		$this->subjectDepartmentsTable = new \Ninja\DatabaseTable($pdo, 'subject_department', 'departmentid');
		$this->timeslotTable = new \Ninja\DatabaseTable($pdo, 'timeslot', 'code', '\Cms\Entity\Timeslot', [&$this->coursesTable]);
		$this->termTable = new \Ninja\DatabaseTable($pdo, 'term', 'id', '\Cms\Entity\Term', [&$this->termTable, &$this->coursesTable]);
		$this->campusTable = new \Ninja\DatabaseTable($pdo, 'campus', 'id');
		$this->facultyCategoryTable = new \Ninja\DatabaseTable($pdo, 'facultycategory', 'id');
		$this->subjectTable = new \Ninja\DatabaseTable($pdo, 'subject', 'id', '\Cms\Entity\Subject', [&$this->subjectTable, &$this->coursesTable, &$this->subjectDepartmentsTable]);
		$this->attributeTable = new \Ninja\DatabaseTable($pdo, 'attribute', 'id', '\Cms\Entity\Attribute', [&$this->coursesTable, &$this->courseAttributesTable]);
		$this->courseAttributesTable = new \Ninja\DatabaseTable($pdo, 'course_attribute', 'attributeid');
		$this->authentication = new \Ninja\Authentication($this->instructorsTable, 'email', 'password');
	}

	public function getRoutes(): array {
		$courseController = new \Cms\Controllers\Course($this->coursesTable, $this->instructorsTable, $this->departmentsTable, $this->subjectDepartmentsTable, $this->timeslotTable, $this->termTable, $this->campusTable, $this->subjectTable, $this->attributeTable, $this->courseAttributesTable, $this->authentication); // 6/12/18 JG MOD 1L: added $courseDepartmentsTable to manipulate it e.g. delete a child table
		$instructorController = new \Cms\Controllers\Register($this->instructorsTable, $this->facultyCategoryTable, $this->coursesTable, $this->authentication);
		$loginController = new \Cms\Controllers\Login($this->authentication);
        $departmentController = new \Cms\Controllers\Department($this->departmentsTable, $this->subjectDepartmentsTable, $this->subjectTable, $this->authentication);  // 6/12/18 JG NEW 1L 2 arguments for deletion the child table
		$timeslotController = new \Cms\Controllers\Timeslot($this->timeslotTable, $this->termTable, $this->coursesTable);
		$termController = new \Cms\Controllers\Term($this->termTable, $this->coursesTable);
		$campusController = new \Cms\Controllers\Campus($this->campusTable, $this->coursesTable);
		$facultyCategoryController = new \Cms\Controllers\FacultyCategory($this->facultyCategoryTable, $this->instructorsTable);
		$subjectController = new \Cms\Controllers\Subject($this->subjectTable, $this->coursesTable, $this->departmentsTable, $this->subjectDepartmentsTable);
		$attributeController = new \Cms\Controllers\Attribute($this->attributeTable, $this->courseAttributesTable);
		$importController = new \Cms\Controllers\Import($this->coursesTable, $this->instructorsTable, $this->departmentsTable, $this->subjectDepartmentsTable, $this->timeslotTable, $this->termTable, $this->campusTable, $this->subjectTable, $this->attributeTable, $this->courseAttributesTable, $this->authentication);
		$exportController = new \Cms\Controllers\Export($this->coursesTable, $this->instructorsTable, $this->departmentsTable, $this->subjectDepartmentsTable, $this->timeslotTable, $this->termTable, $this->campusTable, $this->subjectTable, $this->attributeTable, $this->courseAttributesTable, $this->authentication);

		$routes = [
			'instructor/register' => [
				'GET' => [
					'controller' => $instructorController,
					'action' => 'registrationForm'
				],
				'POST' => [
					'controller' => $instructorController,
					'action' => 'registerUser'
				]
			],
			'instructor/success' => [
				'GET' => [
					'controller' => $instructorController,
					'action' => 'success'
				]
			],
			'instructor/permissions' => [
				'GET' => [
					'controller' => $instructorController,
					'action' => 'permissions'
				],
				'POST' => [
					'controller' => $instructorController,
					'action' => 'savePermissions'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_INSTRUCTORS
			],
			'instructor/list' => [
				'GET' => [
					'controller' => $instructorController,
					'action' => 'list'
				]
			],
			'instructor/profile' => [
				'GET' => [
					'controller' => $instructorController,
					'action' => 'profile'
				]
			],
			'instructor/delete' => [
				'POST' => [
					'controller' => $instructorController,
					'action' => 'delete'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_DEPARTMENTS
			],
			'course/edit' => [
				'POST' => [
					'controller' => $courseController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $courseController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSES
			],
			'course/delete' => [
				'POST' => [
					'controller' => $courseController,
					'action' => 'delete'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSES
			],
			'course/list' => [
				'GET' => [
					'controller' => $courseController,
					'action' => 'list'
				]
			],
			'course/profile' => [
				'GET' => [
					'controller' => $courseController,
					'action' => 'yourCourses'
				]
			],
			'login/error' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'error'
				]
			],
			'login/permissionserror' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'permissionsError'
				]
			],
			'login/success' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'success'
				]
			],
			'logout' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'logout'
				]
			],
			'login' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'loginForm'
				],
				'POST' => [
					'controller' => $loginController,
					'action' => 'processLogin'
				]
			],
			'department/edit' => [
				'POST' => [
					'controller' => $departmentController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $departmentController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_DEPARTMENTS
			],
			'department/delete' => [
				'POST' => [
					'controller' => $departmentController,
					'action' => 'delete'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_DEPARTMENTS
			],
			'department/list' => [
				'GET' => [
					'controller' => $departmentController,
					'action' => 'list'
				]
			],
			'timeslot/list' => [
				'GET' => [
					'controller' => $timeslotController,
					'action' => 'list'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'timeslot/edit' => [
				'POST' => [
					'controller' => $timeslotController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $timeslotController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'timeslot/delete' => [
				'POST' => [
					'controller' => $timeslotController,
					'action' => 'deleteTimeslot'
				],
				'login' => true
			],
			'campus/list' => [
				'GET' => [
					'controller' => $campusController,
					'action' => 'list'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'campus/edit' => [
				'POST' => [
					'controller' => $campusController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $campusController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'campus/delete' => [
				'POST' => [
					'controller' => $campusController,
					'action' => 'delete'
				],
				'login' => true
			],
			'facultycategory/list' => [
				'GET' => [
					'controller' => $facultyCategoryController,
					'action' => 'list'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_FACULTY_FIELDS
			],
			'facultycategory/edit' => [
				'POST' => [
					'controller' => $facultyCategoryController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $facultyCategoryController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_FACULTY_FIELDS
			],
			'facultycategory/delete' => [
				'POST' => [
					'controller' => $facultyCategoryController,
					'action' => 'delete'
				],
				'login' => true
			],
			'term/list' => [
				'GET' => [
					'controller' => $termController,
					'action' => 'list'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'term/edit' => [
				'POST' => [
					'controller' => $termController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $termController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'term/delete' => [
				'POST' => [
					'controller' => $termController,
					'action' => 'delete'
				],
				'login' => true
			],
			'subject/list' => [
				'GET' => [
					'controller' => $subjectController,
					'action' => 'list'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'subject/edit' => [
				'POST' => [
					'controller' => $subjectController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $subjectController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'subject/delete' => [
				'POST' => [
					'controller' => $subjectController,
					'action' => 'delete'
				],
				'login' => true
			],
			'attribute/edit' => [
				'POST' => [
					'controller' => $attributeController,
					'action' => 'saveEdit'
				],
				'GET' => [
					'controller' => $attributeController,
					'action' => 'edit'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'attribute/delete' => [
				'POST' => [
					'controller' => $attributeController,
					'action' => 'delete'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'attribute/list' => [
				'GET' => [
					'controller' => $attributeController,
					'action' => 'list'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::MODIFY_COURSE_FIELDS
			],
			'import/view' => [
				'GET' => [
					'controller' => $importController,
					'action' => 'view'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::IMPORT_AND_EXPORT
			],
			'import/upload' => [
				'POST' => [
					'controller' => $importController,
					'action' => 'upload'
				],
				'GET' => [
					'controller' => $importController,
					'action' => 'upload'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::IMPORT_AND_EXPORT
			],
			'import/confirm' => [
				'GET' => [
					'controller' => $importController,
					'action' => 'confirm'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::IMPORT_AND_EXPORT
			],
			'import/results' => [
				'GET' => [
					'controller' => $importController,
					'action' => 'results'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::IMPORT_AND_EXPORT
			],
			'export/courses' => [
				'GET' => [
					'controller' => $exportController,
					'action' => 'courses'
				],
				'login' => true,
				'permissions' => \Cms\Entity\Instructor::IMPORT_AND_EXPORT
			],
			'' => [
				'GET' => [
					'controller' => $courseController,
					'action' => 'home'
				]
			]
		];

		return $routes;
	}

	public function getAuthentication(): \Ninja\Authentication {   
		return $this->authentication;
	}

	public function checkPermission($permission): bool {  // p.591
		$user = $this->authentication->getUser();

		if ($user && $user->hasPermission($permission)) {
			return true;
		} else {
			return false;
		}
	}

}