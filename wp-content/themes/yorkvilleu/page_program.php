<?php
/*
Template Name: Program
*/
?>
<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<?php breadcrumbs(); ?>

                <!-- Page Content -->         
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                      
       
       <div class="contentWithHeaderWrapper">
        <div class="topPageImage">
        <?php if (has_post_thumbnail()){
			$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		?>     
            <img id="ctl00_ctl00_mainContent_imgHeader_imgImage" src="<?php echo $url; ?>" alt="" style="border-width:0px;">  
           <?php } ?>
            <div id="ctl00_ctl00_mainContent_HederImageDescription" class="headerImageText">
	
</div>
        </div>
        
		<?php 
		
				get_template_part( 'menu', 'programs-custom' );
		
		?>
         



         <div class="secondColumn threeColumn">
         <?php
         	
			if($post->post_parent) {
				$parent = get_post($post->post_parent);
			}
			if ($parent && $parent->post_parent) {
					$parentsecond = get_post($parent->post_parent);
			}
			if ($parentsecond && $parentsecond->post_parent) {
					$parentthird = get_post($parentsecond->post_parent);
			}
			
			if($parentthird) {
				$menuid = $parentthird;
			}
			else if(!$parentthird && $parentsecond ) {
				$menuid = $parentsecond;
			}
			else if(!$parentthird && !$parentsecond && $parent) {
				$menuid = $parent;
			}
			else {
				$menuid = $post;
			}
			$slugtop = $menuid->post_name;
			
			if($slugtop == 'programs' && $parent && !$parentsecond && !$parentthird) { ?>
	 
			 <?php  } else { ?>
				<div id="ctl00_ctl00_mainContent_pageTitleInterior">
	
                <div class="title interior"> 
                    <h1><?php the_title(); ?></h1>
                    <span class="st_sharethis" displaytext="ShareThis"></span>
                </div>   
            
</div>
			<?php } ?>
        <?php the_content(); ?>
                 

            <a href="#" target="_top" class="toTop">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
            </a>

        </div>       
        </div>
        
       
     <?php endwhile;?>
    <?php endif;?>
    
    <?php get_template_part( 'right', 'sidebar' );?>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>