<?php
try {
	include __DIR__ . '/../includes/autoload.php';
	
	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');   // JG remove leading / and extract the string till ? from e.g. /ch14_FINAL-Website/public/index.php?course/list?page=1

	
	//***********************JG  5/24/18 NEW line 8 - 42 ADAPTER to replace URL writing feature b/c .htaccess file is ignored by Apache********************	
	// print ('index.php 9: REQUEST_URI = ' . $_SERVER['REQUEST_URI'] . '<br>');  //DEBUG
	// print ('index.php: 10 ltrim route = ' . $route . '<br>');  //DEBUG
	
	//5/22/18 JG NEW4l: adapter to the code b/c of the .htaccess is ignored by apache
	if ($route == ltrim($_SERVER['REQUEST_URI'],  '/') ) {
	    $route = '';  //JG  5/21/18 NEW replaces by ''	   
	} 
	else{
	    $route = $_SERVER['QUERY_STRING']; // 5/22/18 JG NEW1l: give the query = remaining string
	}
	//print ('index.php: 19 route = ' . $route . '<br>');  // DEBUG
	if (strlen(strtok($route, '?')) <  strlen($route))  // string has a second ?
	{ 
		if (strpos($route, 'id')){ //6/7/18 JG is there id?
		   $_GET['id'] = substr ($route, strlen(strtok($route, '?')) + 4, strlen($route)); //6/7/18 JG extract id from e.g. course/edit?id=37
	       //print ('index.php: 26  id = ' . $_GET['id'] . '<br>');  //DEBUG   substr($string, $start, $length)
		  }
		if (strpos($route, 'page') && strpos($route, 'subject')) { 
		   $_GET['page'] =  substr($route, strpos($route, '=') + 1, strpos($route, '&') - strpos($route, '=') - 1 );
          // print ('index.php: 30 page = ' . $_GET['page']. '<br>');  //DEBUG
		
		   $_GET['subject'] = substr ($route, strlen(strtok($route, '&')) + 9, strlen($route)); 
		   //print ('index.php: 34 subject = ' . $_GET['subject'] . '<br>');  //DEBUG
		}
		else if (strpos($route, 'page') && strpos($route, 'attribute')) { 
			$_GET['page'] =  substr($route, strpos($route, '=') + 1, strpos($route, '&') - strpos($route, '=') - 1 );
			//print ('index.php: 30 page = ' . $_GET['page']. '<br>');  //DEBUG
		 
			$_GET['attribute'] = substr ($route, strlen(strtok($route, '&')) + 11, strlen($route)); 
			//print ('index.php: 34 subject = ' . $_GET['subject'] . '<br>');  //DEBUG
		 }
		 else if (strpos($route, 'page') && strpos($route, 'term')) {
			$_GET['page'] =  substr($route, strpos($route, '=') + 1, strpos($route, '&') - strpos($route, '=') - 1 );
			//print ('index.php: 30 page = ' . $_GET['page']. '<br>');  //DEBUG
		 
			$_GET['term'] = substr ($route, strlen(strtok($route, '&')) + 6, strlen($route)); 
			//print ('index.php: 34 subject = ' . $_GET['subject'] . '<br>');  //DEBUG
		 }

		else {
			if (strpos($route, 'department')) {
				$_GET['department'] = substr ($route, strlen(strtok($route, '?')) + 12, strlen($route)); 
				//print ('index.php: 40 department = ' . $_GET['department'] . '<br>');  //DEBUG
			}
			if (strpos($route, 'subject')) {
				$_GET['subject'] = substr ($route, strlen(strtok($route, '?')) + 9, strlen($route));
				//print ('index.php: 54 subject = ' . $_GET['subject'] . '<br>');  //DEBUG
			}
			if (strpos($route, 'attribute')) {
				$_GET['attribute'] = substr ($route, strlen(strtok($route, '?')) + 11, strlen($route));
				//print ('index.php: 54 attribute = ' . $_GET['attribute'] . '<br>');  //DEBUG
			}
			if (strpos($route, 'term')) {
				$_GET['term'] = substr ($route, strlen(strtok($route, '?')) + 6, strlen($route));
				//print ('index.php: 54 attribute = ' . $_GET['attribute'] . '<br>');  //DEBUG
			}
			if (strpos($route, 'page')){
				$_GET['page'] = substr ($route, strlen(strtok($route, '?')) + 6, strlen($route));
	       		//print ('index.php: 44 page = ' . $_GET['page']. '<br>');  //DEBUG
			}
		} // end else
	
	$route = strtok($route, '?'); //retrieve the string between ? ? - for e.g. index?course/edit?id=12
	} 
	
	// print ('index.php: 48 route = ' . $route . '<br>');  // JG test //DEBUG
    // print ('index.php: 49 REQUEST_METHOD = ' . $_SERVER['REQUEST_METHOD']. '<br>');  // JG test //DEBUG
	//****************************END OF JG  5/24/18 NEW line 8 - 42//****************************************************************************************

	$entryPoint = new \Ninja\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Cms\CmsRoutes());
	$entryPoint->run();
}
catch (PDOException $e) {
	$title = 'An error has occurred';
	$output = 'Database error: ' . $e->getMessage() . ' in ' .
	$e->getFile() . ':' . $e->getLine();
	include  __DIR__ . '/../templates/layout.html.php';
}
