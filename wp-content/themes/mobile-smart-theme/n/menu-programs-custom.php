<?php if (has_post_thumbnail()){
			$class = '';
} else {$class = 'noHeaderIcon';}
		?>     
        <div class="firstColumn threeColumn  <?php echo $class; ?>">         
            <div class="menuTitle threeColumn">
            <img src="<?php echo get_template_directory_uri(); ?>/images/interiorPrograms.png" alt="About" title="About">
            </div>
<?php  
			
			$post_slug=$post->post_name;
			
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
			else if($parentsecond && !$parentthird) {
				$menuid = $parentsecond;
			}
			else if(!$parentsecond  && !$parentthird && $parent) {
				$menuid = $parent;
			}
			else {
				$menuid = $post;
			}
			
			$slugtop = $menuid->post_name;
			
			if($slugtop == 'programs' && $parent && $parentthird && $parentsecond) {
				$slugtemp = $parentsecond->post_name;
			} 
			else if($slugtop == 'programs' && $parent && $parentsecond && !$parentthird) {
				$slugtemp = $parent->post_name;
			} 
			else if($slugtop == 'programs' && $parent && !$parentsecond && !$parentthird) {
				$slugtemp = $post_slug;
			}
			else {
				$slugtemp = $slugtop;
			}
			
			
		
        $defaults = array(
			
			'menu_class'      =>' ',// change ul class
			'menu_id'         =>'menuElemnew',//change ul id
			'depth'           => 4,
			'theme_location'  => $slugtemp 
			
		);
		wp_nav_menu( $defaults); 

		
		?>
            

        </div>  