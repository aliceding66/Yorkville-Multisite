setTimeout(function(){
	
	
	// ======================
	// REMOVE OLD SAGE HELPER
	// ======================
	$('a').each(function() {
	
		if( $(this).attr('href').indexOf("campus.yorkvilleu") > 2 ){
			var theUrl =  $(this).attr('href').split('?redirect=')[1];
			$(this).attr('href', "http://ezproxy.yorkvilleu.ca/login?url="+ theUrl);
		}
		
		if( $(this).attr('href').indexOf("courses.yorkvilleu") > 2 ){
			//console.log("COURSES LINK FOUND: "+$(this).attr('href').split('?redirect=')[1] );
						
			var theUrl =  $(this).attr('href').split('?redirect=')[1];
			$(this).attr('href', "http://ezproxy.yorkvilleu.ca/login?url="+ theUrl);
			
		}
	
	});
	
	
	
	
	// ======================
	// EZ PROXY LINK BUILDER
	// ======================
	var libraryArray = [
		"proquest.com",
		"ebscohost.com",
		"sagepub.com"
	];
	
	libraryArray.forEach(function(link ){
			
		//console.log("-"+link);		
		
		$('a').each(function() {
			
			//console.log("--Checking: " + $(this).attr('href'));
			
			if( $(this).attr('href').indexOf(link) > 2 ){
				
				//console.log( "---Rewriting: " + $(this).attr('href') );
				
				// Check for existing EZProxy URL, skip if found
				if( $(this).attr('href').indexOf("ezproxy") <= -1 ){ 
				
					var theUrl =  $(this).attr('href');
					$(this).attr('href', "http://ezproxy.yorkvilleu.ca/login?url="+ theUrl);
				
				}
			}
			
		});
		
	});

	

},500);