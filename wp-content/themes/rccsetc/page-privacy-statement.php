<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 



                <!-- Page Content -->         
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                      
      <div class="firstColumn oneColumn">
        <div class="title interior"> 
          <h1><?php the_title(); ?></h1>
        </div>
                  <?php the_content(); ?>
                 

            <a href="#" target="_top" class="toTop">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
            </a>

        </div>       
       
     <?php endwhile;?>
    <?php endif;?>
    
<div style="clear: both;"></div>

            </div>
         
        </div>
       
       
<?php  get_footer();?>