<?php

// Andy and Alice Work Together :)

include('functions_askyu.php');		// main functions & API for askyu.yorkvilleu.ca
include('functions_alumni.php');	// main functions & API for myalumni.yorkvilleu.ca
include('functions_myprogram.php');// main functions & API for myprogram.yorkvilleu.ca
include('functions_myyu.php');    // main functions & API for myyu.yorkvilleu.ca
include('functions_communicator.php');   // main functions & API for communicator.yorkvilleu.ca
include('functions_postinfo.php');  // main functions for post access account
include('functions_cetl.php');  // main functions for cetl.yorkvilleu.ca
include('functions_api.php');  // main functions for api.yorkvilleu.ca
include('functions_practicumlocator.php');  // main functions for api.yorkvilleu.ca


function add_theme_scripts() {

	wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css',false,'1.1','all');  // mobile css
	//wp_enqueue_style( 'bootstrap_mobile', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');  // mobile bootstrap css
	wp_enqueue_style( 'animsition_css', get_template_directory_uri() . '/css/animsition.min.css',false,'1.1','all');  // CSS animated page transitions
	wp_enqueue_style( 'theme', get_template_directory_uri() . '/css/theme.css',false);    //  Custom Theme css

	wp_enqueue_script( 'animsition_js', get_template_directory_uri() . '/js/animsition.min.js', array(), '1.0.0', true );  // JS animated page transitions
	//wp_enqueue_script( 'bootstrap_js', 'https://code.jquery.com/jquery-3.2.1.slim.min.js' ); 
	//wp_enqueue_script( 'bootstrap_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' ); 
	//wp_enqueue_script( 'bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' ); 
	//wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.js', array(), '1.0.0', true );



}
add_action ( 'wp_enqueue_scripts', 'add_theme_scripts' );
// wp_enqueue_scripts is the action hook for adding some custom css and javscripts 


add_action('wp_head', 'show_template');
// wp_enqueue_scripts is the action hook to Fire the wp_head (<head>...</head>)action.
function show_template() {
    global $template;
	// return template file name
    return basename($template);
}

function hide_update_notice_to_all(){
	// remove update nag from admin notices
	remove_action( 'admin_notices', 'update_nag', 3 );
	?>
	<!- Do not diplay visual composer activation notice -->
	<style>.vc_license-activation-notice{display:none !important;}</style>
	<?php
}
add_action( 'admin_head', 'hide_update_notice_to_all', 1 );
// admin_head is the action hook to customize head section in admin pages


// ============
// INFINITE PAGES
// ============
function wp_infinitepaginate(){
	/*echo "WORKS";

    $loopFile        = $_POST['loop_file'];
    $paged           = $_POST['page_no'];
    $posts_per_page  = get_option('posts_per_page');

    # Load the posts
    query_posts(array('paged' => $paged ));
    get_template_part( $loopFile );
	*/

	$posts = get_posts( array(
		'posts_per_page' => 10,
		'offset' => $_POST['page_no'],
		//'category_name' => array('news','press-releases'),
	) );

	foreach($posts as $post){
		// initialize the default post featured image to btn-qustion.png
		$img_source = "/wp-content/themes/yu2018/subdomains/askyu/img/btn-question.png";
		
		// if the post has a customized featured image, then use the customized one, not the default one
		if(get_the_post_thumbnail_url($post->ID,array(256,256))){
			$img_source = get_the_post_thumbnail_url($post->ID,array(256,256));
		}

		?>
		<!-- Display post title, post content, post image, post category-->
		<div class="grid-item" >
			<a href="<?php echo get_permalink( $post->ID ); ?>">
				<img src="<?php echo $img_source; ?>" class="img-responsive" />
				<div class="yu-btn yu-btn-inverted yu-btn-small" style="width:200px;">
					<div class="highlight"></div>
					<div class="content">
						<h3>Read More</h3>
						</div>
				</div>


				<h4 style="color:white; height:80px; overflow:hidden; font-weight:normal; font-size:16px;"><b><?php echo $post->post_title; ?></b> in <?php echo get_the_category( $post->ID )[0]->cat_name; ?></h4>


			</a>
		</div>
		<?php
	}
    exit;
}
add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');           // for logged in user 
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate');    // if user not logged in


// ============
// SHORTCODES
// ============

