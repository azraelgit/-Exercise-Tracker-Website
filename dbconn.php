<?php
// 22079916, Charles Buenaventura, 13:00 Thursday
$dbConn = new mysqli('localhost', 'twa258', 'twa258Xt', 'Fitness258');
if ($dbConn->connect_error) {
	die('Connection error (' . $dbConn->connect_errno . ')'
	. $dbConn->connect_error);
}
?>