<?php get_header(); ?>
<?php get_template_part( 'menu', 'top' );?>
<div id="page-wrap" class="blogche">
		<?php if (have_posts()) : ?>

 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

			

			<?php while (have_posts()) : the_post(); ?>
			<div class="entry">
				<article <?php post_class() ?> id="bloglist">
				
						<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<span class="metadata">Posted: <?php the_time('m/d/Y g:i:s A', '', ''); ?></span><div class="clear"></div><br />

						
							<?php $short_desc = get_post_meta($post->ID, 'short_desc', true); echo $short_desc; ?>
						
                        <div class="clear"></div><br />
                        <a href="<?php the_permalink() ?>" class="readblog">READ BLOG</a>
                        <div class="clear" style=" margin-bottom:20px;"></div>

				</article></div>

			<?php endwhile; ?>

			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

	<?php else : ?>

		
        
        <div class="entry">
        <br /><br />
        <span style="text-align:center">404 Not Found Error  <br><br>Go back or try to find what you want in our <a href="<?php echo site_url(); ?>" title="Home">homepage</a></span>
        <br /><br />
        </div>

	<?php endif; ?>



<?php get_footer(); ?>

