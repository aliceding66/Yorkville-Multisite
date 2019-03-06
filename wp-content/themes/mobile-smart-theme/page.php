<?php get_header(); ?>
<?php get_template_part( 'menu', 'top' );?>
<div id="page-wrap">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="topimage">
<?php if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'secondary-image')){ 
MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');}
else {if ( has_post_thumbnail() ) {the_post_thumbnail();}}
 ?>
</div>

<article class="post" id="post-<?php the_ID(); ?>">
	<!--<h1><?php the_title(); ?></h1>-->
	<div class="entry"><?php the_content(); ?></div>
</article>
<?php endwhile; endif; ?>
<?php get_template_part( 'menu', 'bottom' );?>
<?php get_footer(); ?>