// YU BUTTON MAKER
// ---------------
function yu_button_function( $atts ) {
    
	$a = shortcode_atts( array(
        'link' => '',
        'text' => 'Not Set',
		'type' => '',
		'width' => 200,
    ), $atts );

	$class_type = "";
	if($a['type']=="square"){
		$class_type = " yu-btn-square";
	}
	if($a['type']=="apply"){
		$class_type = " yu-btn-apply";
	}


	$html = '
	<div class="yu-btn yu-btn-small '.$class_type.'" style="width:'.$a['width'].'px;">
		<div class="highlight"></div>
		<div class="content">
			<h3>'.$a['text'].'</h3>
		</div>
	</div>
	';

    return $html;
}
add_shortcode( 'yu_button', 'yu_button_function' );
// yu_button is the shortcode for YU Button




///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
// 								DANGER ZONE
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

// THEME CONFIG
// ============
add_action('after_setup_theme', 'remove_admin_bar');
 
 // dont show admin top bar unless it is admin role
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

add_theme_support( 'post-thumbnails' );

// register menu
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
	  'sidebar-menu' => __( 'Sidebar Menu' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );


// ===========
// WIDGET SIDEBAR
// ===========
function yu_widgets_init() {

	// register sidebar in widget
	register_sidebar( array(
		'name'          => 'Right sidebar',
		'id'            => 'right_sidebar',
		'before_widget' => '<span class="yu_widget">',
		'after_widget'  => '</span>',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
add_action( 'widgets_init', 'yu_widgets_init' );

// ===========
// Breadcrumbs
// ===========
function custom_breadcrumbs() {

    // Settings
    $separator          = '/';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = get_bloginfo( 'name' );

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
		echo '<li class="item-home"><a class="bread-link bread-home" href="http://yorkvilleu.ca" title="Home"><i class="fa fa-home" aria-hidden="true"></i> YorkvilleU</a></li>';
		
		
		//echo '<li class="separator separator-home"> ' . $separator . ' </li>';
		$i = 0;
		$sites = get_sites();
		foreach($sites as $site){
			// Get the new draft post ID
			//var_dump($site->blog_id);
			//var_dump($site->domain);
			if (($site->domain == 'my.yorkvilleu.ca') ||  ($site->domain == 'my.yorkvilleu.test')){
				$i = $site->blog_id;
			}
			//echo '<li class="separator separator-home"> ' . $separator . ' </li>';}
		}
		if (get_current_blog_id() != $i){
			echo '<li class="item-home"><a class="bread-link bread-home" href="http://my.yorkvilleu.ca" title="MyYU">MyYU</a></li>';
		}
	
		
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        //echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                //echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                //echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    //$cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                //echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
					//var_dump($separator);
					if ($separator == '/'){}
					else{
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
					}
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';

    }

}

// ENABLE POST TAGS
// add tag support to pages
function tags_support_all() {
	register_taxonomy_for_object_type('post_tag', 'page');
}

// ensure all tags are included in queries
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

// tag hooks
add_action('init', 'tags_support_all');
add_action('pre_get_posts', 'tags_support_query');






// MAGIC FUNCTION! NOT USED YET
// Query all multsites
class WP_Query_Multisite extends WP_Query{

	var $args;

	function __construct( $args = array() ) {
		$this->args = $args;
		$this->parse_multisite_args();
		$this->add_filters();
		$this->query($args);
		$this->remove_filters();

	}

	function parse_multisite_args() {
		global $wpdb;

		$site_IDs = $wpdb->get_col( "select blog_id from $wpdb->blogs" );

		if ( isset( $this->args['sites']['sites__not_in'] ) )
			foreach($site_IDs as $key => $site_ID )
				if (in_array($site_ID, $this->args['sites']['sites__not_in']) ) unset($site_IDs[$key]);

		if ( isset( $this->args['sites']['sites__in'] ) )
			foreach($site_IDs as $key => $site_ID )
				if ( ! in_array($site_ID, $this->args['sites']['sites__in']) )
					unset($site_IDs[$key]);


		$site_IDs = array_values($site_IDs);
		$this->sites_to_query = $site_IDs;
	}

	function add_filters() {

			add_filter('posts_request', array(&$this, 'create_and_unionize_select_statements') );
			add_filter('posts_fields', array(&$this, 'add_site_ID_to_posts_fields') );
			add_action('the_post', array(&$this, 'switch_to_blog_while_in_loop'));
			add_action('loop_end', array(&$this, 'restore_current_blog_after_loop'));

	}
	function remove_filters() {
			remove_filter('posts_request', array(&$this, 'create_and_unionize_select_statements') );
			remove_filter('posts_fields', array(&$this, 'add_site_ID_to_posts_fields') );
			remove_action('the_post', array(&$this, 'switch_to_blog_while_in_loop'));
	}

	function create_and_unionize_select_statements( $sql ) {
		global $wpdb;

		$root_site_db_prefix = $wpdb->prefix;

		$page = isset( $this->args['paged'] ) ? $this->args['paged'] : 1;
		$posts_per_page = isset( $this->args['posts_per_page'] ) ? $this->args['posts_per_page'] : 10;
		$s = ( isset( $this->args['s'] ) ) ? $this->args['s'] : false;

		// order
		if( !preg_match('/ORDER BY [A-Za-z0-9_]+\.([A-Za-z0-9_.]+) (ASC|DESC)/', $sql, $orderby) ){
			$orderby = array( 1 => 'post_date', '2' => 'DESC' );
		}

		foreach ($this->sites_to_query as $key => $site_ID) :

			switch_to_blog( $site_ID );

			$new_sql_select = str_replace($root_site_db_prefix, $wpdb->prefix, $sql);
			$new_sql_select = preg_replace("/ LIMIT ([0-9]+), ".$posts_per_page."/", "", $new_sql_select);
			$new_sql_select = str_replace("SQL_CALC_FOUND_ROWS ", "", $new_sql_select);
			$new_sql_select = str_replace("# AS site_ID", "'$site_ID' AS site_ID", $new_sql_select);
			$new_sql_select = preg_replace( '/ORDER BY ([A-Za-z0-9_.]+) (ASC|DESC)/', "", $new_sql_select);

			if( $s ){
				$new_sql_select = str_replace("LIKE '%{$s}%' , wp_posts.post_date", "", $new_sql_select); //main site id
				$new_sql_select = str_replace("LIKE '%{$s}%' , wp_{$site_ID}_posts.post_date", "", $new_sql_select);  // all other sites
			}

			$new_sql_selects[] = $new_sql_select;

			restore_current_blog();

		endforeach;

		if ( $posts_per_page > 0 ) {
			$skip = ( $page * $posts_per_page ) - $posts_per_page;
			$limit = "LIMIT $skip, $posts_per_page";
		} else {
            $limit = '';
        }
		$orderby = "tables.post_date DESC";
		$new_sql = "SELECT SQL_CALC_FOUND_ROWS tables.* FROM ( " . implode(" UNION ALL ", $new_sql_selects) . ") tables ORDER BY tables.$orderby[1] $orderby[2] " . $limit;

		return $new_sql;
	}

	function add_site_ID_to_posts_fields( $sql ) {
		$sql_statements[] = $sql;
		$sql_statements[] = "# AS site_ID";
		return implode(', ', $sql_statements);
	}

	function switch_to_blog_while_in_loop( $post ) {
		global $blog_id;
		if($post->site_ID && $blog_id == $post->site_ID){
			return;
		}
		restore_current_blog();
		if($post->site_ID && $blog_id != $post->site_ID){
			switch_to_blog($post->site_ID);
		}else{
			restore_current_blog();
		}
	}

	function restore_current_blog_after_loop() {
		restore_current_blog();
	}
}



// WORDPRESS 4.9 CACHE BUG FIX
// PROBABLY REMOVE THIS AT SOME POINT
function wp_42573_fix_template_caching( WP_Screen $current_screen ) {
	// Only flush the file cache with each request to post list table, edit post screen, or theme editor.
	if ( ! in_array( $current_screen->base, array( 'post', 'edit', 'theme-editor' ), true ) ) {
		return;
	}
	$theme = wp_get_theme();
	if ( ! $theme ) {
		return;
	}
	$cache_hash = md5( $theme->get_theme_root() . '/' . $theme->get_stylesheet() );
	$label = sanitize_key( 'files_' . $cache_hash . '-' . $theme->get( 'Version' ) );
	$transient_key = substr( $label, 0, 29 ) . md5( $label );
	delete_transient( $transient_key );
}
add_action( 'current_screen', 'wp_42573_fix_template_caching' );


add_action( 'admin_menu', 'stop_access_profile' );
function stop_access_profile() {
    remove_menu_page( 'profile.php' );
    remove_submenu_page( 'users.php', 'profile.php' );
    //if(IS_PROFILE_PAGE === true) {
        //wp_die( 'You are not permitted to change your own profile information. Please contact a member of HR to have your profile information changed.' );
    //}
}

function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

function record_access( $post_ID, $post, $update) {
	
	// get the current number;
	global $wpdb;
    $query_current_post_access	= "SELECT accessnumber FROM wp_postinfo WHERE postid=".$post->ID." AND siteid=".get_current_blog_id();
	$current_post_access = $wpdb->get_results($query_current_post_access);
	//var_dump($post->ID);
	//var_dump(get_current_blog_id());
	//var_dump($current_post_access);
	//var_dump($current_post_access[0]->accessnumber);  

	$query_post_author	= "SELECT display_name FROM wp_users WHERE ID=".$post->post_author;
	$current_post_author = $wpdb->get_results($query_post_author);
	$current_post_author = $current_post_author[0]->display_name;
	//var_dump($current_post_access);
	
	// add by 1 and put the updated count back into database
	
	if (isset($current_post_access[0]->accessnumber)) {
	   $tempcount = intval($current_post_access[0]->accessnumber) + 1;
	   
		$query_current_author_post = "UPDATE wp_postinfo SET accessnumber = ".$tempcount.", lastedit = '".$current_post_author."' WHERE postid=".$post->ID." AND siteid=".get_current_blog_id();

		$wpdb->query($query_current_author_post);
	}
	
	else {
		$query_current_author_post = "INSERT INTO wp_postinfo (accessnumber, postid, siteid, lastedit, totalhit) VALUES ( 1,".$post->ID.", ".get_current_blog_id().",'".$current_post_author."', 0)";

		
		$wpdb->query($query_current_author_post);
	
	}
	
	//$current_author_posts = $wpdb->quer($query_current_author_post);
		
	
}
add_action('save_post', 'record_access', 10, 3 );


function rm_post_view_count(){
	
	global $wpdb;
	global $post;
	//if ( is_single() || is_page()){
		
		//global $wpdb;
		
		//if ( is_user_logged_in() ) {
		//	$temp_user = 'Student/Faculty';
		//}
		
		//else  {
		//	$temp_user= 'Guest';
		//}
		
		
		$query_count_post = "SELECT totalhit FROM wp_postinfo WHERE postid=".$post->ID." AND siteid=".get_current_blog_id();
        $count_post = $wpdb->get_results($query_count_post);
		
		
		
		//$count_post = (int)$count_post[0]->totalhit;
		
		//$query_post_author	= "SELECT display_name FROM wp_users WHERE ID=".$post->post_author;
		//$current_post_author = $wpdb->get_results($query_post_author);
		//$current_post_author = $current_post_author[0]->display_name;
		
		//$user_track = $wpdb->insert('wp_posttrack',array('hittime'=> current_time('mysql'), 'usertype' => $temp_user, 'siteid'=>get_current_blog_id(),'postid' => $post->ID, 'useragent' => $_SERVER['HTTP_USER_AGENT'], 'clientip' => $_SERVER['REMOTE_ADDR'], 'clienthostip' => $_SERVER['REMOTE_HOST'], 'querystring' => $_SERVER['QUERY_STRING']));

		

	//}

}

add_action('wp_head', 'rm_post_view_count');


// function to display number of posts.
function getPostViews($postID, $siteID){
	global $wpdb;
	switch_to_blog($siteID);
    $count_key = 'post_views_count';
    $query_count_post = "SELECT totalhit FROM wp_postinfo WHERE postid=".$postID." AND siteid=".$siteID;
    $count_post = $wpdb->get_results($query_count_post);
	
    if(isset($count_post[0]->totalhit)){
	}
	else{
       return '0 Views';
    }
    return $count_post[0]->totalhit.' Views';
}
 
// function to count views.
function setPostViews($postID, $siteID,$authorname) {
   
   global $wpdb;
   switch_to_blog($siteID);
    $query_count_post = "SELECT totalhit FROM wp_postinfo WHERE postid=".$postID." AND siteid=".$siteID;
    $count_post = $wpdb->get_results($query_count_post);
	
    if(isset($count_post[0]->totalhit)){
		$count_post = (int)$count_post[0]->totalhit + 1;
		$query_update_count = "UPDATE wp_postinfo SET totalhit = ".$count_post." WHERE postid=".$postID." AND siteid=".$siteID;
		$wpdb->query($query_update_count);
	}
	else{
        $count_post = 1;
		//$query_update_count = "INSERT INTO wp_postinfo (accessnumber, postid, siteid, lastedit, totalhit) VALUES (0,".$post->ID.",".get_current_blog_id().",'alice', 1)";
		$result = $wpdb->insert('wp_postinfo',array('accessnumber'=> 0, 'postid' => $postID, 'siteid'=>$siteID,'lastedit' => $authorname, 'totalhit' => 1));

        return "1 View";
    }
    return ;
}
 
function my_mod_search($query) {
    if ($query->is_search()) {
		if (is_user_logged_in()){
			
			
			$current_user_id = get_current_user_id();
			
			$current_user_ysis = get_user_meta($current_user_id, 'ysis_data');
			//var_dump($current_user_ysis);
			
			if($current_user_ysis === false){
			
				$taxquery = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'brand',
						'field'    => 'slug',
						'terms'    => array( 'tfs','yu','yuon' ),
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'jurisdiction',
						'field'    => 'slug',
						'terms'    => array( 'bc', 'nb','on' ),
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'delivery',
						'field'    => 'slug',
						'terms'    => array( 'tfsonline','yorkvilleu' ),
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'baseprogram',
						'field'    => 'slug',
						'terms'    => array( '2da','3da','act','ad','at','bba','bbaacc','bbabc','bbaem','bbanbgpl','bbaon','bbapm','bbascm','bbauacc','bbaubc','bbauem','bbaunbgpl','bbauon','bbaupm','bbauscm','bbaups','bbis','bid','bidol','btc','bte','btqp','cadd','cis','cnet','csw','dfnb','dhd','dimb','dpv','dt','eet','egwy','elt','ent','epth','ety','fd','fmm','fp','fpnb','gd','gdim','gdimnb','gmd','id','id3','idd','iddnb','macp','meae','melea','melll','mfe','nas','pgd','ppft','unae','unba','unbabc','uncp','unmel','vfx','vg','vga','vganb','vpnb','wft','wftnb' ),
						'operator' => 'NOT IN'
					),
					array(
						'taxonomy' => 'staff',
						'field'    => 'slug',
						'terms'    => array( 'staff','faculty','student'),
						'operator' => 'NOT IN'
					)
					
				);
				
				
				$query->set('tax_query', $taxquery);


			}
		
			else{
				$current_user_ysis = JSON_decode($current_user_ysis[0]);
				//var_dump($current_user_ysis);
			
				// get YSIS_COURSE field

						$current_user_ysis_course = $current_user_ysis->YSIS_COURSE;
						//var_dump($current_user_ysis_course);
				
						// get site id

						$current_site_id =  get_current_blog_id();
						//var_dump($current_site_id);
			
						// get page/post id
						$current_url_post_id = intval($post_id);
						//var_dump($current_url_post_id);
			

						//var_dump($user_jurisdiction);

						// get page/post jurisdiction tag

						//switch_to_blog($current_site_id);
						
						//global $wpdb;
						//$current_jurisdictions_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'jurisdiction')";
						//$current_jurisdictions =  $wpdb->get_results($current_jurisdictions_query);
						
						//$current_brands_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'brand')";
						//$current_brands =  $wpdb->get_results($current_brands_query);
						
						
						//$current_baseprograms_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'baseprogram')";
						//$current_baseprograms =  $wpdb->get_results($current_baseprograms_query);
						
						
						//$current_campuses_query = "SELECT wp_".$current_site_id."_terms.name FROM wp_".$current_site_id."_terms WHERE term_id IN (SELECT term_id FROM wp_".$current_site_id."_term_relationships JOIN wp_".$current_site_id."_term_taxonomy ON wp_".$current_site_id."_term_relationships.term_taxonomy_id = wp_".$current_site_id."_term_taxonomy.term_taxonomy_id WHERE object_id = ".$current_url_post_id." AND taxonomy = 'delivery')";
						//$current_campuses =  $wpdb->get_results($current_campuses_query);
						
						//var_dump($current_jurisdictions);
						//var_dump(isset($current_jurisdiction->errors));
						//restore_current_blog();
				
				
						//if (!isset($current_user_ysis_course[0]->Juridiction)){$current_jurisdiction_pointer = [];}
						//else {
						//	foreach ($current_jurisdictions as $current_jurisdiction) {
						//		array_push($current_jurisdiction_pointer,$current_jurisdiction->name);
						//	}
						//}
				
						//if (!isset($current_brands[0]->name)){$current_brand_pointer = [];}
						//else {
						//	foreach ($current_brands as $current_brand) {
						//		array_push($current_brand_pointer,$current_brand->name);
						//	}
						//}
						
						//if (!isset($current_baseprograms[0]->name)){$current_baseprogram_pointer = [];}
						//else {
						//	foreach ($current_baseprograms as $current_baseprogram) {
						//		array_push($current_baseprogram_pointer,$current_baseprogram->name);
						//	}
						//}
						
						//if (!isset($current_campuses[0]->name)){$current_campus_pointer = [];}
						//else {
						//	foreach ($current_campuses as $current_campus) {
						//		array_push($current_campus_pointer,$current_campus->name);
						//	}
						//}
						
						if (isset( $current_user_ysis_course[0]->Campus)){
							$current_user_campus = $current_user_ysis_course[0]->Campus;
						}
						else {
							$current_user_campus =  $current_user_ysis->ProgramBase;
						}
						
						if (isset( $current_user_ysis_course[0]->ProgramBase)){
							$current_user_programbase = $current_user_ysis_course[0]->ProgramBase;
						}
						else {
							$current_user_programbase =  $current_user_ysis->ProgramBase;
						}
						
						//var_dump($current_user_campus);
						//var_dump($current_user_programbase);
				 
						if ($current_user_ysis_course[0]->Brand == 'YU_ON'){$current_user_ysis_course[0]->Brand = 'yuon';}
						if ($current_user_campus  == 'TFS Online'){$current_user_ysis_course[0]->Campus = 'tfsonline';}
						if ($current_user_campus  == 'Yorkville University'){$current_user_ysis_course[0]->Campus = 'yorkvilleu';}
						if ($current_user_programbase == 'WFT_NB'){$current_user_ysis_course[0]->ProgramBase = 'wftnb';}
						if ($current_user_programbase == 'VP_NB'){$current_user_ysis_course[0]->ProgramBase = 'vpnb';}
						if ($current_user_programbase == 'VGA_NB'){$current_user_ysis_course[0]->ProgramBase = 'vganb';}
						if ($current_user_programbase == 'UN-MEL'){$current_user_ysis_course[0]->ProgramBase = 'unmel';}
						if ($current_user_programbase == 'UN-CP'){$current_user_ysis_course[0]->ProgramBase = 'uncp';}
						if ($current_user_programbase == 'UN-BA_BC'){$current_user_ysis_course[0]->ProgramBase = 'unbabc';}
						if ($current_user_programbase == 'UN-BA'){$current_user_ysis_course[0]->ProgramBase = 'unba';}
						if ($current_user_programbase == 'UN-AE'){$current_user_ysis_course[0]->ProgramBase = 'unae';}
						if ($current_user_programbase == 'MEL_LL'){$current_user_ysis_course[0]->ProgramBase = 'melll';}
						if ($current_user_programbase == 'GDIM_NB'){$current_user_ysis_course[0]->ProgramBase = 'gdimnb';}
						if ($current_user_programbase == 'FP_NB'){$current_user_ysis_course[0]->ProgramBase = 'fpnb';}
						if ($current_user_programbase == 'MEL_EA'){$current_user_ysis_course[0]->ProgramBase = 'melea';}
						if ($current_user_programbase == 'IDD_NB'){$current_user_ysis_course[0]->ProgramBase = 'iddnb';}
						if ($current_user_programbase == 'BBA_UPS'){$current_user_ysis_course[0]->ProgramBase = 'bbaups';}
						if ($current_user_programbase == 'DF_NB'){$current_user_ysis_course[0]->ProgramBase = 'dfnb';}
						if ($current_user_programbase == 'BBA_ACC'){$current_user_ysis_course[0]->ProgramBase = 'bbaacc';}
						if ($current_user_programbase == 'BBA_BC'){$current_user_ysis_course[0]->ProgramBase = 'bbabc';}
						if ($current_user_programbase == 'BBA_EM'){$current_user_ysis_course[0]->ProgramBase = 'bbaem';}
						if ($current_user_programbase == 'BBA_NBGPL'){$current_user_ysis_course[0]->ProgramBase = 'bbanbgpl';}
						if ($current_user_programbase == 'BBA_ON'){$current_user_ysis_course[0]->ProgramBase = 'bbaon';}
						if ($current_user_programbase == 'BBA_PM'){$current_user_ysis_course[0]->ProgramBase = 'bbapm';}
						if ($current_user_programbase == 'BBA_SCM'){$current_user_ysis_course[0]->ProgramBase = 'bbascm';}
						if ($current_user_programbase == 'BBA_U_ACC'){$current_user_ysis_course[0]->ProgramBase = 'bbauacc';}
						if ($current_user_programbase == 'BBA_U_BC'){$current_user_ysis_course[0]->ProgramBase = 'bbaubc';}
						if ($current_user_programbase == 'BBA_U_EM'){$current_user_ysis_course[0]->ProgramBase = 'bbauem';}
						if ($current_user_programbase == 'BBA_U_NBGPL'){$current_user_ysis_course[0]->ProgramBase = 'bbaunbgpl';}
						if ($current_user_programbase == 'BBA_U_ON'){$current_user_ysis_course[0]->ProgramBase = 'bbauon';}
						if ($current_user_programbase == 'BBA_U_PM'){$current_user_ysis_course[0]->ProgramBase = 'bbaupm';}
						if ($current_user_programbase == 'BBA_U_SCM'){$current_user_ysis_course[0]->ProgramBase = 'bbauscm';}
						
						
						$taxquery2 = array(
							'relation' => 'AND',
							array(
								'relation' => 'OR',
								array(
									'taxonomy' => 'brand',
									'field'    => 'slug',
									'terms'    => array( 'tfs','yuon','yu'),
									'operator' => 'NOT IN'
								),
								array(
									'taxonomy' => 'brand',
									'field'    => 'slug',
									'terms'    => $current_user_ysis_course[0]->Brand,
									'operator' => 'IN'
								)
							),
							array(
								'relation' => 'OR',
								array(
									'taxonomy' => 'jurisdiction',
									'field'    => 'slug',
									'terms'    =>  array( 'bc', 'nb','on' ),
									'operator' => 'NOT IN'
								),
								array(
									'taxonomy' => 'jurisdiction',
									'field'    => 'slug',
									'terms'    => $current_user_ysis_course[0]->Juridiction,
									'operator' => 'IN'
								)
							),
							array(
								'relation' => 'OR',
								array(
									'taxonomy' => 'delivery',
									'field'    => 'slug',
									'terms'    =>  array( 'tfsonline','yorkvilleu' ),
									'operator' => 'NOT IN'
								),
								array(
									'taxonomy' => 'delivery',
									'field'    => 'slug',
									'terms'    => $current_user_ysis_course[0]->Campus,
									'operator' => 'IN'
								)
							),
							array(
								'relation' => 'OR',
								array(
									'taxonomy' => 'baseprogram',
									'field'    => 'slug',
									'terms'    =>  array( '2da','3da','act','ad','at','bba','bbaacc','bbabc','bbaem','bbanbgpl','bbaon','bbapm','bbascm','bbauacc','bbaubc','bbauem','bbaunbgpl','bbauon','bbaupm','bbauscm','bbaups','bbis','bid','bidol','btc','bte','btqp','cadd','cis','cnet','csw','dfnb','dhd','dimb','dpv','dt','eet','egwy','elt','ent','epth','ety','fd','fmm','fp','fpnb','gd','gdim','gdimnb','gmd','id','id3','idd','iddnb','macp','meae','melea','melll','mfe','nas','pgd','ppft','unae','unba','unbabc','uncp','unmel','vfx','vg','vga','vganb','vpnb','wft','wftnb' ),
									//'terms'    =>  array('bid','fd','macp','bba'),
									'operator' => 'NOT IN'
								),
								array(
									'taxonomy' => 'baseprogram',
									'field'    => 'slug',
									'terms'    => $current_user_ysis_course[0]->ProgramBase,
									'operator' => 'IN'
								)
							),
							array(
								'relation' => 'OR',
								array(
									'taxonomy' => 'staff',
									'field'    => 'slug',
									'terms'    =>  array( 'staff','student','faculty'),
									//'terms'    =>  array('bid','fd','macp','bba'),
									'operator' => 'NOT IN'
								),
								array(
									'taxonomy' => 'staff',
									'field'    => 'slug',
									'terms'    => $current_user_ysis_course[0]->RoleTitle,
									'operator' => 'IN'
								)
							)
						);
						
						$query->set('tax_query', $taxquery2); 
						
											
					
						
						
						
				
			}
			
			
		}
			// any with the same taxonomy with the user will be show
		else{
			// any with taxonomy will not be shown
			
			$taxquery3 = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'brand',
					'field'    => 'slug',
					'terms'    => array( 'tfs','yu','yuon' ),
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'jurisdiction',
					'field'    => 'slug',
					'terms'    => array( 'bc', 'nb','on' ),
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'delivery',
					'field'    => 'slug',
					'terms'    => array( 'tfsonline','yorkvilleu' ),
					'operator' => 'NOT IN'
				),
				array(
					'taxonomy' => 'baseprogram',
					'field'    => 'slug',
					'terms'    => array( '2da','3da','act','ad','at','bba','bbaacc','bbabc','bbaem','bbanbgpl','bbaon','bbapm','bbascm','bbauacc','bbaubc','bbauem','bbaunbgpl','bbauon','bbaupm','bbauscm','bbaups','bbis','bid','bidol','btc','bte','btqp','cadd','cis','cnet','csw','dfnb','dhd','dimb','dpv','dt','eet','egwy','elt','ent','epth','ety','fd','fmm','fp','fpnb','gd','gdim','gdimnb','gmd','id','id3','idd','iddnb','macp','meae','melea','melll','mfe','nas','pgd','ppft','unae','unba','unbabc','uncp','unmel','vfx','vg','vga','vganb','vpnb','wft','wftnb' ),
					'operator' => 'NOT IN'
				)
			);
			
			
			$query->set('tax_query', $taxquery3);
			}
    }
}

