<section class="">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
		
			<div class="cell small-12 large-12">
				<div id="post-list">
		
					<?php if (have_posts()): while (have_posts()) : the_post(); ?>

						<div class="post">
							<div class="grid-x grid-padding-x grid-margin-y">
								<div class="cell small-12 large-4">
									<a href="<?php the_permalink(); ?>">
										<?php 
											if( has_post_thumbnail() != ""){
												the_post_thumbnail('full', ['class' => 'img-responsive responsive--full', 'title' => 'Feature image']);
											}else{
												?> <img src="/wp-content/themes/yu2018/img/default.png" class="img-responsive"> <?php
											}
										?>
									</a>
								</div>
								<div class="cell small-12 large-8">
									<a class="post-title underline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<!-- <p class="post-meta"><span>Posted on</span> Nov. 22 in <span>Category</span></p>-->
									<p><?php the_excerpt(); ?></p>
									<a class="button primary" href="<?php the_permalink(); ?>">View Article</a>
								</div>
							</div>
						</div>
					
						<hr />

					<?php endwhile; ?>

					<?php else: ?>

						<!-- article -->
						<article>
							<h2>No Articles Found</h2>
						</article>
						<!-- /article -->

					<?php endif; ?>

				</div>
			</div>

		</div>
	</div>
</section>
