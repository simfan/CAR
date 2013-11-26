function sortTable(plant, column, query, count, sortOrder)
{
	var xmlhttp;
	var table = "'table" + count+"'";
	query = query.substring(0,259);
	if (column.length==0)
	{
		document.getElementById("'"+table+"'").innerHTML="";
  		return;
  	}
	if (window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("table1").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "processes/sortTable.php?plant="+plant+"&field="+column+"&query="+query+"&sort="+sortOrder);
	xmlhttp.send();
	
}