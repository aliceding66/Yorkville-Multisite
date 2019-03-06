setInterval(function(){ 
    if (typeof document.getElementById("in-staff-111").checked === "undefined"){
		document.getElementById("branddiv").style.display = "block";
		document.getElementById("jurisdictiondiv").style.display = "block";
		document.getElementById("deliverydiv").style.display = "block";
		document.getElementById("baseprogramdiv").style.display = "block";
	} 
	else{       
		if (document.getElementById("in-staff-111").checked) {
			if ((typeof document.getElementById("in-staff-109").checked != "undefined") && (document.getElementById("in-staff-109").checked)){
				 document.getElementById("branddiv").style.display = "block";
				document.getElementById("jurisdictiondiv").style.display = "block";
				document.getElementById("deliverydiv").style.display = "block";
				document.getElementById("baseprogramdiv").style.display = "block";
			 }
			else if ((typeof document.getElementById("in-staff-113").checked != "undefined") && (document.getElementById("in-staff-113").checked)){
				 document.getElementById("branddiv").style.display = "block";
				document.getElementById("jurisdictiondiv").style.display = "block";
				document.getElementById("deliverydiv").style.display = "block";
				document.getElementById("baseprogramdiv").style.display = "block";
			 }
			else {
				document.getElementById("branddiv").style.display = "none";
				document.getElementById("jurisdictiondiv").style.display = "none";
				document.getElementById("deliverydiv").style.display = "none";
				document.getElementById("baseprogramdiv").style.display = "none";
				var c = document.getElementById('brandchecklist').children;
				for (i=0;i<c.length;i++){
					c[i].children[0].children[0].checked=false;
				}
				var d = document.getElementById('jurisdictionchecklist').children;
				for (i=0;i<d.length;i++){
					d[i].children[0].children[0].checked=false;
				}
				var e = document.getElementById('deliverychecklist').children;
				for (i=0;i<e.length;i++){
					e[i].children[0].children[0].checked=false;
				}
				var f = document.getElementById('baseprogramchecklist').children;
				for (i=0;i<f.length;i++){
					f[i].children[0].children[0].checked=false;
				}
			}
			
		}
		else {
			document.getElementById("branddiv").style.display = "block";
			document.getElementById("jurisdictiondiv").style.display = "block";
			document.getElementById("deliverydiv").style.display = "block";
			document.getElementById("baseprogramdiv").style.display = "block";
		}
	}
 },1000);
