<?php get_header(); ?>
<?php breadcrumbs(); ?>     

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="twoColumn firstColumn">
			<div class="topPageImage">
				<?php if (has_post_thumbnail()){$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>     
				<img id="ctl00_ctl00_mainContent_imgHeader_imgImage" src="<?php echo $url; ?>" alt="" style="border-width:0px;">
				<?php } ?>
			</div>

			<style>
			.top_margin{margin:10px 0 0 0px;}
			.bottom_margin{margin: 0 0 10px 0px;}
			</style>
			<div class="programs gotham_text_code" style="">
            <h1 class="top_margin"><?php the_title(); ?></h1>
				<?php the_content(); ?> 
                <div style="clear: both;"></div>    
    		</div>
    		
    	</div>
<?php endwhile;?>
<?php endif;?>
<?php get_template_part( 'right', 'sidebar' );?>
	<div style="clear: both;"></div>
	</div>
</div>
<?php  get_footer();?>