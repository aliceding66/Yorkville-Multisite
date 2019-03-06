<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<?php breadcrumbs(); ?>

  
<div class="twoColumn firstColumn">
        <div class="topPageImage">
            
        </div>
        <h1 style="display: none;"><?php echo single_cat_title(); ?></h1>
        
  
    <div class="headerImageText programs">
               
    </div>
        

	 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>	

<div class="listItem blogs">
	<div class="itemThumbnail blogs">		
	</div>
	<div class="itemDescription blogs" <?php if (has_post_thumbnail()){ ?> style="min-height:171px" <?php } ?>>
		<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
		<p></p><?php if (has_post_thumbnail()){
			$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		?>     
        <img id="ctl00_ctl00_mainContent_imgHeader_imgImage" src="<?php echo $url; ?>" style="width: 250px; height: 166px; border-top:10px solid #FFF;border-right:10px solid #FFF;border-bottom:10px solid #FFF; float: left;" alt="<?php the_title(); ?>">
           <?php } ?>
           
          <p>
        <span style="font-size: small;"><span style="font-family: Arial;"><?php $short_desc = get_post_meta($post->ID, 'short_desc', true); echo $short_desc; ?> </span></span></p><p></p>		
	</div>
	

	<ul class="BlogPDateWhole" style="clear:both"> 
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