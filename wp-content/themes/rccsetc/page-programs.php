<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<?php breadcrumbs(); ?>

                <!-- Page Content -->         
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                      
       
       <div class="twoColumn firstColumn">
        <div class="topPageImage">
        
         <?php if (has_post_thumbnail()){
			$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		?>     
        <img id="ctl00_ctl00_mainContent_imgHeader_imgImage" src="<?php echo $url; ?>" alt="" style="border-width:0px;">
           <?php } ?>
         
        </div>
     
        
  
    <div class="headerImageText programs">
        <br>
<br>
<?php the_content(); ?>     
    </div>

    <span class="st_sharethis" displaytext="ShareThis"></span>
    
    
        

                    <?php
                    //get children of page 241 and display with custom fields

                    $args=array(
                      'post_parent' => 110,
                      'post_type' => 'page',
					  'order' => 'ASC',
                    );
                    $my_query = null;
                    $my_query = new WP_Query($args);
                    if( $my_query->have_posts() ) {

                      while ($my_query->have_posts()) : $my_query->the_post(); ?>

							<div class="listItem programs">
								<div class="itemThumbnail programs">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
                                    <?php $short_img = get_post_meta($post->ID, 'short_img', true); ?>
                            		<?php if($short_img){ ?>
										<img src="<?php echo $short_img; ?>">
                                        <?php } ?>
                                    </a>
                                </div>
								<div class="itemDescription programs">
                                	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><h3><?php the_title(); ?></h3></a>
                            		<p></p>
                                    <?php $short_desc = get_post_meta($post->ID, 'short_desc', true); ?>
                            		<?php echo $short_desc; ?>
                                    
                                    <p></p>		
								</div>
                                <a href="<?php the_permalink() ?>" class="programs view">View Faculty</a>
							</div>
                       <?php endwhile; } ?>
                    <?php wp_reset_query();  // Restore global post data stomped by the_post().?>

    
    
    

    </div>
        
       
     <?php endwhile;?>
    <?php endif;?>
    
    <?php get_template_part( 'right', 'sidebar' );?>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>