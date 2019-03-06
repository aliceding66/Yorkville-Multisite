<?php

add_action('wp_head', 'show_template');
function show_template() {
    global $template;
    return basename($template);
}

// ==========================
// ==========================
// ==========================


//paging
function my_post_queries( $query ) {
  // not an admin page and is the main query
  if (!is_admin() && $query->is_main_query()){
  	// use category slug for is_category()
    if(is_category('events-calendar')){
      $query->set('posts_per_page', 100);

    }
  }
}
add_action( 'pre_get_posts', 'my_post_queries' );
//

function add_slug_class_to_menu_item($output){
	$ps = get_option('permalink_structure');
	if(!empty($ps)){
		$idstr = preg_match_all('/<li id="menu-item-(\d+)/', $output, $matches);
		foreach($matches[1] as $mid){
			$id = get_post_meta($mid, '_menu_item_object_id', true);
			$slug = basename(get_permalink($id));
			$output = preg_replace('/menu-item-'.$mid.'">/', 'menu-item-'.$mid.' menu-item-'.$slug.'">', $output, 1);
		}
	}
	return $output;
}
add_filter('wp_nav_menu', 'add_slug_class_to_menu_item');

if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(
        array(
            'label' => 'Secondary Image',
            'id' => 'secondary-image',
			'post_type' => 'page'
        )
    );
}
if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(
        array(
            'label' => 'Secondary Image',
            'id' => 'secondary-image',
			'post_type' => 'post'
        )
    );
}

/*--------ADD MENU----------------*/

//include('1menu-slug.php');



/*-------------END ADD MENU-------------------*/

function my_widgets_init() {

register_sidebar( array(
    'name' => __( 'Header Area', 'rccsetc' ),
    'id' => 'header',
    'description' => __( 'Header search' ),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
) );
}
add_action( 'widgets_init', 'my_widgets_init' );
/*--------------------------------*/
function get_slug_for_menu_custume() {
	global $post; 
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
			
			return $menuid;
}
/*--------------------------------*/
function add_first_and_last($output) {
  //$output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
  $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
  return $output;
}
add_filter('wp_nav_menu', 'add_first_and_last');
/*--------------------------------*/
/*
function add_a_classpresactive( $liaclasspresactive ) {
   return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-(.*?)"><a/', '<li class="interior CMSListMenuHighlightedLI"><a class="interior CMSListMenuLinkHighlighted"', $liaclasspresactive);
}
add_filter( 'wp_nav_menu', 'add_a_classpresactive' );

function add_a_classnews( $liaclassnews ) {
   return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-(.*?)"><a/', '<li class="interior CMSListMenuLI"><a class="interior CMSListMenuLink"', $liaclassnews);
}
add_filter( 'wp_nav_menu', 'add_a_classnews' );

function add_a_class( $liaclass ) {
   return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-(.*?)"><a/', '<li class="interior CMSListMenuLI"><a class="interior CMSListMenuLink"', $liaclass);
}
add_filter( 'wp_nav_menu', 'add_a_class' );

function add_menu_li_sub_curent_class( $lisubcurentclass ) {
  return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-(.*?)current_page_item menu-item-(.*?)"><a/', '<li class="interior CMSListMenuHighlightedLI"><a class="interior CMSListMenuLinkHighlighted"', $lisubcurentclass);
}
add_filter( 'wp_nav_menu', 'add_menu_li_sub_curent_class' );

function add_menu_li_curent_class( $licurentclass ) {
  return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current-menu-ancestor current-menu-parent current-page-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-(.*?)"><a/', '<li class="interior CMSListMenuHighlightedLI"><a class="interior CMSListMenuLinkHighlighted"', $licurentclass);
}
add_filter( 'wp_nav_menu', 'add_menu_li_curent_class' );

function add_menu_li_curent_top_class( $licurenttopclass ) {
  return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-(.*?) current_page_item menu-item-has-children menu-item-(.*?)"><a/', '<li class="interior CMSListMenuHighlightedLI"><a class="interior CMSListMenuLinkHighlighted"', $licurenttopclass);
}
add_filter( 'wp_nav_menu', 'add_menu_li_curent_top_class' );



//function add_menu_li_classtop( $liclasstop ) {
//  return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-(.*?)">top<a/', '<li class="menu-item menu-item-type-post_type menu-item-object-page toptenm menu-item-has-children"><a class="topmenua"', $liclasstop);
//}
//add_filter( 'wp_nav_menu', 'add_menu_li_classtop' );



function add_menu_li_class( $liclass ) {
  return preg_replace('/<li id="menu-item-(.*?)" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-(.*?)"><a/', '<li class="interior CMSListMenuLI"><a class="interior CMSListMenuLink"', $liclass);
}
add_filter( 'wp_nav_menu', 'add_menu_li_class' );

function add_menu_li_classtopcl( $liclasstopcl ) {
  return preg_replace('/>top<a/', '><a', $liclasstopcl);
}
add_filter( 'wp_nav_menu', 'add_menu_li_classtopcl' );

function add_menu_ul_sub__class( $ulsubclass ) {
return preg_replace('/<ul class="sub-menu">/', '<ul class="interior CMSListMenuUL">', $ulsubclass);
}
add_filter( 'wp_nav_menu', 'add_menu_ul_sub__class' );

function add_menu_active( $activeclass ) {
  return preg_replace('/<li class="interior CMSListMenuHighlightedLI">/', '<li class="interior CMSListMenuHighlightedLI ">', $activeclass);
}
add_filter( 'wp_nav_menu', 'add_menu_active' );
*/
/*--------------------------------*/


