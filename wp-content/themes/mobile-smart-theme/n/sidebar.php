<div id="sidebar">

   <?php  
        $defaults = array(
			'menu_class'      =>' ',// change ul class
			'menu_id'         =>'menuElemnew',//change ul id
			'depth'           => 0,
			'theme_location'  => 'programs' 
			
		);
		wp_nav_menu( $defaults); ?>

</div>