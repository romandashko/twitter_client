<?php
class Model extends SQLQuery {
	protected $_model;
    protected $_action;
    protected $_table;

	function __construct($action,$table) {
        $this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $this->_model = get_class($this);
        $this->_action = $action;
		$this->_table = $table;
	}

	function __destruct() {
	}

}
