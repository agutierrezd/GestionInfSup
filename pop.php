<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
function nit(val){
    window.opener.document.forms['form1'].elements['nit'].value=val;
}
function ne(val){
	window.opener.document.forms['form1'].elements['nombrempresa'].value=val;
	window.close(this);
}
</script>
</head>

<body>
<a href="#" onclick="nit('900123456');ne('mi empresa');">ENLACE</a>
</body>
</html>
