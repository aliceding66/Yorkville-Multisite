// STEP 1: Load dynamic content from a logic file
var script_context = document.location.hostname;
console.log(script_context);

httpGet("http://appbar.yorkvilleu.dev/home/?uid="+window.user+"&script_context="+script_context);// DEV
//httpGet("http://azure.yorkvilleu.ca/wp-content/themes/yu2018/appbar/index.php/?email="+window.email+"&script_context="+script_context);

// This Javascript will fetch our AppBar
function httpGet(theUrl)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
		//createDiv(xmlhttp.responseText);
		var appbar = document.createElement("span");
		appbar.innerHTML = xmlhttp.responseText;
		document.body.insertBefore(appbar, document.body.firstChild);
		console.log("AppBar SPAN Loaded");
		
        }
    }
    xmlhttp.open("GET", theUrl, false);
    xmlhttp.send();    
}


/*
setTimeout(function(){
	console.log("LOOKING FOR ADMIN");
	if (document.getElementById("wpadminbar")) {
		console.log("WPADMIN BAR FOUND");
		var modal_apps = document.getElementById("modal_apps");
		//modal_apps.style.top= "126px";
	}else{
		console.log("WPADMIN BAR NOT FOUND");
	}
},1000);	
*/