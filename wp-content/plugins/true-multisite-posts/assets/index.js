(function() {
    tinymce.create("tinymce.plugins.networkpost_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(editor, url) {
			
			
			
			editor.addButton( 'networkpost', {
				title : "Add Network Post",
				image : "/wp-content/plugins/true-multisite-posts/images/logo.png",
				onclick: function() {
					

					// var xmlHttp = new XMLHttpRequest();
					// xmlHttp.open( "POST", "/wp-admin/admin-ajax.php?action=network_find_sites", false ); // false for synchronous request
					// xmlHttp.send( null );
					// var response = xmlHttp.responseText;
					// console.log(response);
					
					var http = new XMLHttpRequest();
					var url = "/wp-admin/admin-ajax.php";
					var params = "action=network_find_sites";
					http.open("POST", url, true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.send(params);
					
					http.onreadystatechange = function() {//Call a function when the state changes.
						if(http.readyState == 4 && http.status == 200) {
							
							var sites = http.responseText;
							var site = sites.split(",");
							
							// Open a TinyMCE modal
							editor.windowManager.open({
								title: 'Add a Network Post',
								body: [{
									type   : 'listbox',
									name   : 'site',
									label  : 'Site',
									values : [
										{ text: site[0], value: site[0] },
										{ text: site[1], value: site[1] },
										{ text: site[2], value: site[2] },
										{ text: site[3], value: site[3] },
										{ text: site[4], value: site[4] },
										{ text: site[5], value: site[5] },
									],
									value : 'test2' // Sets the default
								},{
									type: 'textbox',
									name: 'post_id',
									label: 'Post ID'
								},{
									type: 'textbox',
									name: 'text',
									label: 'Text to display for link'
								},{
									type   : 'radio',
									name   : 'show_description',
									label  : 'Show Description?',
									text   : ''
								},{
									type   : 'radio',
									name   : 'show_pretty_border',
									label  : 'OFF: Link | ON: Pretty Border',
									text   : ''
								}],
								onsubmit: function( event ) {
									editor.insertContent( '[network_post text="' + event.data.text + '" site="' + event.data.site + '" post_id="' + event.data.post_id + '" show_description="' + event.data.show_description + '" show_pretty_border="' + event.data.show_pretty_border + '" ]' );
								}
							});
							
						}
					}
					

					
					
				}
			});


        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Network Posts",
                author : "Andrew Normore",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("networkpost_button_plugin", tinymce.plugins.networkpost_button_plugin);
})();