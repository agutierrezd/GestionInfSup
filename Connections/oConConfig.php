 <?php
session_start();
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_oConConfig = "localhost";
$database_oConConfig = "dbct";
$username_oConConfig = "root";
$password_oConConfig = "1qaz2wsx";
$oConConfig = mysql_pconnect($hostname_oConConfig, $username_oConConfig, $password_oConConfig) or trigger_error(mysql_error(),E_USER_ERROR); 
?>