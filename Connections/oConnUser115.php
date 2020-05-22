<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_oConnUser115 = "localhost";
$database_oConnUser115 = "dbusers";
$username_oConnUser115 = "root";
$password_oConnUser115 = "1qaz2wsx";
$oConnUser115 = mysql_pconnect($hostname_oConnUser115, $username_oConnUser115, $password_oConnUser115) or trigger_error(mysql_error(),E_USER_ERROR); 
?>