<html>
<head>
<title>Main</title>
</head>
<body>
<form name="myForm">
<input type="button" name="opener" value="Click to pop up" onClick="popUp();">
<input type="text" name="holder" value="" size="25">
<br>
 <select name="myselect" onChange="selectItem();">
 <option></option>
 <option value="value1">option 1</option>
 <option value="value2">option 2</option>
 <option value="value3">option 3</option>
 <option value="value4">option 4</option>
 <option value="value5">option 5</option>
 <option value="value6">option 6</option>
 <option value="value7">option 7</option>
 </select>
</form>
<script language="JavaScript">
<!--
function selectItem(){
	var selindex=document.myForm.myselect.selectedIndex;
	if (selindex!=0) {document.myForm.holder.value=document.myForm.myselect[selindex].value;}
}

var wi=null;
function popUp(){
   if (wi) wi.close();
   wi=window.open("2.php","","width=600,height=300,location=no,scrollbars=no,status=no");
}
//-->
</script>
</body>
</html>
