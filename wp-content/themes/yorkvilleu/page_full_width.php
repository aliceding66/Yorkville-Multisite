<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<?php breadcrumbs(); ?>

                <!-- Page Content -->         
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

          <h1><?php the_title(); ?></h1>
          <?php the_content(); ?>
                 

            <a href="#" target="_top" class="toTop">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
            </a>

        </div>       
       
     <?php endwhile;?>
    <?php endif;?>

<?php  get_footer();?>
