<?php
/*
WP Post Template: Blog
*/
?>
<?php get_header(); ?>
<?php get_template_part( 'menu', 'top' );?>
<div id="page-wrap">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	
<div class="topimage">

<?php if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'secondary-image')){ 
MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');}
 ?>

</div>
		<article class="post" id="post-<?php the_ID(); ?>" style="margin-top:4px;">
			<h1><?php the_title(); ?></h1>
            <div class="entry"><span class="metadata" style="margin-top:10px; display:block"><?php the_time('m/d/Y g:i:s A', '', ''); ?></span>
			
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; endif; ?>
<div class="menu-bottom" style="margin:0 5px">
<ul class="sub-menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo site_url(); ?>/news-events/student-stories/"><span>Student Stories</span></a></li>
</ul>
</div>
<?php get_footer(); ?>