<?php get_header(); ?>



	<!-- For IE 11 and below, it is suggested to add an ARIA role to the main element to ensure it is accessible -->
	<main role="main">  
			<section class="breadcrumb">
			<div class="grid-container">
				<div class="grid-x">
					<table class="cell small-12" style="border-collapse：initial;">
						<tr>
							<td>
								<?php custom_breadcrumbs(); ?>
							</td>
							<td>
								<?php get_search_form(); ?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</section>
		<!-- section -->
		<section>

			<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
