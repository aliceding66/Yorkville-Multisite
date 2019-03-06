<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<?php breadcrumbs(); ?>

                <!-- Page Content -->         

                      
       
     
         <div class="event firstColumn">
			<div class="title interior">
            	<h1><?php echo single_cat_title(); ?></h1>
            	<span class="st_sharethis" displaytext="ShareThis"></span>
        	</div>
               
            
<?php echo category_description(); ?>
                 
                 <a href="<?php echo site_url(); ?>/news/" title="News &amp; Events" class="backToNews">
				Back to News &amp; Events<img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt="Back to News &amp; Events" title="Back to News &amp; Events"> 
			</a>
            
            <div class="event eventCalendar">
            
             
           		<div class="Calendar" style="padding:18px 9px 10px 11px"> 
                
                
<? $the_query = new WP_Query( 'page_id=859' );
while ($the_query->have_posts()) : $the_query->the_post();
        the_content();
endwhile;
wp_reset_postdata();
?>
                
                
                </div>
            </div>
            <a href="<?php echo site_url(); ?>/news" title="News &amp; Events" class="backToNews">
				Back to News &amp; Events<img src="<?php echo get_template_directory_uri(); ?>/images/list-style-arrow.png" alt="Back to News &amp; Events" title="Back to News &amp; Events"> 
			</a>

            <a href="#" target="_top" class="toTop">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
            </a>
   
        </div>
        
       

    <?php get_template_part( 'right', 'sidebar' );?>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>
