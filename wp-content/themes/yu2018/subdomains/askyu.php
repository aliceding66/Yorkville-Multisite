<?php

/*
Template Name: askyu.yorkvilleu.ca
*/


?>

<?php get_header(); ?>

<div id="yu_loader">
	
	<div class="loader_icon">
		<div class="lds-css ng-scope">
			<div class="lds-spinner" style="100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
		</div>
	</div>

</div>

<div id="yu_not_loaded">
	
	<img class="img-responsive" src="/wp-content/themes/yu2018/subdomains/askyu/img/welcome-mat.jpg"  style="z-index:100; position:relative;" />
	
	<img class="yu-parralax-right" src="/wp-content/themes/yu2018/img/parralax/crest-white.png" />
	
	<div style="clear:both;"></div>
	
	<!-- ROW INTRO -->
	<div class="container-fluid">

		<div class="row yu-row-white">
		
			<div class="col-md-8">
			
				<center>
					<form id="askyu_form">
						<input class="searchbox_askyu" type="text" placeholder="I need help with..." name="q" id="askyu_search_query"/>
						<button class="searchbox_askyu_submit" type="submit">AskYU</button>
					</form>
				</center>
				
				<div id="askyu_search" style="display:none;">
					
					
					<div id="askyu_search_loader">
						<center>
							<div class="loader_icon">
								<div class="ldsblue-css ng-scope">
									<div class="ldsblue-spinner" style="100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
								</div>
							</div>
						</center>
					</div>
					
					<div id="askyu_search_results" style="display:none;">
						<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<h4>We've found the following articles for you</h4>
								<div class="content">
									No results found.
								</div>
							</div>
						</div>
						</div>
					</div>
					
				</div>
				
				
				<div id="askyu_categories"  class="grid">
				
					<div class="grid-sizer"></div>
					
					<div class="grid-item" >
						<a href="/general-questions" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-general.png" />
						</a>
					</div>
					<div class="grid-item">
						<a href="/technical-support" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-technical-support.png" />
						</a>
					</div>
					<div class="grid-item" >
						<a href="/courses-moodle" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-courses.png" />
						</a>
					</div>
					<div class="grid-item" >
						<a href="/microsoft-office" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-microsoft.png" />
						</a>
					</div>
					<div class="grid-item" >
						<a href="/practicum-tool" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-practicum-tool.png" />
						</a>
					</div>
					<div class="grid-item" >
						<a href="/registrars-office" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-registrar.png" />
						</a>
					</div>
					<div class="grid-item">
						<a href="/student-finance" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-student-finance.png" />
						</a>
					</div>
					<div class="grid-item">
						<a href="/ysis" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-ysis.png" />
						</a>
					</div>
					<div class="grid-item" >
						<a href="/foliotek" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-foliotek.png" />
						</a>
					</div>
					<div class="grid-item" >
						<a href="/mahara-eportfolio" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-mahara.png" />
						</a>
					</div>
					<div class="grid-item">
						<a href="/omnijoin" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-omnijoin.png" />
						</a>
					</div>
					<div class="grid-item" >
						<a href="/pearson-mylab" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-pearson.png" />
						</a>
					</div>
					<div class="grid-item">
						<a href="/turn-it-in" class="no-hover-underline">
							<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/askyu/img/btn-turn-it-in.png" />
						</a>
					</div>
				
				</div>
				
			</div>
			
			<div class="col-md-4" style="background-image:url(/wp-content/themes/yu2018/img/wallpaper-blue.jpg) !important;  display: flex; min-height: 80vh; flex-grow: 1;">
				<div class="col-xs-12">
					
					<?php if ( is_active_sidebar( 'right_sidebar' ) ) : ?>
						<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
							<?php dynamic_sidebar( 'right_sidebar' ); ?>
						</div><!-- #primary-sidebar -->
					<?php endif; ?>
					
				</div>
			</div>
		
		</div>
	</div>
	

</div>	
	

<?php get_footer(); ?>



		

	
	<style>

body {
  font-family: 'Open Sans', sans-serif;

	background-image: url(/wp-content/themes/yu2018/img/wallpaper.jpg);
	background-repeat:repeat;
}

.fullwidth {
  width:100% !important;
  padding:0 !important;
}
.img-full{
	width:100%;
	box-shadow:0px 0px 8px #888888;
	cursor:pointer;
}
#SPACER_FOOTER{margin-top:20px;}



/*------------------------------------*\
	RESPONSIVE
	REMEMBER: Mobile FIRST!
\*------------------------------------*/
@media only screen and (min-width:0px) {

	.grid {
		width:100%;
		max-width: 100%;
	}
	.grid-sizer,.grid-item {
		float: left;
		width: 33%;
		height: auto;
		padding:10px;
	}
	.grid:after {
	  content: '';
	  display: block;
	  clear: both;
	}
	.grid-item img {width:100%; height:auto;}

}