add_action('parse_query', 'my_mod_search');
 
// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
 if($column_name === 'post_views'){
        echo getPostViews(get_the_ID(),get_current_blog_id());
    }
}



function user_last_login( $user_login, $user ) {
    update_user_meta( $user->ID, 'last_login', current_time('mysql') );
	global $wpdb;
	$query_select_usertrack = "SELECT * FROM wp_usertrack WHERE username = (select user_login from wp_users where ID = ".$user->ID.")";

	$select_usertrack = $wpdb->get_results($query_select_usertrack);
	if(isset($select_usertrack[0]->username)){
			$result = $wpdb->update('wp_usertrack', array('last_login_date'=>current_time('mysql')),array('username' => $select_usertrack[0]->username));
	}
	else {
		$query_select_user = "select * from wp_users where ID = ".$user->ID;
		$select_user = $wpdb->get_results($query_select_user);
		$result = $wpdb->insert('wp_usertrack',array('username'=> $select_user[0]->user_login, 'failed_attempts' => 0, 'reg_date'=>$select_user[0]->user_registered,'last_login_date' => current_time('mysql')));
	}
	return;
}
add_action( 'wp_login', 'user_last_login', 10, 2 );

// Add a custom user role

$result = add_role( 'message_sender', __(

'Message_sender' ),

array(

'read' => true, // true allows this capability

)

);

