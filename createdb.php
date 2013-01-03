<?php
// �������� ��������� ���� ������ �������� �����

define("DB_HOST", "localhost");
define("DB_LOGIN", "root");
define("DB_PASSWORD", "22");

mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD) or die(mysql_error());

$sql = 'CREATE DATABASE twitter_client';
mysql_query($sql) or die(mysql_error());

mysql_select_db('twitter_client') or die(mysql_error());

$sql = "
CREATE TABLE tweets (
	id int(11) NOT NULL auto_increment,
	msg TEXT,
	datetime int(11) NOT NULL default 0,
	PRIMARY KEY (id)
)";
mysql_query($sql) or die(mysql_error());

mysql_close();

print '<p>Структура базы данных успешно создана!</p>';
?>