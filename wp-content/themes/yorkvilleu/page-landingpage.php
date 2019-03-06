<!DOCTYPE html>
<html lang="en">
<head>
<meta name="format-detection" content="telephone=no">
<style>
	@media screen and ( max-width: 395px ) { iframe { height: 840px; } }
.form-container legend span {
    background: none repeat scroll 0 0 #C1272D;
    padding: 0 11px;
}

.form-container legend {
    background: url("<?php echo get_template_directory_uri(); ?>/landing/bg-legend.png") repeat-x scroll 50% 50% rgba(0, 0, 0, 0);
    color: #FFFFFF;
    font-family: Verdana,Geneva,sans-serif;
    font-size: 2em;
    text-transform: uppercase;
}

.form-container p {
    color: #FFFFFF;
    font-size: 1.4em;
    margin-bottom: 1.5em;
}

/*This will remove the sliding animations */
.left { left: 0px !important; }
.right { right: 0px !important; }
.bottom { bottom: 0px !important; }
.rotate { top: 0px !important; }

.btn-login p { width: 270px !important; }
</style>
    <!-- Define Charset -->
    <meta charset="utf-8"/>

    <!-- Page Title -->
    <title>School of Engineering Technology & Computing</title>

    <!-- Responsive Metatag -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page Description and Author -->
    <meta name="description" content="content description">
    <meta name="author" content="Coralix Themes">

    <!-- Stylesheet
	===================================================================================================	 -->
	
   <!-- HTML5 shim, for IE6-8 support of HTML5 elements --><!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!-- styles for IE --><!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/landing/ie.css" type="text/css" media="screen"/><![endif]-->
	
	<!-- Bootstrap -->
	<link href="<?php echo get_template_directory_uri(); ?>/landing/bootstrap-min.css" rel="stylesheet" media="screen">
	<link href="<?php echo get_template_directory_uri(); ?>/landing/bootstrap-responsive-min.css" rel="stylesheet" media="screen">
    <link href="<?php echo get_template_directory_uri(); ?>/landing/helpers.css" rel="stylesheet" media="screen">
 
	<!-- Grid galery -->
	<noscript><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/landing/fallback.css" /></noscript>	
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/landing/fallback.css" /><![endif]-->
		
    <!-- styles radios checkboxes -->    
	<!--[if IE 7]><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/landing/jstyling-ie7Fixes.css" type="text/css" media="screen" /><![endif]-->

	<!-- Custom Template Styles -->
    <link href="<?php echo get_template_directory_uri(); ?>/landing/style.css" rel="stylesheet" media="screen">

	<!-- Media Queries -->
    <link href="<?php echo get_template_directory_uri(); ?>/landing/media-queries.css" rel="stylesheet" media="screen">

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/landing/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/landing/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/landing/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/landing/apple-touch-icon-114x114.png">