add_action( 'wp_login_failed', 'login_failed_info');

function login_failed_info($username){
	
	
		global $wpdb;      
		$siteid = get_current_blog_id();
		
		switch_to_blog($siteid);
		
		$query_count_post = "SELECT * FROM wp_users WHERE user_login = '".$username."' OR user_email = '".$username."'";
		//var_dump($query_count_post);
		$count_post = $wpdb->get_results($query_count_post);
		//var_dump($count_post[0]);
    if(isset($count_post[0]->ID)){
		
		
		$query_count_post_track = "SELECT * FROM wp_usertrack WHERE username = '".$count_post[0]->user_login."'";
		
		$count_post_track = $wpdb->get_results($query_count_post_track);
		//var_dump($count_post_track);
		
		if(isset($count_post_track[0]->username)){
			$count_failed_attempts = (int)$count_post_track[0]->failed_attempts + 1;
			$wpdb->update('wp_usertrack', array('failed_attempts'=>$count_failed_attempts),array('username' => $count_post[0]->user_login));

			//$query_update_count_failed_attempts = "UPDATE wp_usertrack SET failed_attempts = ".$count_failed_attempts." WHERE username=".$count_post[0]->user_login."'";
			//$wpdb->query($query_update_count_failed_attempts);
		}
		else {
			 $count_failed_attempts = 1;
			if (get_the_author_meta('last_login')==''){
				$result = $wpdb->insert('wp_usertrack',array('username'=> $username, 'failed_attempts' => $count_failed_attempts, 'reg_date'=>$count_post[0]->user_registered,'last_login_date' => $count_post[0]->user_registered));
			}
			else {
				$result = $wpdb->insert('wp_usertrack',array('username'=> $username, 'failed_attempts' => $count_failed_attempts, 'reg_date'=>$count_post[0]->user_registered,'last_login_date' => get_the_author_meta('last_login')));
			}
		}
		
		
	}
	else{
        
    }
    return ;
 
}
	
	
	