<?php 
/*
WP Post Template: Blog
*/
?>
  <?php get_header(); ?>
<?php breadcrumbs(); ?>
   <?php if (have_posts()) : while (have_posts()) : the_post();
  ?>
  <div class="twoColumn firstColumn blog">
    <div class="headerImageText programs">
               
    </div>
     

<h1>
 <?php the_title(); ?>
</h1>

<ul class="BlogPDateWhole"> 
	<li class="postDate">Posted: <strong><?php the_time('m/d/Y g:i:s A', '', ''); ?></strong></li>

	
	<li class="postComments"><strong><a href="<?php echo get_permalink(); ?>#comments"> <?php comments_number( '<strong>0 comments</strong>', '<strong>1 comment</strong>' ); ?> </a></strong><a href="<?php echo get_permalink(); ?>#comments"> </a></li>
	</ul>

<div class="BlogPBody">
  <?php the_content(); ?>
</div>
<div class="shareThis">
  <span class="st_sharethis" displaytext="ShareThis"></span>
</div>
<ul class="BlogPDateWhole"> 
	<li class="postDate">Posted: <strong><?php the_time('m/d/Y g:i:s A', '', ''); ?></strong></li>

	
	<li class="postComments"><strong><a href="<?php echo get_permalink(); ?>#comments"> <?php comments_number( '<strong>0 comments</strong>', '<strong>1 comment</strong>' ); ?> </a></strong><a href="<?php echo get_permalink(); ?>#comments"> </a></li>

	</ul>
<br>
<br>

<?php comments_template(); ?>
</div>
  
  
  


  <?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>

<?php get_template_part( 'right', 'sidebar' );?>
<?php get_template_part( 'sidebar', 'blog' );?></div>
<?php get_footer();?>