<?php wp_head(); ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-3587288-10']);
  _gaq.push(['_setDomainName', 'rccit.ca']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
</script>
</head>


<body>

	<header>
    	<div class="container clearfix">
            <!--logo-->
            <a href="<?php echo site_url(); ?>" id="logo" class="pull-left"> 
            <img src="<?php echo get_template_directory_uri(); ?>/landing/logo.png" alt="logo">
            </a>
          <p class="slogan pull-left nmB">Connect to Innovation.</p>
            
          <div class="pull-right">
            	
	            
	            <div class="btn-login pull-right">
                <p class="slogan pull-right nmB">For more Information call 1-866-467-0661</p>
	            	
	            	
              </div>
            
            </div>		
            
           
        </div>
    </header>
    
		    
    <!-- Slider -->
    <section class="join-form">
    	<div class="slider-container">
		    <ul class="rslides" id="slider">
			  <li><img src="<?php echo get_template_directory_uri(); ?>/landing/img-1.jpg"  alt="//"/></li>
			  <li><img src="<?php echo get_template_directory_uri(); ?>/landing/img-2.jpg"  alt="//"/></li>
			  <li><img src="<?php echo get_template_directory_uri(); ?>/landing/img-3.jpg"  alt="//"/></li>
              <li><img src="<?php echo get_template_directory_uri(); ?>/landing/img-4.jpg"  alt="//"/></li>
		    </ul>
	    </div>
	    <div class="container">
	    	<div class="row-fluid">
	    		<div class="span12">
	    			<div class="form-container pull-right box animated pulse">
		    			<iframe width="100%" scrolling="no" height="598px" frameborder="no" allowtransparency="yes" name="leadcenter"
								src="http://form1.campuslogin.com/ORG/RCC/Contact/ContactForm.aspx?campusid=220&mediaid=12171&countryid=CA&thankyouurl=http://www.yorkvilleu.ca/thankyou/request_thanks.html">
						</iframe>
	    			</div>	    			
	    		</div>
	    	</div>
	    </div>
    </section>
    <!-- End Slider -->
    
    

    <!-- Why -->
	<section class="items tips why generic-section  text-center">
		<div class="container">    		
		<h2 class="left">Are&nbsp; you&nbsp; passionate&nbsp; about&nbsp; Film&nbsp; Production?</h2>
		<p class="intro-text right"><em>With the explosion of growth in independent film, the Canadian entertainment industry, digital filmmaking and specialty channels on television, graduates of the Film Production program are in demand. Right from the start, highly skilled and adaptive film production graduates are well positioned for many creative and exciting career opportunities.</em></p>
		<div class="clear"></div>
		<div class="row-fluid bottom">
        	<div class="span3 item first">
            	<div class="avatar">
            		<img src="<?php echo get_template_directory_uri(); ?>/landing/img-11.jpg" alt="//" />
            		<span><em>18 month<br />program</em></span>
            	</div>                
                <p>Enter the film industry sooner with our intensive creative and technical diploma programs  </p>
            </div>
            <div class="span3 item second">
            	<div class="avatar">
            		<img src="<?php echo get_template_directory_uri(); ?>/landing/img-21.jpg" alt="//" />
            		<span><em>Downtown<br />Campus</em></span>
            	</div>                
                <p>Located in the heart of Toronto, The Toronto Film School (TFS) is a leading provider of programs that offer a fast track to an exciting career in film, television or theatre.  </p>
            </div>
            <div class="span3 item third">
            	<div class="avatar">
            		<img src="<?php echo get_template_directory_uri(); ?>/landing/img-31.jpg" alt="//" />
            		<span><em>industry<br />professionals</em></span>
            	</div>                
                <p>Our award winning faculty work in the industry and provide invaluable support to our students</p>
            </div>
            <div class="span3 item third">
            	<div class="avatar">
            		<img src="<?php echo get_template_directory_uri(); ?>/landing/img-41.jpg" alt="//" />
            		<span><em>transfer credits</em></span>
            	</div>                
                <p>Transfer credits gained from your diploma program to the Bachelor of Business Administration and fast track through a flexible online course schedule through Yorkville University
</p>
            </div>
        </div>
        </div>
	</section><!-- .container -->
	<!-- end Why -->

       
	<!--Video List-->
     <section class="video generic-section  text-center">
     	<div class="container">	
	        
		 	<div class="row-fluid">
	        	<div class="span7 left">
	            	<div id="video">
						<iframe width="800" height="450" src="http://www.youtube.com/embed/KaiB6juVTkA" frameborder="0" allowfullscreen></iframe>
	                </div>
	            </div>
	            <div class="span5 right">	            	
	            	<ul class="list-features text-left"><br>
                    <h2 class="left">Film&nbsp; Production</h2>
	                	<li>CAMERA AND SET PROCEDURE</li>
	                    <li>FILM HISTORY</li>
	                    <li>AUDIO & EDITING</li>
	                    <li>CINEMATROGRAPHY & PRODUCTION</li>
	                    <li>SCRIPTS</li>
	                    <li>FACTUAL ENTERTAINMENT & AFTER EFFECTS</li>
                        <li>PRODUCTION DESIGN</li>
                        <li>FINANCE FOR FILM AND TV</li>
                        <li>FILM CONTRACT/COPYRIGHT and more!</li>
                          
                        
	                </ul>
	            </div>
	        </div> 	
        </div>
     </section>  
     <!--End Video List-->    
    
    
      <!--Testimonials-->
     <section class="testimonials">
     	<div class="container">
            <div class="row-fluid bottom">
            	<div class="span12">
                    <ul class="list-testimonials" id="slider2">
                        <li>
                            <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/landing/img-avatar.png" alt="testimonial image" />
                            <p class="comment">“I would definitely recommend TFS! Going there was one of the best decisions I've ever made and without my education I don't think I would be as successful as I am."   </p>
                            <p class="date"><span></span> Heather Young - 2012 Film Production Alumna</p>
                        </li>
                        <li>
                            <img class="img-circle " src="<?php echo get_template_directory_uri(); ?>/landing/img-avatar-2.png" alt="testimonial image" />
                            <p class="comment">“I chose TFS because I wanted a more hands-on program. I'm excited to learn editing, directing, set and costumes because I hope to work in one of those fields when I graduate."  </p>
                            <p class="date"><span></span> Sydney Hogan - Film Production Student 4th Term</p>
                        </li>            		            	
                    </ul>
                </div>
            </div>
        </div>
     </section>
     <!--End Testimonials-->      
    
    <!--Footer-->
	 <div class="footer">
		 <section class="container generic-section">
			<div class="row-fluid">	
            			
	    		<div class="span3 item left">
	    			<h3>About SETC</h3>
    			  <p>For more than 80 years, the School of Engineering Technology & Computing (SETC) at RCC Institute of Technology has supplied the technology sector with highly skilled graduates. SETC offers a fast and effective path to a rewarding technology career. With small class sizes, dedicated faculty, and strong relationships with more than 3000 employers, SETC offers the support, knowledge base and hands-on training essential to prepare for today’s job market.
</p>
	    		</div>  	

    		  <div class="span3 item right">
	    			<h3>Contact Us</h3>
	    			
					<p>
					<i class="icon-phone"></i>1-866-467-0661<br>
                    <br>
					<i class="icon-home"></i>Steeles Campus<br>
 					2000 Steeles Ave. West,<br>
					Concord, ON L4K 4N1, Canada<br>
	    		</div>  	
                	  
              
	    		<div class="span3 item right">
	    			<h3>Stay Connected</h3>
	    			<p>Follow us in our social networks!<br /></p>
					<ul class="social">
						<li class="tooltip_hover" title="" data-original-title="Facebook"><a href="https://www.facebook.com/SETCCanada" class="facebook">Linked In</a></li>
						<li class="tooltip_hover" title="" data-original-title="Twitter"><a href="https://twitter.com/SETCCanada" class="twitter">Linked In</a></li>
                        <li class="tooltip_hover" title="" data-original-title="Youtube"><a href="http://www.youtube.com/user/rccit?feature=mhum" class="youtube">Linked In</a></li>
                        <li class="tooltip_hover" title="" data-original-title="Linkedin"><a href="http://www.linkedin.com/company/school-of-engineering-technology-&-computing-at-rcc-institute-of-technology" class="in">Linked In</a></li>
					</ul>
	    		</div> 
                   	
                    <div class="span3 item right">
                    <br><br><br>
                <a href="http://www.rccit.ca/"><img src="<?php echo get_template_directory_uri(); ?>/landing/rcc_logo.png" width="371" height="108" alt="RCC"></a> <a href="http://www.aodt.ca/"><img src="<?php echo get_template_directory_uri(); ?>/landing/aod_logo.png" width="371" height="108" alt="AOD"></a> <a href="http://www.torontofilmschool.ca/"><img src="<?php echo get_template_directory_uri(); ?>/landing/tfs_logo.png" width="371" height="108" alt="TFS"></a> <a href="http://www.yorkvilleu.ca/"><img src="<?php echo get_template_directory_uri(); ?>/landing/yorkvillu_logo.png" width="371" height="108" alt="YU"></a></div>   		
               </div>    
		</section>
     </div>
	<!-- End Footer -->  
        	
    
    <!--Copyright-->
	 <div class="copy">
     	<section class="container">
			<p>© 2013 RCC Institute of Technology. RCC Institute of Technology is approved and operates in the province of Ontario</p>
		</section>
	</div>
    <!--End Copyright-->
 
    
    
    
	    
	<!-- ======================= JQuery libs =========================== -->
        
        <!-- Bootstrap.js-->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/landing/bootstrap-select-min.js" type="text/javascript"></script>
        
        <!-- Gallery -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/modernizr-custom-26633.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/jquery-gridrotator.js"></script>
        
        <!-- Slider -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/responsiveslides-min.js"></script>
        
        <!-- Controls styles -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/jquery.jstyling-min.js"></script>
        
        <!-- Video Responsive-->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/jquery-fitvids-min.js" type="text/javascript"></script>
        
        <!-- easing plugin ( optional ) -->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/easing.js" type="text/javascript"></script>
        
        <!-- UItoTop plugin -->
        <script src="<?php echo get_template_directory_uri(); ?>/landing/jquery-ui-totop-min.js" type="text/javascript"></script>
        
        <!--  Waypoints -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/waypoints-min.js"></script>
        
        <!-- Template custom script  -->
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/landing/jquery-func.js"></script>
	<!-- ======================= End JQuery libs ======================= -->
	    
    
    

       
</body>
</html>
