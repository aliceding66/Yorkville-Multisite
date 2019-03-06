<?php get_header(); ?>

    <div class="twoColumn firstColumn home">


        <div class="blog_content" style="margin-top:20px; margin-bottom:80px;">

                <?php // Display blog posts on any page @ https://m0n.co/l
                $temp = $wp_query; $wp_query= null;
                $wp_query = new WP_Query(); $wp_query->query('posts_per_page=5' . '&paged='.$paged);
                while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                <article>
                <h2><a href="<?php the_permalink(); ?>" title="Read more"><?php the_title(); ?></a></h2>

                <?php if ( has_post_thumbnail() ) {
                        ?> <div style=""> <?php the_post_thumbnail('medium'); ?></div> <?php
                } ?>

                <?php the_excerpt(); ?>
                <p>
                <a href="<?php the_permalink(); ?>" style="background:#005288; color:white; padding:5px;">Read More</a>
                </p>

                <hr />
                </article>
                <?php endwhile; ?>

                <?php if ($paged > 1) { ?>

                <nav id="nav-posts">
                        <div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
                        <div class="next"><?php previous_posts_link('Newer Posts &raquo;'); ?></div>
                </nav>

                <?php } else { ?>

                <nav id="nav-posts">
                        <div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
                </nav>

                <?php } ?>

                <?php wp_reset_postdata(); ?>

        </div>



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
<img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt=">>" /> <a href="/News-Events/Events-Calendar/Electronics-Info-Session-Aug-23" title="Electronics Info Session Aug 23">Electronics Info Session Aug 23<br />
Saturday 23 August 2014, 12:00 PM</a>
</p>
            <p class="viewCalendar home"><a href="/News-Events/Events-Calendar" title="View Calendar">VIEW CALENDAR</a></p>
        </div>
        <div class="facebookFeed home">


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

            <p class="eventsFacebookTitle home">FACEBOOK FEED</p>
            <div class="fb-activity" data-site="www.rccsetc.ca" data-width="295" data-height="170" data-header="false"
             data-border-color="#FFFFFF" data-font="arial" data-recommendations="true"></div>
        </div>
        
    </div>
    <div class="twoColumn secondColumn home" style="margin-top:40px;">
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
