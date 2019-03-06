<?php get_header(); ?>

<section class="breadcrumb">
	<div class="grid-container">
		<div class="grid-x">
			<div class="cell small-12">
				<?php custom_breadcrumbs(); ?>
			</div>
		</div>
	</div>
</section>

<section class="">
	<div class="grid-container">
		
		<h3 class="post-title underline">Articles in <?php single_cat_title(); ?></h3>

		<?php get_template_part('loop'); ?>

		<?php get_template_part('pagination'); ?>
						
	</div>
</div>

<?php get_footer(); ?>
