<div class="firstColumn threeColumn ">            
            <div class="menuTitle threeColumn">
            <img src="<?php echo get_template_directory_uri(); ?>/images/interiorContact-Us.png" alt="About" title="About">
            </div>
<?php  
        $defaults = array(
			
			'menu_class'      =>'interior CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'theme_location'  => 'contact-us' 
			
		);
		wp_nav_menu( $defaults); ?>
            

        </div>  