@media only screen and (min-width:320px) {
	
	
}
@media only screen and (min-width:480px) {
	

}
@media only screen and (min-width:768px) {
	
	
}
@media only screen and (min-width:1024px) {
	
	.grid-sizer,.grid-item {
			float: left;
			width: 14.2%;
	}
	
}
@media only screen and (min-width:1140px) {
	
}
@media only screen and (min-width:1280px) {
	
}
@media only screen and (-webkit-min-device-pixel-ratio:1.5),
	   only screen and (min-resolution:144dpi) {


}
	</style>
	
	
	<!-- MASONRY PAGES -->
	<script>
		$( document ).ready(function() {
			var $grid = $('.grid').masonry({
			  // set itemSelector so .grid-sizer is not used in layout
			  itemSelector: '.grid-item',
			  // use element for option
			  columnWidth: '.grid-sizer',
			  percentPosition: true
			});
			
			// Reinit after an image loaded
			$grid.imagesLoaded().progress( function() {
				$grid.masonry('layout');
			});
			
			
		});
		
		
	</script>
	
	<!-- YU LOADER -->
	<script>
	
		setTimeout(function(){
			$("#yu_loader").fadeOut("fast");
				$("#yu_not_loaded").fadeIn("fast");
			$grid.masonry('layout');
			setTimeout(function(){
			},100);
		},100);
	
	</script>
	
	
	<!-- AJAX SEARCH -->
	<script>
	
		$( document ).ready(function() {
			
			var appbar_search = "<?php echo $_GET['search']; ?>";
			
			if(appbar_search){
				$("#askyu_search_query").val(appbar_search);
				
				$("#askyu_categories").hide();
				$("#askyu_articles").hide();
				$("#askyu_search_results").hide();
				
				$("#askyu_search").show();
				$("#askyu_search_loader").show();
				
				setTimeout(function(){
					$('#askyu_form').submit();
				},1000);
			}
			
			$('#askyu_form').submit(function(event) {
				
				event.preventDefault(); // to stop the form from submitting, we're doing ajax magic now
				
				$("#askyu_categories").hide();
				$("#askyu_articles").hide();
				$("#askyu_search_results").hide();
				
				$("#askyu_search").show();
				$("#askyu_search_loader").show();
				
				$.ajax({
				  url: "<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php",
				  type:'POST',
				  data: "action=askyu_search&query="+ $("#askyu_search_query").val(), 
				  success: function(html){
					  console.log(html);
					  $("#content").append(html);    // This will be the div where our content will be loaded
					  $("#askyu_search_loader").hide();
					  $("#askyu_search_results").show();
					  $("#askyu_search_results .content").html(html);    // This will be the div where our content will be loaded
					  $grid.masonry('layout');
					  setTimeout(function(){
						   $grid.masonry('layout');
					  }, 200);
				  }
				});
				
				
				
			});
		});
	
	</script>
	
	
	<!-- INFINITE PAGES -->
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			
			var ajax_timeout = 500;
			var ajax_process = 1;
			var count = 2;
			var total = 100; //<?php echo $wp_query->max_num_pages; ?>;
			
			
			function ajax_scroll(){
				
				var current_page_height = $(document).height() - $(window).height();
				var current_scroll = $(window).scrollTop();
				
				console.log( current_page_height - current_scroll );
				
				if  ( current_page_height - current_scroll <= 400 ){
					if (count > total){
						return false;
					}else{
						
						if(ajax_process == 1){
							console.log("+++++++++ LOADING ARTICLES");
							
							ajax_process = 0;
							
							loadArticle(count);
							
							var $grid = $('.grid').masonry({
							  // set itemSelector so .grid-sizer is not used in layout
							  itemSelector: '.grid-item',
							  // use element for option
							  columnWidth: '.grid-sizer',
							  percentPosition: true
							});
							
							// Reinit after an image loaded
							$grid.masonry('layout');
						}else{
							//console.log("+++++++++ COOLDOWN");
						}
					}
					count++;
				}
				
			}
			
			setInterval(function(){
				console.log("------ COOLDOWN COMPLETE!");
				ajax_process = 1;
				ajax_scroll();
			},ajax_timeout);
	 
			  function loadArticle(pageNumber){    
					  //$('a#inifiniteLoader').show('fast');
					  
					  $.ajax({
						  url: "<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php",
						  type:'POST',
						  data: "action=infinite_scroll&page_no="+ pageNumber + '&loop_file=loop', 
						  success: function(html){
							  $("#content").append(html);    // This will be the div where our content will be loaded

						  }
					  });
					  pageNumber += 10;
				  return false;
			  }
	   
		  });
	</script>
