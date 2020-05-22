<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_oConnUsers = "localhost";
$database_oConnUsers = "dbusers";
$username_oConnUsers = "root";
$password_oConnUsers = "1qaz2wsx";
$oConnUsers = mysql_pconnect($hostname_oConnUsers, $username_oConnUsers, $password_oConnUsers) or trigger_error(mysql_error(),E_USER_ERROR); 
?>