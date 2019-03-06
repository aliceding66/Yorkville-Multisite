<?php get_header(); ?>
                 <!-- BreadCrumbs menu --> 
                  
                <!-- Page Content -->         
                    

    <div id="fb-root"></div>
    <!-- Facebook Feed code -->
    <script type="text/javascript">        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) { return; }
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        } (document, 'script', 'facebook-jssdk'));
    </script>

    <div class="carousel home">
        <a id="slideArrowLeft" onclick="slideLeft();return false;" href=""></a>
        <a id="slideArrowRight" onclick="slideRight();return false;" href=""></a>
        <ul class="carouselList">            
            
            <?php 
  $postids = array();
  $my_query = new WP_Query('posts_per_page=5&cat=slider&orderby=id&order=ASC');
  if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post();
  $postids[]= $post->ID;

$imgs = get_the_post_thumbnail($post->ID); 
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $imgs, $matches);
$img = $matches [1] [0];
$short_desc = get_post_meta($post->ID, 'slider_url', true); 
?>

                            		
<li class="carouselItem" id="">
<a class="carouselLink" href="<?php echo site_url(); ?><?php echo $short_desc; ?>" Title='<?php the_title(); ?>'/>
<?php echo $imgs ?>
</a>
</li>
 <?php endwhile; ?>
                                <?php endif; ?>
                               <?php wp_reset_query(); ?>
        </ul>
        

<div class="calloutContainer">


    
    <a id="ctl00_ctl00_mainContent_ctl00_btnRequestInfo" class="requestInfo home" href="/Contact-Us/Request-Information"></a>

    <a onclick="window.open('http://application.rccit.ca/ORG/RCC/Application/SETC_Login.aspx');return false;" id="ctl00_ctl00_mainContent_ctl00_btnApplyNow" class="applyNow home" href="javascript:__doPostBack('ctl00$ctl00$mainContent$ctl00$btnApplyNow','')"></a>
</div> 
    </div>
    <div class="twoColumn firstColumn home">
        <div class="about home">
            <img class="about title home" src="<?php echo get_template_directory_uri(); ?>/images/homeabout.png" alt="About the School" title="About the School" />
            <div class="aboutContent home">
                <p><a href="/About">School of Engineering Technology &amp; Computing</a> at <a target="_blank" href="http://www.rccit.ca">RCC Institute of Technology</a> offers <a href="/Programs">programs</a> in Business Information Systems and Electronics Engineering Technology. The school has offered highly regarded, career-focused education and training since 1927.</p>
<p><a title="About" class="aboutContent more" href="/About">MORE</a></p>
            </div>
            <div class="takeTour home">
                <a id="ctl00_ctl00_mainContent_lnkTakeaTour" title="Take a Tour" href="/About/Campus-Tour"><img src="<?php echo get_template_directory_uri(); ?>/images/takeatour.png" alt="Take a Tour" title="Take a Tour" /></a>
            </div>
        </div>
        
        <div class="upcomingEvents home" >
            <p class="eventsFacebookTitle">UPCOMING EVENTS</p>
            
<p class="upcomingEvent home">
<img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt=">>" /> <a href="/News-Events/Events-Calendar/Electronics-Showcase-June-4" title="Electronics Showcase June 4">Electronics Showcase June 4<br />
Wednesday 4 June 2014, 11:00 AM</a>
</p>
<p class="upcomingEvent home">
<!-- <img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt=">>" /> <a href="/News-Events/Events-Calendar/Electronics-Info-Session-Aug-23" title="Electronics Info Session Aug 23">Electronics Info Session Aug 23<br />
Saturday 23 August 2014, 12:00 PM</a> -->
</p>
            <p class="viewCalendar home"><a href="/News-Events/Events-Calendar" title="View Calendar">VIEW CALENDAR</a></p>
        </div>
        <div class="facebookFeed home">
            <p class="eventsFacebookTitle home">FACEBOOK FEED</p>
            <div class="fb-activity" data-site="www.rccsetc.ca" data-width="295" data-height="170" data-header="false"
             data-border-color="#FFFFFF" data-font="arial" data-recommendations="true"></div>
        </div>
        
    </div>
    <div class="twoColumn secondColumn home">
        <img class="programs title home" src="<?php echo get_template_directory_uri(); ?>/images/programs.png" alt="Programs" title="Programs" />        
        
<p class="programItem">
	<a href="/Programs/Bachelor-of-Business-Information-Systems" title="Bachelor of Business Information Systems">
	<img src="<?php echo get_template_directory_uri(); ?>/images/programs/home_programs_thumbs_bbis.jpg" alt="Bachelor of Business Information Systems" title="Bachelor of Business Information Systems">
	</a>
	<a href="/Programs/Bachelor-of-Business-Information-Systems" class="programItemLink" title="Bachelor of Business Information Systems">
	Bachelor of Business Information Systems
	</a>
</p>
<p class="programItem">
	<a href="/Programs/Bachelor-of-Technology" title="Bachelor of Technology (Electronics Engineering Technology)">
	<img src="<?php echo get_template_directory_uri(); ?>/images/programs/home_programs_bachelorOfTechnology.jpg" alt="Bachelor of Technology (Electronics Engineering Technology)" title="Bachelor of Technology (Electronics Engineering Technology)">
	</a>
	<a href="/Programs/Bachelor-of-Technology" class="programItemLink" title="Bachelor of Technology (Electronics Engineering Technology)">
	Bachelor of Technology (Electronics Engineering Technology)
	</a>
</p>
<p class="programItem">
	<a href="/Programs/Electronics-Engineering-Technology-Diploma" title="Electronics Engineering Technology Diploma">
	<img src="<?php echo get_template_directory_uri(); ?>/images/programs/home_programs_electronics.jpg" alt="Electronics Engineering Technology Diploma" title="Electronics Engineering Technology Diploma">
	</a>
	<a href="/Programs/Electronics-Engineering-Technology-Diploma" class="programItemLink" title="Electronics Engineering Technology Diploma">
	Electronics Engineering Technology Diploma
	</a>
</p>
<p class="programItem">
	<a href="/Programs/Electronics-Engineering-Technician-Diploma" title="Electronics Engineering Technician Diploma ">
	<img src="<?php echo get_template_directory_uri(); ?>/images/programs/home_programs_electronicsTechnician.jpg" alt="Electronics Engineering Technician Diploma " title="Electronics Engineering Technician Diploma ">
	</a>
	<a href="/Programs/Electronics-Engineering-Technician-Diploma" class="programItemLink" title="Electronics Engineering Technician Diploma ">
	Electronics Engineering Technician Diploma 
	</a>
</p>
    </div>

      



                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
<?php  get_footer();?>
