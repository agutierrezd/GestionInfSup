<html>

 <head>
  <title>pop up</title>
  <script language="JavaScript">
<!--
function selectItem(){
	var selindex=document.popUpForm.myselect.selectedIndex;
	if (selindex!=0) {
	   window.close();
	   window.opener.document.myForm.holder.value=document.popUpForm.myselect[selindex].value;
	}
}
//-->    
  </script>
 </head>

 <body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <br>
 <form name="popUpForm">
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
 </body>

</html>