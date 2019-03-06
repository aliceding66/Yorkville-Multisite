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
			if($post->post_parent) {
				$parent = get_post($post->post_parent);
			}
			if ($parent && $parent->post_parent) {
					$parentsecond = get_post($parent->post_parent);
			}
			if($parentsecond) {
				$menuid = $parentsecond;
			}
			else if(!$parentsecond && $parent) {
				$menuid = $parent;
			}
			else {
				$menuid = $post;
			}
			
			$slugtop = $menuid->post_name;
			
			if($slugtop == 'programs' && !$parentsecond) {
				$slugtemp = $post->post_name;
			} 
			else if($slugtop == 'programs' && $parentsecond) {
				$slugtemp = $parent->post_name;
			} 
			else {
				$slugtemp = $slugtop;
			}
			
			
			

			if ($slugtemp){
				get_template_part( 'menu', $slugtemp );
			}
		?>
         



         <div class="secondColumn threeColumn">
         <div id="ctl00_ctl00_mainContent_pageTitleInterior">
	
                <div class="title interior"> 
                    <h1><?php the_title(); ?></h1>
                    <span class="st_sharethis" displaytext="ShareThis"></span>
                </div>   
            
</div> <?php the_content(); ?>
                 

            

        </div>       
        </div>
        
       
     <?php endwhile;?>
    <?php endif;?>
    
    <?php get_template_part( 'right', 'sidebar' );?>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>