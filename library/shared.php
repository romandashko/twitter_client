<?php

function clearData($data, $type="s") {
    switch ($type) {
        case 's': $data = trim(strip_tags($data));return $data;break;
        case 'i': $data = abs((int)($data));return $data;break;
    }
}

function main() {

    global $default;

    if (isset($_GET['url'])) {
        $url = $_GET['url'];
    }else{
        $url = $default;
    }

    $urlArray = array();
	$urlArray = explode("/",$url);
	$controller = $urlArray[0];
	array_shift($urlArray);
	$action = $urlArray[0];

    $table = $controller;
	$controller = ucwords($controller);
    $model = $controller;
	$controller .= 'Controller';
    $model .= 'Model';

	$starter = new $controller($model,$controller,$action,$table);

    $queryString = array();
	if (method_exists($controller, $action)) {
		call_user_func_array(array($starter,$action),$queryString);
	} else {
         throw new Exception(sprintf('The required method "%s" does not exist for "%s"', $action, $controller));
    }
}

function __autoload($className) {
	if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
		require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
	} else if (file_exists(ROOT . DS . 'controllers' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'controllers' . DS . strtolower($className) . '.php');
	} else if (file_exists(ROOT . DS . 'models' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'models' . DS . strtolower($className) . '.php');
	} else {
        throw new Exception(sprintf('The required file "%s" does not exist"', strtolower($className).'....php'));
    }
}
    main();
?>