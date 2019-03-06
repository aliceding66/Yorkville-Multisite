<?php
/*
Template Name: myprogram.yorkvilleu.ca
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

	<div class="modal fade" role="dialog" tabindex="-1" id="MODAL_HUB">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title">The Hub</h4></div>
				<div class="modal-body">
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="#" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<h3 class="text-center">Learning Success Center</h3></a>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="#" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<h3 class="text-center">Library </h3></a>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="#" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<h3 class="text-center">Alumni </h3></a>
					</div>
					<div class="CLEAR"></div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" role="dialog" tabindex="-1" id="MODAL_STORES">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title">YorkvilleU Stores</h4></div>
				<div class="modal-body">
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="#" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<h3 class="text-center">Clothing Store</h3></a>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="#" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<h3 class="text-center">Book Store</h3></a>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="#" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<h3 class="text-center">Supply Store</h3></a>
					</div>
					<div class="CLEAR"></div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" role="dialog" tabindex="-1" id="MODAL_STAFF">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="text-primary modal-title">Faculty &amp;Staff</h4></div>
				<div class="modal-body">
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="http://branding.azure.yorkvilleu.ca" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<p>Branding </p>
						</a>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 grid-item">
						<a href="https://yorkvilleeducation.desk.com/web/agent/filters/my-department?page=1&amp;fid=2585744&amp;sd=desc&amp;sf=updated_at" class="no-hover-underline"><img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-mycourses.jpg">
							<p>Desk.com </p>
						</a>
					</div>
					<div class="CLEAR"></div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<img class="img-responsive" src="/wp-content/themes/yu2018/subdomains/myprogram/img/welcome-mat.jpg"  style="z-index:100; position:relative;" />

	<div class="col-md-8">
		<section id="Icons"  data-intro="These icons are how you will navigate Yorkville University during your studies.">
	   
			<div class="grid">
				
				<div class="grid-sizer"></div>
				
				<div class="grid-item" >
					<a href="/program-news" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-program-news.png" data-intro="">
					</a>
				</div>
				
				<div class="grid-item" >
					<a href="/contact-advisor" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-contact-advisor.png" data-intro="">
					</a>
				</div>
				
				<div class="grid-item" >
					<a href="/orientation" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-orientation.png" data-intro="">
					</a>
				</div>
				
				<div class="grid-item" >
					<a href="/records" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-records.png" data-intro="">
					</a>
				</div>
				
				<div class="grid-item" >
					<a href="/calendar-policies" class="no-hover-underline">
						<img class="img-responsive img-full" src="/wp-content/themes/yu2018/subdomains/myprogram/img/btn-calendar-policies.png" data-intro="">
					</a>
				</div>
				
			</div>
			
		</section>
	</div>
	
	<div class="col-md-4" style="background-image:url(/wp-content/themes/yu2018/img/wallpaper-blue.jpg) !important;  display: flex; min-height: 80vh; flex-grow: 1;">
		
		
		
	</div>

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

	
<?php wp_footer(); ?>