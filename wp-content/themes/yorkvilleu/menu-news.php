<?php if (function_exists('z_taxonomy_image_url') && z_taxonomy_image_url()) {
			$class = '';
} else {$class = 'noHeaderIcon';}
		?>     
        <div class="firstColumn threeColumn  <?php echo $class; ?>">            
            <div class="menuTitle threeColumn">
            <img src="<?php echo get_template_directory_uri(); ?>/images/interiorNews-Events.png" alt="About" title="About">
            </div>
<?php  
        $defaults = array(
			
			'menu_class'      =>' ',// change ul class
			'menu_id'         =>'menuElemnew',//change ul id
			'depth'           => 0,
			'theme_location'  => 'news',
			'menu'=>'News'
			
		);
		wp_nav_menu( $defaults); ?>
            

        </div>  