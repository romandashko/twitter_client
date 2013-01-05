<?php
class Template {

	protected $variables = array();
	protected $_controller;
	public $_action;

	function __construct($controller,$action) {
		$this->_controller = $controller;
		$this->_action = $action;
	}


	function set($name,$value) {
		$this->variables[$name] = $value;
	}


    function render() {
		extract($this->variables);

        include (ROOT . DS . 'views' . DS . 'header.php');
        //include (ROOT . DS . 'views' . DS . 'form.php');
        include (ROOT . DS . 'views' . DS . $this->_action . '.php');

        include (ROOT . DS . 'views' . DS . 'footer.php');
    }

}
