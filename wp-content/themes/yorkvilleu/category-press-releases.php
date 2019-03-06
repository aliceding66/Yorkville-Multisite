<?php get_header(); ?>
 <!-- BreadCrumbs menu --> 

<?php breadcrumbs(); ?>

  
        
       


<div class="contentWithHeaderWrapper">
        <div class="topPageImage">
       
            <img id="ctl00_ctl00_mainContent_imgHeader_imgImage" src="<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url(); ?>" alt="" style="border-width:0px;">  
            <div id="ctl00_ctl00_mainContent_HederImageDescription" class="headerImageText">
	
</div>
        </div>  
        <?php get_template_part( 'menu', 'news'); ?>

         <div class="secondColumn threeColumn">
         <div id="ctl00_ctl00_mainContent_pageTitleInterior">
	
                <div class="title interior"> 
                    <h1><?php echo single_cat_title(); ?></h1>
                    <span class="st_sharethis" displaytext="ShareThis"></span>
                </div>   
            
</div>
                 
   <?php echo category_description(); ?>
            
            
            <a href="#" target="_top" class="toTop">
                <img src="<?php echo get_template_directory_uri(); ?>/images/backtotop.jpg" alt="Back to Top" title="Back to Top">
            </a>

        </div>       
        </div>



    
    <?php get_template_part( 'right', 'sidebar' );?>
         

                
                   <div style="clear: both;"></div>
            </div>
         
        </div>
       
       
<?php  get_footer();?>
