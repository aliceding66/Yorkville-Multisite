<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<div class="CMSBreadCrumbs"><a href="<?php echo site_url(); ?>" title="HOME">HOME</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="<?php echo site_url(); ?>/news-events/" class="navigation newsEvents">News &amp; Events</a> &nbsp;/&nbsp; <a href="<?php echo site_url(); ?>/news-events/blog/" class="CMSBreadCrumbsLink">Blog</a> &nbsp;/&nbsp; <span class="CMSBreadCrumbsCurrentItem"><?php single_month_title(' ') ?></span>
</div>

  
<div class="twoColumn firstColumn">
        <div class="topPageImage">
            
        </div>
        <h1 style="display: none;"><?php single_month_title(' ') ?></h1>
        
  
    <div class="headerImageText programs">
               
    </div>
        

	 <?php if (have_posts() && in_category('14')) : while (have_posts()) : the_post(); ?>	
<div class="listItem blogs">
	<div class="itemThumbnail blogs">		
	</div>
	<div class="itemDescription blogs">
		<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
		<p></p><p><span style="font-size: small;"><span style="font-family: Arial;"><?php $short_desc = get_post_meta($post->ID, 'short_desc', true); echo $short_desc; ?> </span></span></p><p></p>		
	</div>
	

	<ul class="BlogPDateWhole"> 
	<li class="postDate">Posted: <strong> <?php the_date('m/d/Y g:i:s A', '', ''); ?></strong></li>

	
	<li class="readBlog"><a href="<?php echo get_permalink(); ?>">READ BLOG</a></li>
	<li class="postComments"><strong><a href="<?php echo get_permalink(); ?>#comments"> <?php comments_number( '<strong>0 comments</strong>', '<strong>1 comment</strong>' ); ?> </a></strong><a href="<?php echo get_permalink(); ?>#comments"> </a></li>

	</ul>

	
</div>


  <?php endwhile;?>
   <?php if(function_exists('wp_paginate')) {
    wp_paginate();
}?>
    <?php endif;?>

    </div>
    
    
    


    
    <?php get_template_part( 'right', 'sidebar' );?>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>