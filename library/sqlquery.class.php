<?php

class SQLQuery {
    protected $_dbHandle;
    protected $_result;

    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = @mysql_connect($address, $account, $pwd);
        if ($this->_dbHandle != 0) {
            if (@mysql_select_db($name, $this->_dbHandle)) {
                return 1;
            }
            else {
                die(mysql_error());
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    function disconnect() {
        if (@mysql_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            die(mysql_error());
            return 0;
        }
    }

    function insert($FieldValuePairs){
        $Separator = '';
        $Fields = '';
        $Values = '';
        foreach ($FieldValuePairs as $Field => $Value) {
            $Fields = $Fields.$Separator.$Field;
            if(is_string($Value)) {
                $SeparatorString = '"';
            } else {
                $SeparatorString = '';
            }
            $Values = $Values.$Separator.$SeparatorString.mysql_real_escape_string($Value).$SeparatorString;
            $Separator = ',';
        }
        $query = 'INSERT INTO '.$this->_table.' ('.$Fields.') VALUES ('.$Values.')';
        $this->query($query);
    }


    function delete($id) {
        $query = 'DELETE * FROM '.$this->_table.' WHERE `id` = \''.mysql_real_escape_string($id).'\'';
        $this->query($query);
    }

    function deleteAll() {
        $query = 'DELETE * FROM '.$this->_table;
        $this->query($query);
    }

    function selectAll() {
    	$query = 'SELECT * FROM '.$this->_table.' ORDER BY id DESC';
    	return $this->query($query);
    }
    
    function select() {
    	$query = 'SELECT msg, datetime FROM '.$this->_table.' WHERE `user_token` = "'.USER_TOKEN.'" AND `user_secret` = "'.USER_SECRET.'"  ORDER BY datetime DESC';
    	return $this->query($query, 0);
    }

    function query($query, $singleResult = 0) {

        $this->_result = mysql_query($query, $this->_dbHandle) or die(mysql_error());

        if (preg_match("/select/i", $query)) {
            $result = array();
            $table = array();
            $field = array();
            $tempResults = array();
            $numberOfFields = mysql_num_fields($this->_result);
            for ($i = 0; $i < $numberOfFields; ++$i) {
                array_push($table, mysql_field_table($this->_result, $i));
                array_push($field, mysql_field_name($this->_result, $i));
            }

            while ($row = mysql_fetch_row($this->_result)) {
                for ($i = 0; $i < $numberOfFields; ++$i) {
                    $table[$i] = trim(ucfirst($table[$i]), "s");
                    $tempResults[$table[$i]][$field[$i]] = $row[$i];
                }
                if ($singleResult == 1) {
                    mysql_free_result($this->_result);
                    return $tempResults;
                }
                array_push($result, $tempResults);
            }
            mysql_free_result($this->_result);
            return ($result);
        }
    }
}
