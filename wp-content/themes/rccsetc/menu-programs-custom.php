<div class="firstColumn threeColumn ">            
            <div class="menuTitle threeColumn">
            <img src="<?php echo get_template_directory_uri(); ?>/images/interiorPrograms.png" alt="About" title="About">
            </div>
<?php  
			
			$post_slug=$post->post_name;
			
			if($post->post_parent) {
				$parent = get_post($post->post_parent);
			}
			if ($parent && !$parentsecond && !$parentthird && $parent->post_parent) {
					$parentsecond = get_post($parent->post_parent);
			}
			if ($parentsecond && !$parentthird && $parentsecond->post_parent) {
					$parentthird = get_post($parentsecond->post_parent);
			}
			if ($parentthird && $parentthird->post_parent) {
					$parentfourth = get_post($parentthird->post_parent);
			}
			
			
			if($parentfourth) {
				$menuid = $parentfourth;
			}
			else if(!$parentfourth && $parentthird) {
				$menuid = $parentthird;
			}
			else if(!$parentthird && $parentsecond) {
				$menuid = $parentsecond;
			}
			else if(!$parentsecond && $parent) {
				$menuid = $parent;
			}
			else {
				$menuid = $post;
			}
			
			$slugtop = $menuid->post_name;
			
			if($slugtop == 'programs' && !$parentsecond && !$parentthird && !$parentfourth) {
				$slugtemp = $post->post_name;
			} 
			else if($slugtop == 'programs' && $parentsecond && !$parentthird && !$parentfourth) {
				$slugtemp = $post_slug;
			}
			else if($slugtop == 'programs' && $parentsecond && $parentthird && !$parentfourth) {

				$slugtemp = $parent->post_name;
			}
			else if($slugtop == 'programs' && $parentsecond && $parentthird && $parentfourth) {
				$slugtemp = $parentsecond->post_name;
			}
			else {
				$slugtemp = $slugtop;
			}
			
			
		
        $defaults = array(
			
			'menu_class'      =>'interior CMSListMenuUL',// change ul class
			'menu_id'         =>'menuElem',//change ul id
			'depth'           => 0,
			'theme_location'  => $slugtemp 
			
		);
		wp_nav_menu( $defaults); 

		
		?>
            

        </div>  