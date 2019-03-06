<?php
/*
Template Name: HomePage
*/

//quire_once __DIR__ . '/../yorkville_dev_production_manager.php'; 
require_once __DIR__ . '/../header.php'; 
//get_header(); 


?>


<div id="yu_loader">
	
	<div class="loader_icon">
		<div class="lds-css ng-scope">
			<div class="lds-spinner" style="100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
		</div>
	</div>

</div>

<div id="yu_not_loaded">

	<?php the_post_thumbnail('full', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']) ?>
	
	<div class="col-md-8">
		
		<?php if (have_posts()){

			while (have_posts()) : the_post(); ?>
				
				<?php the_content(); ?>

			<?php endwhile; ?>


		<?php } ?>
		
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

<?php wp_footer(); ?>
</div>

<script src="/wp-content/themes/yu2018/subdomains/my/js/jquery.min.js"></script>
<script src="/wp-content/themes/yu2018/subdomains/my/bootstrap/js/bootstrap.min.js"></script>
<script src="/wp-content/themes/yu2018/subdomains/my/js/masonry.js"></script>


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
		
		setTimeout(function(){
			$("#yu_loader").fadeOut("fast");
				$("#yu_not_loaded").fadeIn("fast");
			$grid.masonry('layout');
			setTimeout(function(){
			},100);
		},100);
	});
</script>

<script>
	// MODAL CONTROLLER
	$("#BTN_MODAL_HUB").click(function(){
		$("#MODAL_HUB").modal("show");
	});
	$("#BTN_MODAL_STORES").click(function(){
		$("#MODAL_STORES").modal("show");
	});
	$("#BTN_MODAL_STAFF").click(function(){
		$("#MODAL_STAFF").modal("show");
	});
</script>

	