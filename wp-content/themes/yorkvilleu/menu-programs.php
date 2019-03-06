<h1>HELLO WORLD</h1><div class="firstColumn threeColumn ">            
            <div class="menuTitle threeColumn">
            <img src="<?php echo get_template_directory_uri(); ?>/images/interiorAbout.png" alt="About" title="About">
            </div>
<?php  
        $defaults = array(
			
			'menu_class'      =>' ',// change ul class
			'menu_id'         =>'menuElemnew',//change ul id
			'depth'           => 0,
			'theme_location'  => 'about-menu',
			'menu'=>'Programs'
		);
		wp_nav_menu( $defaults); ?>
		
		
            

        </div>  