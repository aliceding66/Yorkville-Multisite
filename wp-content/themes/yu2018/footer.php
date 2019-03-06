

	<section class="cta text-center section-padding blue">
		<div class="container-grid">
			<div class="grid-x">
				<div class="cell small-12">
					<h2>Questions?</h2>
					<p>Search for commonly asked questions, or submit your question to the help desk</p>
					<br />
					<a class="button" href="http://askyu.azure.yorkvilleu.ca">Search in AskYU</a>
				</div>
			</div>
		</div>
	</section>

	<section class="text-center blue">
		<div class="container-grid">
			<div class="grid-x">
				<div class="cell small-12">
					<hr />
				</div>
			</div>
		</div>
	</section>

	<footer>
		<div class="grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell small-12">
					<h3>Yorkville University</h3>
				</div>
				<div class="cell small-12 large-3">
					<h4>New Brunswick</h4>
					<p>
						Yorkville Landing, Suite 102
						<br>
						100 Woodside Lane
						<br>
						Fredericton, NB
						<br>
						Canada, E3C 2R9
					</p>
				</div>
				<div class="cell small-12 large-3">
					<h4>British Columbia</h4>
					<p>
						1090 West Georgia St, Suite 700
						<br>
						Vancouver, BC
						<br>
						Canada, V6E 3V7
					</p>
				</div>
				<div class="cell small-12 large-3">
					<h4>Ontario</h4>
					<p>
						2000 Steeles Avenue West
						<br>
						Concord, ON
						<br>
						Canada, L4K 4N1
					</p>
				</div>
				<div class="cell small-12 large-3 footer-social">
					<h4>Follow Yorkville</h4>
					<ul>
						<li>
							<a href="https://twitter.com/YorkvilleU" target="_blank">
								<span class="screen-reader-text">Link to Twitter account</span>
								<i class="fab fa-twitter" aria-hidden="true"></i>
							</a>
						</li>
						<li>
							<a href="https://www.facebook.com/YorkvilleUniversity" target="_blank">
								<span class="screen-reader-text">Link to Facebook account</span>
								<i class="fab fa-facebook" aria-hidden="true"></i>
							</a>
						</li>
						<li>
							<a href="https://www.youtube.com/user/YorkvilleUniversity" target="_blank"><span class="screen-reader-text">Link to Youtube account</span><i class="fab fa-youtube" aria-hidden="true"></i></a>
						</li>
						<li>
							<a href="https://www.linkedin.com/school/2378290/" target="_blank"><span class="screen-reader-text">Link to Youtube account</span><i class="fab fa-linkedin" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div>
				<div class="cell small-12">
					<ul style="margin-left:0px;">
						<li>
							<a href="http://www.yorkvilleu.ca/contact-us/">Maps &amp; Directions</a>
						</li>
						<li>
							<a href="http://www.yorkvilleu.ca/privacy-statement/">Privacy Policy</a>
						</li>
						<li>
							<a href="http://www.yorkvilleu.ca/copyright-notice/">Copyright &amp; Notice</a>
						</li>
						<li>
							<a href="http://www.yorkvilleu.ca/sitemap/">Sitemap</a>
						</li>
					</ul>
				</div>


			</div>
		</div>
	</footer>
		
		<!-- ROW FOOTER 
		<div class="container-fluid">

			<div class="row yu-row-blue yu-footer1">
				
				<?php		
			
					$theme_location = "footer-menu";
					if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
						$menu = get_term( $locations[$theme_location], 'nav_menu' );
						$menu_items = wp_get_nav_menu_items($menu->term_id);
				
						$count = 0;
						$submenu = false;
						 
						foreach( $menu_items as $menu_item ) {
							 
							$link = $menu_item->url;
							$title = $menu_item->title;
							 
							if ( !$menu_item->menu_item_parent ) {
								$parent_id = $menu_item->ID;
								
								$menu_list .= '<div class="col-md-3">';
								$menu_list .= '<h3><a href="'.$link.'">'.$title.'</a></h3>';
							}
				 
							if ( $parent_id == $menu_item->menu_item_parent ) {
				 
								if ( !$submenu ) {
									$submenu = true;
								}
				 
								$menu_list .= '
								<a href="'.$link.'">
									<div class="yu-btn yu-btn-inverted yu-btn-small" style="width:300px;">
										<div class="highlight"></div>
										<div class="content">
											<h3>'.$title.'</h3>
										</div>
									</div>
								</a>
								';
								
									 
				 
								if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
									$submenu = false;
								}
				 
							}
				 
							if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id ) {      
								$menu_list .= '</div>';
								$submenu = false;
							}
				 
							$count++;
						}
				 
					} 
					echo($menu_list);

				?>
					
				<br style="clear:both;" />

			</div>
			
		</div>
		
			<!-- ROW FOOTER 
		<div class="container-fluid">

			<div class="row yu-row-blue yu-footer">
			
				<hr style="width:99%;"/>
				
				<div class="col-md-8">
					<p>
					© 2003-2017 RCC Institute of Technology | Yorkville Education Company ULC operates as Yorkville University
					<br />
					For more Information call 1-866-838-6542
					</p>
				</div>
				
				<div class="col-md-4">
					<a href="#">Privacy Statement</a> | <a href="#">Copyright Notice</a> | <a href="#">Sitemap</a>
				</div>
			
			</div>
			
		</div>
		-->
		
		
		
		<script>
		
			var member_hide_test = Math.floor((Math.random() * 2) + 1);
			if( member_hide_test != 1){
				$("#myyu_requires_employee").hide();
			}
			
			$(document).ready(function() {
			 
			 $(".animsition").animsition({
				inClass: 'fade-in-up-sm',
				outClass: 'fade-out-down-sm',
				inDuration: 200,
				outDuration: 200,
				linkElement: 'a:not([target="_blank"]):not([href^=#])',
				//e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
				loading: true,
				loadingParentElement: 'html', //animsition wrapper element
				loadingClass: 'animsition-loading',
				loadingInner: '', //e.g '<img src="loading.svg" />'
				timeout: false,
				timeoutCountdown: 0,
				onLoadEvent: false,
				browser: [ 'animation-duration', '-webkit-animation-duration'],
				//"browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
				//The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
				overlay : false,
				overlayClass : 'animsition-overlay-slide',
				loadingParentElement: 'html',
				transition: function(url){ window.location.href = url; }
			  }); 

			$('.animsition').on('animsition.outEnd', function(){
				var exitDiv = $('<div class="animsition-loading"></div>').attr('id', 'holdy');
				exitDiv.appendTo('body');
				});
			});
			
			
		
		</script>
		
		<?php wp_footer(); ?>
		
		</div>
		
		<!-- ANORMORE@YORKVILLEU.CA -->
		<script>

			function customSetCookie(cname, cvalue, exdays) {
				var d = new Date();
				d.setTime(d.getTime() + (exdays*24*60*60*1000));
				var expires = "expires="+ d.toUTCString();
				document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
			}
			function customGetCookie(cname) {
				var name = cname + "=";
				var decodedCookie = decodeURIComponent(document.cookie);
				var ca = decodedCookie.split(';');
				for(var i = 0; i <ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) == ' ') {
						c = c.substring(1);
					}
					if (c.indexOf(name) == 0) {
						return c.substring(name.length, c.length);
					}
				}
				return "";
			}
			
			if( customGetCookie("custom_library_token") == 1){
				
				// Do nothing

			}else{
			
				customSetCookie("custom_library_token", "1", 1/24); // lasts one hour
			
			
				// ProQuest
				// https://search.proquest.com/embedded/3RD8XS31Q7SGQBCJ
				// =====================================================
				var iframe = document.createElement('iframe');
				iframe.setAttribute('id', 'iframe_proquest'); 
				document.body.appendChild(iframe); 
				iframe.setAttribute('src', 'https://search.proquest.com/embedded/3RD8XS31Q7SGQBCJ'); 
				iframe.setAttribute('style', 'display:none;'); 
			
			
				// EBSCO
				// https://search.ebscohost.com/login.aspx?authtype=uid&profile=ehost&user=s7439054&password=fmmj
				// =====================================================
				var iframe = document.createElement('iframe');
				iframe.setAttribute('id', 'iframe_proquest'); 
				document.body.appendChild(iframe); 
				iframe.setAttribute('src', 'https://search.ebscohost.com/login.aspx?authtype=uid&profile=ehost&user=s7439054&password=fmmj'); 
				iframe.setAttribute('style', 'display:none;'); 
				
				
				// SAGE
				// https://courses.yorkvilleu.ca/local/sage/index.php
				// DISABLED HERE because Sage doesn't support HTTPS
				// =====================================================
				//var iframe = document.createElement('iframe');
				//iframe.setAttribute('id', 'iframe_proquest'); 
				//document.body.appendChild(iframe); 
				//iframe.setAttribute('src', 'https://courses.yorkvilleu.ca/local/sage/index.php'); 
				//iframe.setAttribute('style', 'display:none;'); 
				
			}
			
		</script>
		

		<?php
		$user_meta = json_decode(get_user_meta(get_current_user_id(), "ysis_data", true)); // get the students' data from decoded json data 
		$campus_location = $user_meta->StateProv;

		$isOnlineAtYorkvilleu = get_user_meta( get_current_user_id(), "isOnlineAtYorkvilleu", true ); 
		
		?>

		<style>
			.stateProv_nb{ display:none; }
			.stateProv_on{ display:none; }
			.stateProv_bc{ display:none; }
			
			<?php
			if( $campus_location == "NB") { ?>
				.stateProv_nb{ display:block; }
			<?php 
			}

			if( $campus_location == "BC") { ?>
				.stateProv_bc{ display:block; }
			<?php 
			}

			if( $campus_location == "ON"){ ?>
				.stateProv_on{ display:block; }
			<?php 
			}

			if( $campus_location == ""){ ?>
				.stateProv_nb{ display:block; }
				.stateProv_on{ display:block; }
				.stateProv_bc{ display:block; }
			<?php 
			}
			
			if( $isOnlineAtYorkvilleu == "true"){ ?>
				.isOnlineAtYorkvilleu-true{ display:block; }
				.isOnlineAtYorkvilleu-false{ display:none; }
			<?php 
			}

			if( $isOnlineAtYorkvilleu == "false" || $isOnlineAtYorkvilleu == ""){ ?>
				.isOnlineAtYorkvilleu-true{ display:none; }
				.isOnlineAtYorkvilleu-false{ display:block; }
			<?php 
			}
			
			?>
		</style>
		<!-- V 1.02-->
		
		<script src="/wp-content/themes/yu2018/libraryEzproxy.js"></script>

	</body>
</html>
