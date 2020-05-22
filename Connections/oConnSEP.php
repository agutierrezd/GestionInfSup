<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_oConnSEP = "localhost";
$database_oConnSEP = "dbct";
$username_oConnSEP = "root";
$password_oConnSEP = "1qaz2wsx";
$oConnSEP = mysql_pconnect($hostname_oConnSEP, $username_oConnSEP, $password_oConnSEP) or trigger_error(mysql_error(),E_USER_ERROR); 
?>