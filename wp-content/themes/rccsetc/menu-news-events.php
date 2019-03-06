<div class="firstColumn threeColumn ">            
            <div class="menuTitle threeColumn">
            <img src="<?php echo get_template_directory_uri(); ?>/images/interiorNews-Events.png" alt="About" title="About">
            </div>
<?php  
        $defaults = array(
			
			'menu_class'      =>'interior CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'theme_location'  => 'news-events' 
			
		);
		wp_nav_menu( $defaults); ?>
            

        </div>  