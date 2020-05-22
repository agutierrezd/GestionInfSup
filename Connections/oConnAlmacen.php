<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_oConnAlmacen = "localhost";
$database_oConnAlmacen = "dbrf";
$username_oConnAlmacen = "root";
$password_oConnAlmacen = "1qaz2wsx";
$oConnAlmacen = mysql_pconnect($hostname_oConnAlmacen, $username_oConnAlmacen, $password_oConnAlmacen) or trigger_error(mysql_error(),E_USER_ERROR); 
?>