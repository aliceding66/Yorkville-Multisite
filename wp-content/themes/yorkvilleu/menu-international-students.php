<?php if (has_post_thumbnail()){
			$class = '';
} else {$class = 'noHeaderIcon';}
		?>     

<div class="firstColumn threeColumn <?php echo $class; ?>">            
            <div class="menuTitle threeColumn">
            <img src="<?php echo get_template_directory_uri(); ?>/images/interiorInternational-Students.png" alt="About" title="About">
            </div>
<?php  
        $defaults = array(
			
			'menu_class'      =>' ',// change ul class
			'menu_id'         =>'menuElemnew',//change ul id
			'depth'           => 0,
			'theme_location'  => 'international-students' 
			'menu'=>'About Menu'
			
		);
		wp_nav_menu( $defaults); ?>
            

        </div>  