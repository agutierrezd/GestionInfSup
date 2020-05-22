<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_oConnContratos = "localhost";
$database_oConnContratos = "dbct";
$username_oConnContratos = "root";
$password_oConnContratos = "1qaz2wsx";
$oConnContratos = mysql_pconnect($hostname_oConnContratos, $username_oConnContratos, $password_oConnContratos) or trigger_error(mysql_error(),E_USER_ERROR);
?>