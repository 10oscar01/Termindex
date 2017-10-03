window.onload = function()
{
	document.getElementById('myfile').onchange = readFile;
}

function readFile()
{
	file = this.files[0];
	var fReader = new FileReader();
	fReader.onload = function(event)
	{
		var str = event.target.result;
		document.getElementById('fileContent').value = str;
	}
	fReader.readAsText(file);
}

function GetText()
{
	return document.getElementById('fileContent').value;
}

function UniqueText()
{
	text = GetText();
	obj = {};
	alert(text);
	splitStr = text.split(/\r?\n/);
	for ( i = 0; i < splitStr.length; i++ )
	{
		obj[splitStr[i]] = 1;
	}
	count = 0;
	for ( key in obj )
	{
		count++;
	}
	alert(count);
}