class ik_walker extends Walker_Nav_Menu{
	
}

class ik_walkersec extends Walker_Nav_Menu{

}



function breadcrumbs() {
  global $post;
  
  if (is_single()) {
	  echo '<div class="CMSBreadCrumbs"><a href="/" title="HOME">HOME</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
		$delimiter = '&nbsp;/&nbsp;';
		$title = get_the_title();
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
		 echo '&nbsp;&nbsp;/&nbsp;&nbsp;<span class="CMSBreadCrumbsCurrentItem">'.$title.'</span>';
	  echo '</div>';
  
    }
  else if (is_category()) {
	   		echo '<div class="CMSBreadCrumbs"><a href="/" title="HOME">HOME</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
			$thisCat = get_category(get_query_var('cat'), false);
	 		if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, '&nbsp;&nbsp;/&nbsp;&nbsp;');
      		echo $before . '<span class="CMSBreadCrumbsCurrentItem">' . single_cat_title('', false).'</span>';			
			echo '</div>';
	
  }
  else if (is_page()) {
	  echo '<div class="CMSBreadCrumbs"><a href="/" title="HOME">HOME</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
	  if($post->post_parent){
		  $anc = get_post_ancestors( $post->ID );
		  
		  $title = get_the_title();
		  foreach ( array_reverse($anc) as $ancestor ) {
			  $output = '<a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'" class="navigation">'.get_the_title($ancestor).'</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
			  echo $output;
		  }
		  unset($ancestor);
		  echo '<span class="CMSBreadCrumbsCurrentItem">'.$title.'</span>';
	  } else {
		  echo get_the_title();
	  }
	   echo '</div>';
  }
	
			
}




/*--------------------------------*/

add_theme_support( 'post-thumbnails' );
add_filter('show_admin_bar', '__return_false');
remove_action( 'wp_head', 'feed_links' );
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'index_rel_link');
remove_action( 'wp_head', 'parent_post_rel_link');
remove_action( 'wp_head', 'start_post_rel_link');
remove_action( 'wp_head', 'adjacent_posts_rel_link');
remove_action( 'wp_head', 'wp_generator');

?>
