<?php
namespace Ninja;

class EntryPoint {
	private $route;
	private $method;
	private $routes;

	public function __construct(string $route, string $method, \Ninja\Routes $routes) {
		$this->route = $route;
		$this->routes = $routes;
		$this->method = $method;
		$this->checkUrl();
	}

	private function checkUrl() {
		if ($this->route !== strtolower($this->route)) {
			http_response_code(301);
			header('location: ' . strtolower($this->route));
		}
	}

	private function loadTemplate($templateFileName, $variables = []) {
		extract($variables);

		ob_start();
		//print($templateFileName);
		include  __DIR__ . '/../../templates/' . $templateFileName;

		return ob_get_clean();
	}

	public function run() {

		  $routes = $this->routes->getRoutes();	
               //print (' EntryPoint : 35 $this->route = ' . $this->route . '<br>');  // DEBUG
	           //print (' EntryPoint : 36 $this->method = ' . $this->method . '<br>');  // DEBUG
	      $authentication = $this->routes->getAuthentication();
	          //print (' EntryPoint : 38 LoggedIn = ' . $authentication->isLoggedIn() . '<br>');  // DEBUG
       	      //print (' EntryPoint : 39 login = ' . isset($routes[$this->route]['login']) . '<br>');  // DEBUG


		if (isset($routes[$this->route]['login']) && !$authentication->isLoggedIn()) {
			//print (' EntryPoint : 43 login = ' . 'not login'. '<br>');  // DEBUG
			header('location: /login/error');  // 5/25/18 JG DEL1L  org
	      	header('location: index.php?login/error'); // 5/25/18 JG NEW1L  

		}
		else if (isset($routes[$this->route]['permissions']) && !$this->routes->checkPermission($routes[$this->route]['permissions'])) {
			header('location: index.php?login/permissionserror'); 
		}
		else {  
			$controller = $routes[$this->route][$this->method]['controller'];
			$action = $routes[$this->route][$this->method]['action'];
			$page = $controller->$action();

			$title = $page['title'];

			if (isset($page['variables'])) {
				$output = $this->loadTemplate($page['template'], $page['variables']);
			}
			else {
				$output = $this->loadTemplate($page['template']);
			}

			echo $this->loadTemplate('layout.html.php', ['loggedIn' => $authentication->isLoggedIn(),
			                                             'output' => $output,
			                                             'title' => $title
			                                            ]);

		}

	}
}