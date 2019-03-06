<?php get_header(); get_template_part( 'menu', 'top' );?>
<div id="page-wrap">
		<article class="post">

			<div class="entry">
            <br /><br />


<?php
$post = get_post(3384); 
$content = $post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
echo $content;
?>
          <br /><br />
			</div>
		</article>


<?php get_footer(); ?>
