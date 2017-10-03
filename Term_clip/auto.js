
	var term_seed = {};
	var term_cand = {};
	var term_trash = {};
	
	var clip_seed = {};
	var clip_cand = {};	
	var clip_trash = {};
	var term_location = {};


	window.onload = function()
	{
		document.getElementById('myfile').onchange = readFile;
	}

	$(document).ready(function(){
    $(this).click(function(){
        $(this).remove();
    });
	});

	function readFile()
	{
		file = this.files[0];
		var fReader = new FileReader();
		fReader.onload = function(event){
			var str = event.target.result;
			document.getElementById('fileContent').value = str;
		}
		fReader.readAsText(file);
	}

	function WriteToFile() 
	{
    	
 	}



	function GetText()
	{
		return document.getElementById('fileContent').value;
	}

	function GetClip()
	{
		var text = GetText();
		var frontword =parseInt(document.getElementById('frontword').value);
		var backword = parseInt(document.getElementById('backword').value);
		var subtext = text;
		var prefix = 0;
		var index;

		for ( keyword in term_seed )
		{
			index = new Array();
			subtext = text;
			var keyword_len = keyword.length;
			prefix = 0;
			while ( subtext.search(keyword) != -1 )
			{
				index_value = subtext.search(keyword) + prefix;
				index.push( index_value );
				prefix += subtext.search(keyword) + keyword_len;
				subtext = subtext.substring(subtext.search(keyword)+keyword_len);
			}
		
			for ( i = 0; i < index.length; i++ )
			{
				var term_clip_front = text.substring(index[i]-frontword,index[i]);
				var term_clip_back  = text.substring(index[i]+keyword_len,index[i]+keyword_len+backword);
				var term_clip_mix = term_clip_front+"╫"+term_clip_back;
				if ( term_clip_mix in clip_cand )
					clip_cand[term_clip_mix]++;
				else
					clip_cand[term_clip_mix] = 1;
			}
		}
		
		for ( key in clip_cand)
		{		
			 
				var loc = "┴cand";
				$('#clipCandContent').
				append("<p id = \""+key+"cc\">"+"<button onclick=ClipMoveToSeed(this.value) value=\""+key+loc+"\">+</button>"
											 +"<button onclick=ClipMoveToTrash(this.value) value=\""+key+loc+"\">-</button>"+key+" "+clip_cand[key]+"</p>");
			
		}
	}

	function ClipMoveToSeed(str)
	{
		var loc = "┴seed";
		var s = str.split("┴");
		var val = s[0];
		var from = s[1];
	

		
		$('#seedClip').
			append("<p id = \""+val+"cs\">"+"<button onclick=ClipMoveToCandidate(this.value) value=\""+val+loc+"\">C</button>"
										 +"<button onclick=ClipMoveToTrash(this.value) value=\""+val+loc+"\">-</button>"+val+"</p>");
		clip_seed[val]= 1;
		if ( from == "cand" )
		{
			delete clip_cand[val];
			$( "p" ).remove("#"+val+"cc");
		}
		if ( from == "trash" )
		{
			delete clip_trash[val];
			$( "p" ).remove("#"+val+"ct");
		}
	}
	function ClipMoveToTrash(str)
	{
		var loc = "┴trash";
		var s = str.split("┴");
		var val = s[0];
		var from = s[1];
		$( "p" ).remove("#"+val);
		$('#trashClip').
			append("<p id = \""+val+"ct\">"+"<button onclick=ClipMoveToSeed(this.value) value=\""+val+loc+"\">+</button>"+val+"</p>");
		clip_trash[val]= 1;
		if ( from == "cand" )
		{
			delete clip_cand[val];
			$( "p" ).remove("#"+val+"cc");
		}
		if ( from == "seed" )
		{
			delete clip_seed[val];
			$( "p" ).remove("#"+val+"cs");
		}
	}

	function ClipMoveToCandidate(str)
	{
		var loc = "┴cand";
		var s = str.split("┴");

		var val = s[0];
		var from = s[1];
		//alert(val);
		$( "p" ).remove("#"+val);
		$('#clipCandContent').
			append("<p id = \""+val+"cc\">"+"<button onclick=ClipMoveToSeed(this.value) value=\""+val+loc+"\">+</button>"
										 +"<button onclick=ClipMoveToTrash(this.value) value=\""+val+loc+"\">-</button>"+val+"</p>");
		clip_cand[val]= 1;
		if ( from == "seed")
		{
			delete clip_seed[val];
			$( "p" ).remove("#"+val+"cs");
		}
		if ( from == "trash")
		{
			delete clip_trash[val];
			$( "p" ).remove("#"+val+"ct");
		}
	}
	

	function GetTerm()
	{
		var counter = 0;
		term_location = {};
		for (key in clip_seed)
		{
			
			var splitClip = key.split("╫");
			var frontclip =splitClip[0];
			var backclip = splitClip[1];
			//frontclip = frontclip.replace(/\s+/g,"");
			//backclip = backclip.replace(/\s+/g,"");
			
			var regExpTwo = frontclip+".{2,3}"+backclip;
			var re = new RegExp(regExpTwo);
			var getTermText = GetText();
			var matches;
	
			do
			{
				re = new RegExp(regExpTwo);
				var matches = re.exec(getTermText);
				if(matches)
				{
					
					var realText = matches[0].substring(frontclip.length,matches[0].length-backclip.length);
					if (term_location[realText] == null)
						term_location[realText] = new Array();
					term_location[realText].push(getTermText.substring(matches.index-10,matches.index+10));
					getTermText = getTermText.substring(matches.index + matches[0].length);
					if ( realText in term_cand )
						term_cand[realText]++;
					else
						term_cand[realText]= 1;
				}
			}
			while ( matches );
		}
		for ( key in term_cand )
		{
			
				var loc = "┴cand";
				$('#termCandContent').
				append("<p id = \""+key+"tc\">"+"<button onclick=TermMoveToSeed(this.value) value=\""+key+loc+"\">+</button>"+"<button onclick=TermMoveToTrash(this.value) value=\""+key+loc+"\">-</button>"+"<a onclick=ShowDetail(\""+key+"\")>"+key+" "+term_cand[key]+"</a>"+"</p>");
			
		}
	}

	function TermMoveToSeed(str)
	{
		var loc = "┴seed";
		var s = str.split("┴");
		var val = s[0];
		var from = s[1];
		$('#seedTerm').
			append("<p id = \""+val+"ts\">"+"<button onclick=TermMoveToCandidate(this.value) value=\""+val+loc+"\">C</button>"
										 +"<button onclick=TermMoveToTrash(this.value) value=\""+val+loc+"\">-</button>"+val+"</p>");
		term_seed[val] = 1;
		if ( from == "cand")
		{
			delete term_cand[val];
			$( "p" ).remove("#"+val+"tc");
		}
		if ( from == "trash")
		{	
			delete term_trash[val];
			$( "p" ).remove("#"+val+"tt");
		}
	}

	function TermMoveToTrash(str)
	{
		var loc = "┴trash";
		var s = str.split("┴");
		var val = s[0];
		var from = s[1];
		$( "p" ).remove("#"+val);
		$('#trashTerm').
			append("<p id = \""+val+"tt\">"+"<button onclick=TermMoveToSeed(this.value) value=\""+val+loc+"\">+</button>"+val+"</p>");
		term_trash[val] = 1;
		if ( from == "cand")
		{
			delete term_cand[val];
			$( "p" ).remove("#"+val+"tc");
		}
		if ( from == "seed")
		{
			delete term_seed[val];
			$( "p" ).remove("#"+val+"ts");
		}
	}

	function TermMoveToCandidate(str)
	{
		var loc = "┴cand";
		var s = str.split("┴");
		var val = s[0];
		var from = s[1];
		$( "p" ).remove("#"+val);
		$('#termCandContent').
			append("<p id = \""+val+"tc\">"+"<button onclick=TermMoveToSeed(this.value) value=\""+val+loc+"\">+</button>"
										 +"<button onclick=TermMoveToTrash(this.value) value=\""+val+loc+"\">-</button>"+val+"</p>");
		term_cand[val] = 1;
		if ( from == "seed")
		{
			delete term_seed[val];
			$( "p" ).remove("#"+val+"ts");
		}
	}
	function Clean(tar)
	{
		document.getElementById(tar).innerHTML="";
		if ( tar == "clipCandContent" )
		{
			clip_cand = {};
		}
		if ( tar == "termCandContent" )
		{
			term_cand = {};
		}
	}
	function AddSeedTerm()
	{
		var str = document.getElementById("keyword").value;
		if ( str == "" )return;
		$('#seedTerm').
			append("<p id = \""+str+"ts\">"+"<button onclick=TermMoveToCandidate(this.value) value=\""+str+"┴seed"+"\">C</button>"
										+"<button onclick=TermMoveToTrash(this.value) value=\""+str+"┴seed"+"\">-</button>"+str+"</p>");
		term_seed[str] = 1;
		document.getElementById("keyword").innerHTML = "";
	}
	function ShowDetail(str)
	{
		var myWindow = window.open("", "", " scrollbars=1, width=400, height=400");
		
		
    	for ( key in term_location[str])
    	{
    		var numbering = parseInt(key)+1;
    		var strIncludeTerm = term_location[str][key];
    		var index = strIncludeTerm.indexOf(str);
    		myWindow.document.write(numbering +" . "+strIncludeTerm.substring(0,index)+"<span style=\"color:red\">"+strIncludeTerm.substring(index,index + str.length)+"</span>"+strIncludeTerm.substring(index+str.length)+"<br /><br />");
    	}
    	myWindow.document.title = str+"於文本的出現位置";
	}

	function AutoProcess()
	{
		var d = new Date();
		var start_time = d.getTime();
		for (var j = 0 ; j < 50 ; j++ )
		{
			GetClip();
			SelectClip();
			GetTerm();
			SelectTerm();
		}
			var myWindow = window.open("", "", " scrollbars=1, width=400, height=400");
			var numbering = 1;
			
			for ( key in term_seed )
			{
    			myWindow.document.write( key + "<br /><br />");
    			numbering++;
    			myWindow.document.title = "第 "+j+" 次";
    		}
		
		var end_time = d.getTime();
		alert("time: " + (end_time - start_time));
	}

	function SelectClip()
	{
		var loc = "┴cand";
		for ( key in clip_cand )
		{
			if ( clip_cand[key] >= 3 )
				clip_seed[key] = 1;
			
		}
		clip_cand = {};
		document.getElementById("clipCandContent").innerHTML="";
	}

	function SelectTerm()
	{
		var loc = "┴cand";
		for ( key in term_cand )
		{
			if ( /^[a-zA-z0-9\u4E00-\u9FA5]*$/.test(key) && term_cand[key] > 1)
				term_seed[key] = 1;
		}
		for ( key in term_seed )
		{
			if (key.includes('說') || key.includes('聽'))
			{
				delete term_seed[key];
				continue;
			}
			for ( compare in term_seed )
			{
				if ( key.includes(compare) && key !== compare )
				{
					delete term_seed[key];
					break;
				}
			}
		}
		term_cand = {};
		document.getElementById("termCandContent").innerHTML="";
	}

