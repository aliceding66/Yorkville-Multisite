<?php

class ECWD_Cpt {

    const IMAGE_PLACEHOLDER = '';
    const CALENDAR_POST_TYPE = 'ecwd_calendar';
    const EVENT_POST_TYPE = 'ecwd_event';
    const ORGANIZER_POST_TYPE = 'ecwd_organizer';
    const VENUE_POST_TYPE = 'ecwd_venue';
    const THEME_POST_TYPE = 'ecwd_theme';

    protected static $instance = null;
    public $rewriteSlugSingular;
    public $rewriteSlug;
    private $single_event_for_metas = null;

    private function __construct() {
        global $ecwd_options;
        $this->tax = ECWD_PLUGIN_PREFIX . '_event_category';
        $this->tag = ECWD_PLUGIN_PREFIX . '_event_tag';


        //actions
        add_action('init', array($this, 'setup_cpt'));

        add_action('pre_get_posts', array($this, 'add_custom_post_type_to_query'));
        add_action('pre_get_posts', array($this, 'category_archive_page_query'));
        add_action('pre_get_posts', array($this, 'events_archive_page_query'));
        if(isset($ecwd_options['change_events_archive_page_post_date']) && $ecwd_options['change_events_archive_page_post_date'] == '1'){
            add_filter('the_post', array($this, 'ecwd_events_archive_page'));
        }
        add_action('add_meta_boxes', array($this, 'calendars_cpt_meta'));
        add_action('add_meta_boxes', array($this, 'events_cpt_meta'));
        add_action('add_meta_boxes', array($this, 'themes_cpt_meta'));
        add_action('add_meta_boxes', array($this, 'venues_cpt_meta'));
        add_action('add_meta_boxes', array($this, 'organizers_cpt_meta'));
        add_action('post_updated', array($this, 'save_meta'), 10, 3);
        add_action('manage_' . ECWD_PLUGIN_PREFIX . '_calendar_posts_custom_column', array(
            $this,
            'calendar_column_content'
                ), 10, 2);
        add_action('manage_' . ECWD_PLUGIN_PREFIX . '_event_posts_custom_column', array(
            $this,
            'event_column_content'
                ), 10, 2);

        //duplicate posts actions
        add_filter('post_row_actions', array($this, 'duplicate_event_link'), 10, 2);
        add_action('admin_action_duplicate_ecwd_post', array($this, 'duplicate_post'));

        //events catgeories
        add_action('init', array($this, 'create_taxonomies'), 2);
        add_action(ECWD_PLUGIN_PREFIX . '_event_category_add_form_fields', array(
            $this,
            'add_categories_metas'
                ), 10, 3);
        add_action(ECWD_PLUGIN_PREFIX . '_event_category_edit_form_fields', array(
            $this,
            'add_categories_metas'
                ), 10, 3);
        add_action('edited_' . ECWD_PLUGIN_PREFIX . '_event_category', array(
            $this,
            'save_categories_metas'
                ), 10, 2);
        add_action('create_' . ECWD_PLUGIN_PREFIX . '_event_category', array(
            $this,
            'save_categories_metas'
                ), 10, 2);
        add_filter('manage_edit-' . ECWD_PLUGIN_PREFIX . '_event_category_columns', array(
            $this,
            'taxonomy_columns'
        ));
        add_filter('manage_' . ECWD_PLUGIN_PREFIX . '_event_category_custom_column', array(
            $this,
            'taxonomy_column'
                ), 10, 3);
        add_filter('query_vars', array($this, 'ecwdEventQueryVars'));
        add_filter('generate_rewrite_rules', array($this, 'filterRewriteRules'), 2);


        add_action('wp_ajax_manage_calendar_events', array($this, 'save_events'));
        add_action('wp_ajax_add_calendar_event', array($this, 'add_event'));

        //filters
        add_filter('post_updated_messages', array($this, 'calendar_messages'));
        add_filter('post_updated_messages', array($this, 'theme_messages'));
        add_filter('post_updated_messages', array($this, 'event_messages'));
        add_filter('manage_' . ECWD_PLUGIN_PREFIX . '_calendar_posts_columns', array(
            $this,
            'calendar_add_column_headers'
        ));
        add_filter('manage_' . ECWD_PLUGIN_PREFIX . '_event_posts_columns', array($this, 'add_column_headers'));

        add_filter('template_include', array($this, 'ecwd_templates'), 28);
        add_filter('request', array(&$this, 'ecwd_archive_order'));

        //category filter
        add_filter('init', array($this, 'event_restrict_manage'));
        add_action('the_title', array($this, 'is_events_list_page_title'), 11, 2);
        add_action('after_setup_theme', array($this, 'add_thumbnails_for_themes'));
        add_action('ecwd_venue_after_save_meta',array($this,'change_events_locations'));

    }

    public function change_events_locations($venue_id) {
        $venue_location = (isset($_POST['ecwd_venue_location'])) ? sanitize_text_field($_POST['ecwd_venue_location'] ): "";
        $venue_lat_long = (isset($_POST['ecwd_venue_lat_long']) && !empty($venue_location)) ? sanitize_text_field($_POST['ecwd_venue_lat_long']) : "";
        $venue_show_map = (isset($_POST['ecwd_venue_show_map']) && $_POST['ecwd_venue_show_map'] == '1') ? '1' : 'no';

        $args = array(
            'numberposts' => '-1',
            'post_type' => 'ecwd_event',
            'meta_key' => 'ecwd_event_venue',
            'meta_value' => $venue_id
        );
        $events = get_posts($args);
        if (empty($events)) {
            return false;
        }

        foreach ($events as $event) {
            update_post_meta($event->ID, 'ecwd_event_location', $venue_location);
            update_post_meta($event->ID, 'ecwd_lat_long', $venue_lat_long);
            update_post_meta($event->ID, 'ecwd_event_show_map', $venue_show_map);
        }

    }

    public function add_thumbnails_for_themes() {
        global $ecwd_config;        
        if ($ecwd_config['featured_image_for_themes']['value'] == '1') {            
            add_theme_support('post-thumbnails', array('ecwd_calendar', 'ecwd_organizer', 'ecwd_event', 'ecwd_venue'));
        }
    }

    public function is_events_list_page_title($title, $id = null) {
        if ($id != null && !is_admin() && in_the_loop() && is_archive() && get_post_type() == 'ecwd_event') {
            if (get_option('ecwd_settings_general')) {
                $event_date = get_option('ecwd_settings_general');
                $event_date = isset($event_date['events_date']) ? $event_date['events_date'] : 0;
                if ($event_date == '1') {
                    $post_metas = get_post_meta($id);
                    $ecwd_event_date_from = isset($post_metas['ecwd_event_date_from'][0]) ? $post_metas['ecwd_event_date_from'][0] : '';
                    $ecwd_event_date_to = isset($post_metas['ecwd_event_date_to'][0]) ? $post_metas['ecwd_event_date_to'][0] : '';
                    return $title . "<p class='ecwd_events_date'>" . $ecwd_event_date_from . " - " . $ecwd_event_date_to . "</p>";
                }
            };
        }
        return $title;
    }

    public function duplicate_event_link($actions, $post) {
        if (current_user_can('edit_posts')) {
            if ($post->post_type == self::EVENT_POST_TYPE) {
                $actions['duplicate'] = '<a href="admin.php?action=duplicate_ecwd_post&amp;post=' . $post->ID . '" title="Duplicate this event" rel="permalink">' . __('Duplicate Event', 'event-calendar-wd') . '</a>';
            }
        }

        return $actions;
    }

    public function duplicate_post() {
        global $wpdb;
        if (!( isset($_GET['post']) || isset($_POST['post']) || ( isset($_REQUEST['action']) && 'ecwd_duplicate_post' == $_REQUEST['action'] ) )) {
            wp_die('No post to duplicate has been supplied!');
        }
        /*
         * get the original post id
         */
        $post_id = ( isset($_GET['post']) ? sanitize_text_field($_GET['post']) : sanitize_text_field($_POST['post']) );
        /*
         * and all the original post data then
         */
        $post = get_post($post_id);

        $current_user = wp_get_current_user();
        $new_post_author = $current_user->ID;

        /*
         * if post data exists, create the post duplicate
         */
        if (isset($post) && $post != null) {
            /*
             * new post data array
             */
            $args = array(
                'comment_status' => $post->comment_status,
                'post_type' => $post->post_type,
                'ping_status' => $post->ping_status,
                'post_author' => $new_post_author,
                'post_content' => $post->post_content,
                'post_excerpt' => $post->post_excerpt,
                'post_name' => $post->post_name,
                'post_parent' => $post->post_parent,
                'post_password' => $post->post_password,
                'post_status' => $post->post_status,
                'post_title' => $post->post_title,
                'post_type' => $post->post_type,
                'to_ping' => $post->to_ping,
                'menu_order' => $post->menu_order
            );

            /*
             * insert the post by wp_insert_post() function
             */
            $new_post_id = wp_insert_post($args);


            $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
            foreach ($taxonomies as $taxonomy) {
                $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
            }


            //insert metas
            $metas = get_post_meta($post_id);
            foreach ($metas as $key => $meta_value) {
                if (is_serialized($meta_value[0])) {
                    $meta_value[0] = unserialize($meta_value[0]);
                }
                add_post_meta($new_post_id, $key, $meta_value[0]);
            }

            wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
            exit;
        } else {
            wp_die('Post creation failed, could not find original post: ' . $post_id);
        }
    }

    /**
     * Hide other metaboxes
     * Register SC custom post type
     */
    public function setup_cpt() {
        global $ecwd_options;
        global $ecwd_config;
        $rewrite = false;
        $venue_rewrite = false;
        $organizer_rewrite = false;
        $event_supports = array();
        if (isset($ecwd_options['event_comments']) && $ecwd_options['event_comments'] == 1) {
            $event_supports[] = 'comments';
        }
        if (!isset($ecwd_options['enable_rewrite']) || $ecwd_options['enable_rewrite'] == 1) {
            $defaultSlug = 'event';
            if (is_plugin_active('the-events-calendar/the-events-calendar.php')) {
                $defaultSlug = 'wdevent';
            }
            if (false === get_option(ECWD_PLUGIN_PREFIX . '_slug_changed')) {
                update_option(ECWD_PLUGIN_PREFIX . '_slug_changed', 0);
                update_option(ECWD_PLUGIN_PREFIX . '_single_slug', $defaultSlug);
                update_option(ECWD_PLUGIN_PREFIX . '_slug', $defaultSlug . 's');
            }

            if (( isset($ecwd_options['event_slug']) && $ecwd_options['event_slug'] !== get_option(ECWD_PLUGIN_PREFIX . '_single_slug') ) || ( isset($ecwd_options['events_slug']) && $ecwd_options['events_slug'] !== get_option(ECWD_PLUGIN_PREFIX . '_slug') )) {
                update_option(ECWD_PLUGIN_PREFIX . '_single_slug', $ecwd_options['event_slug']);
                update_option(ECWD_PLUGIN_PREFIX . '_slug', $ecwd_options['events_slug']);
                update_option(ECWD_PLUGIN_PREFIX . '_slug_changed', 1);
            }

            $this->rewriteSlug = ( isset($ecwd_options['events_slug']) && $ecwd_options['events_slug'] !== '' ) ? $ecwd_options['events_slug'] : $defaultSlug . 's';
            $this->rewriteSlugSingular = ( isset($ecwd_options['event_slug']) && $ecwd_options['event_slug'] !== '' ) ? $ecwd_options['event_slug'] : $defaultSlug;
            $rewrite = array(
                'slug' => _x($this->rewriteSlugSingular, 'URL slug', 'event-calendar-wd'),
                "with_front" => true
            );
            $venue_rewrite = array('slug' => _x('venue', 'URL slug', 'event-calendar-wd'), "with_front" => true);
            $organizer_rewrite = array('slug' => _x('organizer', 'URL slug', 'event-calendar-wd'), "with_front" => true);
        }


        /******************************** EVENTS ********************************/

        $show_events_tab = (get_option('ecwd_subscribe_done') === '1');

        $labels = array(
          'name' => __('Events', 'event-calendar-wd'),
          'singular_name' => __('Event', 'event-calendar-wd'),
          'name_admin_bar' => __('Event', 'event-calendar-wd'),
          'add_new' => __('Add New Event', 'event-calendar-wd'),
          'add_new_item' => __('Add New Event', 'event-calendar-wd'),
          'new_item' => __('New Event', 'event-calendar-wd'),
          'edit_item' => __('Edit Event', 'event-calendar-wd'),
          'view_item' => __('View Event', 'event-calendar-wd'),
          'all_items' => __('Events', 'event-calendar-wd'),
          'search_items' => __('Search Event', 'event-calendar-wd'),
          'not_found' => __('No events found.', 'event-calendar-wd'),
          'not_found_in_trash' => __('No events found in Trash.', 'event-calendar-wd')
        );

        $args = array(
          'labels' => $labels,
          'public' => true,
          'publicly_queryable' => true,
          'show_ui' => true,
          'show_in_menu' => $show_events_tab,
          'menu_position' => '27,11',
          'query_var' => true,
          'capability_type' => 'post',
          'taxonomies' => array(
            ECWD_PLUGIN_PREFIX . '_event_category',
            ECWD_PLUGIN_PREFIX . '_event_tag',
            'calendars',
            'organizers'
          ),
          'has_archive' => true,
          'hierarchical' => false,
          'menu_icon' => plugins_url('/assets/Insert-icon.png', ECWD_MAIN_FILE),
          'supports' => array_merge(array(
            'title',
            'editor',
            'thumbnail'
          ), $event_supports),
          'rewrite' => $rewrite
        );

        register_post_type(self::EVENT_POST_TYPE, $args);


        /******************************** ORGANIZERS ********************************/

        $organizers_labels = array(
          'name' => __('Organizers', 'event-calendar-wd'),
          'singular_name' => __('Organizer', 'event-calendar-wd'),
          'name_admin_bar' => __('Organizer', 'event-calendar-wd'),
          'add_new' => __('Add New', 'event-calendar-wd'),
          'add_new_item' => __('Add New Organizer', 'event-calendar-wd'),
          'new_item' => __('New Organizer', 'event-calendar-wd'),
          'edit_item' => __('Edit Organizer', 'event-calendar-wd'),
          'view_item' => __('View Organizer', 'event-calendar-wd'),
          'all_items' => __('Organizers', 'event-calendar-wd'),
          'search_items' => __('Search Organizer', 'event-calendar-wd'),
          'not_found' => __('No Organizers found.', 'event-calendar-wd'),
          'not_found_in_trash' => __('No Organizers found in Trash.', 'event-calendar-wd')
        );

        $organizers_args = array(
          'labels' => $organizers_labels,
          'public' => true,
          'publicly_queryable' => true,
          'show_ui' => true,
          'show_in_menu' => ECWD_MENU_SLUG,
          'query_var' => true,
          'capability_type' => 'post',
          'taxonomies' => array(),
          'has_archive' => true,
          'hierarchical' => true,
          'menu_icon' => plugins_url('/assets/organizer-icon.png', ECWD_MAIN_FILE),
          'supports' => array(
            'title',
            'editor',
            'thumbnail'
          ),
          'rewrite' => $organizer_rewrite
        );

        register_post_type(self::ORGANIZER_POST_TYPE, $organizers_args);


        /******************************** VENUES ********************************/

        $venues_labels = array(
          'name' => __('Venues', 'event-calendar-wd'),
          'singular_name' => __('Venue', 'event-calendar-wd'),
          'name_admin_bar' => __('Venue', 'event-calendar-wd'),
          'add_new' => __('Add New', 'event-calendar-wd'),
          'add_new_item' => __('Add New Venue', 'event-calendar-wd'),
          'new_item' => __('New Venue', 'event-calendar-wd'),
          'edit_item' => __('Edit Venue', 'event-calendar-wd'),
          'view_item' => __('View Venue', 'event-calendar-wd'),
          'all_items' => __('Venues', 'event-calendar-wd'),
          'search_items' => __('Search Venue', 'event-calendar-wd'),
          'not_found' => __('No Venues found.', 'event-calendar-wd'),
          'not_found_in_trash' => __('No Venues found in Trash.', 'event-calendar-wd')
        );

        $venues_args = array(
          'labels' => $venues_labels,
          'public' => true,
          'publicly_queryable' => true,
          'show_ui' => true,
          'show_in_menu' => ECWD_MENU_SLUG,
          'query_var' => true,
          'capability_type' => 'post',
          'taxonomies' => array(),
          'has_archive' => true,
          'hierarchical' => true,
          'menu_icon' => plugins_url('/assets/venue-icon.png', ECWD_MAIN_FILE),
          'supports' => array(
            'title',
            'editor',
            'thumbnail'
          ),
          'rewrite' => $venue_rewrite
        );

        register_post_type(self::VENUE_POST_TYPE, $venues_args);


        /******************************** CALENDAR ********************************/

        $calendar_labels = array(
          'name' => __('Calendars', 'event-calendar-wd'),
          'singular_name' => __('Calendar', 'event-calendar-wd'),
          'menu_name' => __('Calendars', 'event-calendar-wd'),
          'name_admin_bar' => __('Calendar', 'event-calendar-wd'),
          'add_new' => __('Add New Calendar', 'event-calendar-wd'),
          'add_new_item' => __('Add New Calendar', 'event-calendar-wd'),
          'new_item' => __('New Calendar', 'event-calendar-wd'),
          'edit_item' => __('Edit Calendar', 'event-calendar-wd'),
          'view_item' => __('View Calendar', 'event-calendar-wd'),
          'all_items' => __('Calendars', 'event-calendar-wd'),
          'search_items' => __('Search Calendar', 'event-calendar-wd'),
          'not_found' => __('No Calendars found.', 'event-calendar-wd'),
          'not_found_in_trash' => __('No Calendars found in Trash.', 'event-calendar-wd')
        );

        $calendar_args = array(
          'labels' => $calendar_labels,
          'public' => true,
          'publicly_queryable' => true,
          'show_ui' => true,
          'show_in_menu' => ECWD_MENU_SLUG,
          'query_var' => true,
          'capability_type' => 'post',
          'has_archive' => false,
          'hierarchical' => false,
          'menu_icon' => plugins_url('/assets/Insert-icon.png', ECWD_MAIN_FILE),
          'supports' => array(
            'title',
            'editor',
            'custom-fields'
          )
        );

        register_post_type(self::CALENDAR_POST_TYPE, $calendar_args);

        if ($ecwd_config['flush_rewrite_rules']['value'] == '1') {            
            flush_rewrite_rules();
        }
        if (false === get_option(ECWD_PLUGIN_PREFIX . '_cpt_setup') || 1 == get_option(ECWD_PLUGIN_PREFIX . '_slug_changed')) {
            update_option(ECWD_PLUGIN_PREFIX . '_cpt_setup', 1);
            update_option(ECWD_PLUGIN_PREFIX . '_slug_changed', 0);
            if ($ecwd_config['flush_rewrite_rules']['value'] == '1') {
                flush_rewrite_rules();
            }
        }
    }

    public function add_custom_post_type_to_query($query) {
        if (is_admin() || !$query->is_main_query()) {
            return;
        }
        global $ecwd_options;
        if (isset($ecwd_options['event_loop']) && $ecwd_options['event_loop'] == 1) {

            if ($query->is_home() && $query->is_main_query()) {
                $query->set('post_type', array('post', self::EVENT_POST_TYPE));
            }
        }
    }

    public function ecwdEventQueryVars($qvars) {
        $qvars[] = 'eventDate';
        $qvars[] = self::EVENT_POST_TYPE;

        return $qvars;
    }

    public function filterRewriteRules($wp_rewrite) {
        global $ecwd_options;
        if (!isset($ecwd_options['enable_rewrite']) || $ecwd_options['enable_rewrite'] == 1) {
            if (!$this->rewriteSlugSingular || $this->rewriteSlugSingular == '') {
                $defaultSlug = 'event';
                if (is_plugin_active('the-events-calendar/the-events-calendar.php')) {
                    $defaultSlug = 'wdevent';
                }

                $this->rewriteSlug = ( isset($ecwd_options['events_slug']) && $ecwd_options['events_slug'] !== '' ) ? $ecwd_options['events_slug'] : $defaultSlug . 's';
                $this->rewriteSlugSingular = ( isset($ecwd_options['event_slug']) && $ecwd_options['event_slug'] !== '' ) ? $ecwd_options['event_slug'] : $defaultSlug;
            }

            $base = trailingslashit($this->rewriteSlug);
            $singleBase = trailingslashit($this->rewriteSlugSingular);
            $rewrite_arr = explode('/', $wp_rewrite->permalink_structure);
            $rewritebase = '';
            for ($i = 1; $i < count($rewrite_arr); $i++) {
                if (isset($rewrite_arr[$i]) && strpos($rewrite_arr[$i], '%') === FALSE) {
                    $rewritebase = $rewritebase . $rewrite_arr[$i] . '/';
                } else {
                    break;
                }
            }
            $base = $rewritebase . $base;
            $singleBase = $rewritebase . $singleBase;
            $newRules = array();
            // single event
            $newRules[$singleBase . '([^/]+)/(\d{4}-\d{2}-\d{2})/?$'] = 'index.php?' . self::EVENT_POST_TYPE . '=' . $wp_rewrite->preg_index(1) . "&eventDate=" . $wp_rewrite->preg_index(2);
            $newRules[$singleBase . '([^/]+)/all/?$'] = 'index.php?post_type=' . self::EVENT_POST_TYPE . '&' . self::EVENT_POST_TYPE . '=' . $wp_rewrite->preg_index(1) . "&eventDisplay=all";
            $newRules[$base . 'page/(\d+)'] = 'index.php?post_type=' . self::EVENT_POST_TYPE . '&eventDisplay=list&paged=' . $wp_rewrite->preg_index(1);
            $newRules[$base . '(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?post_type=' . self::EVENT_POST_TYPE . '&eventDisplay=list&feed=' . $wp_rewrite->preg_index(1);
            $newRules[$base . '(\d{4}-\d{2})$'] = 'index.php?post_type=' . self::EVENT_POST_TYPE . '&eventDisplay=month' . '&eventDate=' . $wp_rewrite->preg_index(1);
            $newRules[$base . '(\d{4}-\d{2}-\d{2})/?$'] = 'index.php?post_type=' . self::EVENT_POST_TYPE . '&eventDisplay=day&eventDate=' . $wp_rewrite->preg_index(1);
            $newRules[$base . 'feed/?$'] = 'index.php?post_type=' . self::EVENT_POST_TYPE . 'eventDisplay=list&&feed=rss2';
            $newRules[$base . '?$'] = 'index.php?post_type=' . self::EVENT_POST_TYPE . '&eventDisplay=default';

            $wp_rewrite->rules = apply_filters(ECWD_PLUGIN_PREFIX . '_events_rewrite_rules', $newRules + $wp_rewrite->rules, $newRules);
        }
    }

    /**
     * Messages for Calendar actions
     */
    public function calendar_messages($messages) {
        global $post, $post_ID;

        $url1 = '<a href="' . get_permalink($post_ID) . '">';
        $url2 = __('calendar', 'event-calendar-wd');
        $url3 = '</a>';
        $s1 = __('Calendar', 'event-calendar-wd');

        $messages[ECWD_PLUGIN_PREFIX . '_calendar'] = array(
            1 => sprintf(__('%4$s updated.', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            4 => sprintf(__('%4$s updated. ', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            6 => sprintf(__('%4$s published.', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            7 => sprintf(__('%4$s saved.', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            8 => sprintf(__('%4$s submitted. ', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            10 => sprintf(__('%4$s draft updated.', 'event-calendar-wd'), $url1, $url2, $url3, $s1)
        );
        if ($post->post_type == ECWD_PLUGIN_PREFIX . '_calendar') {

            $notices = get_option(ECWD_PLUGIN_PREFIX . '_not_writable_warning');
            if (empty($notices)) {
                return $messages;
            }
            foreach ($notices as $post_id => $mm) {
                if ($post->ID == $post_id) {
                    $notice = '';
                    foreach ($mm as $key) {
                        $notice = $notice . ' <p style="color:red;">' . $key . '</p> ';
                    }
                    foreach ($messages[ECWD_PLUGIN_PREFIX . '_calendar'] as $i => $message) {
                        $messages[ECWD_PLUGIN_PREFIX . '_calendar'][$i] = $message . $notice;
                    }
                    unset($notices[$post_id]);
                    update_option(ECWD_PLUGIN_PREFIX . '_not_writable_warning', $notices);
                    break;
                }
            }
        }

        return $messages;
    }

    public function theme_messages($messages) {
        global $post, $post_ID;

        $url1 = '<a href="' . get_permalink($post_ID) . '">';
        $url2 = __('Theme', 'event-calendar-wd');
        $url3 = '</a>';
        $s1 = __('Theme', 'event-calendar-wd');

        $messages[ECWD_PLUGIN_PREFIX . '_theme'] = array(
            1 => sprintf(__('%4$s updated.', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            4 => sprintf(__('%4$s updated. ', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            6 => sprintf(__('%4$s published.', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            7 => sprintf(__('%4$s saved.', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            8 => sprintf(__('%4$s submitted. ', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            10 => sprintf(__('%4$s draft updated.', 'event-calendar-wd'), $url1, $url2, $url3, $s1)
        );

        if ($post->post_type == ECWD_PLUGIN_PREFIX . '_theme') {
            $notices = get_option(ECWD_PLUGIN_PREFIX . '_not_writable_warning');

            if (empty($notices)) {
                return $messages;
            }

            foreach ($notices as $post_id => $mm) {

                if ($post->ID == $post_id) {
                    $notice = '';

                    foreach ($mm as $key) {


                        $notice = $notice . ' <p style="color:red;">' . $key . '</p> ';
                    }
                    foreach ($messages[ECWD_PLUGIN_PREFIX . '_theme'] as $i => $message) {
                        $messages[ECWD_PLUGIN_PREFIX . '_theme'][$i] = $message . $notice;
                    }
                    unset($notices[$post_id]);
                    update_option(ECWD_PLUGIN_PREFIX . '_not_writable_warning', $notices);
                    break;
                }
            }
        }

        return $messages;
    }

    /**
     * Messages for Event actions
     */
    public function event_messages($messages) {
        global $post, $post_ID;

        $url1 = '<a href="' . get_permalink($post_ID) . '">';
        $url2 = __('event', 'event-calendar-wd');
        $url3 = '</a>';
        $s1 = __('Event', 'event-calendar-wd');

        $messages[ECWD_PLUGIN_PREFIX . '_event'] = array(
            1 => sprintf(__('%4$s updated. %1$sView %2$s%3$s', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            4 => sprintf(__('%4$s updated. %1$sView %2$s%3$s', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            6 => sprintf(__('%4$s published. %1$sView %2$s%3$s', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            7 => sprintf(__('%4$s saved. %1$sView %2$s%3$s', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            8 => sprintf(__('%4$s submitted. %1$sView %2$s%3$s', 'event-calendar-wd'), $url1, $url2, $url3, $s1),
            10 => sprintf(__('%4$s draft updated. %1$sView %2$s%3$s', 'event-calendar-wd'), $url1, $url2, $url3, $s1)
        );

        return $messages;
    }

    /**
     * Add Events post meta
     */
    public function calendars_cpt_meta($screen = null, $context = 'advanced') {
        add_meta_box(ECWD_PLUGIN_PREFIX . '_calendar_meta', __('Calendar Settings', 'event-calendar-wd'), array(
            $this,
            'display_calendars_meta'
                ), ECWD_PLUGIN_PREFIX . '_calendar', 'normal', 'high');
    }

    /**
     * Display Events post meta
     */
    public function display_calendars_meta($post) {
        $args = array(
            'numberposts' => - 1,
            'post_type' => self::EVENT_POST_TYPE,
            'meta_query' => array(
                array(
                    'key' => ECWD_PLUGIN_PREFIX . '_event_calendars',
                    'value' => serialize(strval($post->ID)),
                    'compare' => 'LIKE'
                ),
                'meta_key' => ECWD_PLUGIN_PREFIX . '_event_date_from',
                'orderby' => 'meta_value',
                'order' => 'ASC'
            )
        );
        $events = get_posts($args);

      if(current_user_can('read_private_posts')) {
        $private_args = $args;
        $private_args['post_status'] = array('private');
        $private_events = get_posts($private_args);
        if(!empty($private_events)) {
          foreach($private_events as $private_event) {
            $events[] = $private_event;
          }
        }
      }


      $args = array(
            'numberposts' => - 1,
            'post_type' => self::EVENT_POST_TYPE,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => ECWD_PLUGIN_PREFIX . '_event_calendars',
                    'value' => serialize(strval($post->ID)),
                    'compare' => 'NOT LIKE'
                ),
                array(
                    'key' => ECWD_PLUGIN_PREFIX . '_event_calendars',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => ECWD_PLUGIN_PREFIX . '_event_calendars',
                    'value' => '',
                ),
                'meta_key' => ECWD_PLUGIN_PREFIX . '_event_date_from',
                'orderby' => 'meta_value',
                'order' => 'ASC'
            )
        );
        $excluded_events = get_posts($args);

      if(current_user_can('read_private_posts')) {
        $private_args = $args;
        $private_args['post_status'] = array('private');
        $private_events = get_posts($private_args);
        if(!empty($private_events)) {
          foreach($private_events as $private_event) {
            $excluded_events[] = $private_event;
          }
        }
      }


      $args = array(
            'numberposts' => - 1,
            'post_type' => ECWD_PLUGIN_PREFIX . '_theme'
        );
        $themes = get_posts($args);
        include_once( ECWD_DIR . '/views/admin/ecwd-calendar-meta.php' );
        do_action(ECWD_PLUGIN_PREFIX . '_gcal');
        do_action(ECWD_PLUGIN_PREFIX . '_fb');
        do_action(ECWD_PLUGIN_PREFIX . '_ical');
    }

    /**
     * Add Events post meta
     */
    public function events_cpt_meta($screen = null, $context = 'advanced') {

      global $post;
      if(!empty($post->post_type) && $post->post_type === "ecwd_event"){
        include_once 'events/ecwd-single-event.php';
        $this->single_event_for_metas = new ecwd_single_event($post->ID, $post->title, $post->post_title, $post->post_content);
        $this->single_event_for_metas->post = $post;
        $this->single_event_for_metas->set_metas();
      }


      add_meta_box(ECWD_PLUGIN_PREFIX . '_event_meta', __('Event Details', 'event-calendar-wd'), array(
          $this,
          'display_events_meta'
        ), ECWD_PLUGIN_PREFIX . '_event', 'normal', 'high');

        add_meta_box(ECWD_PLUGIN_PREFIX . '_event_calendars_meta', __('Calendars', 'event-calendar-wd'), array(
            $this,
            'display_events_calendars_meta'
                ), ECWD_PLUGIN_PREFIX . '_event', 'normal', 'high');

        add_meta_box(ECWD_PLUGIN_PREFIX . '_event_venue_meta', __('Venue', 'event-calendar-wd'), array(
          $this,
          'display_events_venue_meta'
        ), ECWD_PLUGIN_PREFIX . '_event', 'normal', 'high');

        add_meta_box(ECWD_PLUGIN_PREFIX . '_event_organizers_meta', __('Organizers', 'event-calendar-wd'), array(
            $this,
            'display_events_organizers_meta'
                ), ECWD_PLUGIN_PREFIX . '_event', 'normal', 'high');

        if (current_theme_supports('post-thumbnails', 'post') && post_type_supports('post', 'thumbnail')) {
            add_meta_box('postimagediv', __('Featured Image','event-calendar-wd'), 'post_thumbnail_meta_box', null, 'side', 'low');
        }
    }

    /**
     * Display Events post meta
     */
    public function display_events_meta() {
        $is_ = $this->is();
        include_once( ECWD_DIR . '/views/admin/ecwd-event-meta.php' );
    }

    /**
     * Display Events post meta
     */
    public function display_events_calendars_meta() {
        include_once( ECWD_DIR . '/views/admin/ecwd-event-calendars-meta.php' );
    }

    public function display_events_venue_meta() {
        include_once( ECWD_DIR . '/views/admin/ecwd-event-venues-meta.php' );
    }

    public function display_events_organizers_meta() {
        include_once( ECWD_DIR . '/views/admin/ecwd-event-organizers-meta.php' );
    }

    /**
     * Add Themes post meta
     */
    public function themes_cpt_meta() {
        add_meta_box(ECWD_PLUGIN_PREFIX . '_theme_meta', __('Calendar Theme Settings', 'event-calendar-wd'), array(
            $this,
            'display_theme_meta'
                ), ECWD_PLUGIN_PREFIX . '_theme', 'normal', 'high');
    }

    /**
     * Display Theme post meta
     */
    public function display_theme_meta() {
        global $post;
        $post_id = $post->ID;
        $default_theme = array(
            //general
            ECWD_PLUGIN_PREFIX . '_width' => '100%',
            ECWD_PLUGIN_PREFIX . '_cal_border_color' => '',
            ECWD_PLUGIN_PREFIX . '_cal_border_width' => '',
            ECWD_PLUGIN_PREFIX . '_cal_border_radius' => '',
            //header
            ECWD_PLUGIN_PREFIX . '_cal_header_color' => '#168fb5',
            ECWD_PLUGIN_PREFIX . '_cal_header_border_color' => '#91CEDF',
            ECWD_PLUGIN_PREFIX . '_current_year_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_current_year_font_size' => 28,
            ECWD_PLUGIN_PREFIX . '_current_month_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_current_month_font_size' => 16,
            ECWD_PLUGIN_PREFIX . '_next_prev_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_next_prev_font_size' => 18,
            //views
            ECWD_PLUGIN_PREFIX . '_view_tabs_bg_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_view_tabs_border_color' => '#91CEDF',
            ECWD_PLUGIN_PREFIX . '_view_tabs_current_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_view_tabs_text_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_view_tabs_font_size' => 16,
            ECWD_PLUGIN_PREFIX . '_view_tabs_current_text_color' => '#10738B',
            //search
            ECWD_PLUGIN_PREFIX . '_search_bg_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_search_icon_color' => '#ffffff',
            //filter
            ECWD_PLUGIN_PREFIX . '_filter_header_bg_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_filter_header_left_bg_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_filter_header_text_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_filter_header_left_text_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_filter_bg_color' => '#ECECEC',
            ECWD_PLUGIN_PREFIX . '_filter_border_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_filter_arrow_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_filter_reset_text_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_filter_reset_font_size' => 15,
            ECWD_PLUGIN_PREFIX . '_filter_text_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_filter_font_size' => 16,
            ECWD_PLUGIN_PREFIX . '_filter_item_bg_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_filter_item_border_color' => '#DEE3E8',
            ECWD_PLUGIN_PREFIX . '_filter_item_text_color' => '#6E6E6E',
            ECWD_PLUGIN_PREFIX . '_filter_item_font_size' => 15,
            //week days
            ECWD_PLUGIN_PREFIX . '_week_days_bg_color' => '#F9F9F9',
            ECWD_PLUGIN_PREFIX . '_week_days_border_color' => '#B6B6B6',
            ECWD_PLUGIN_PREFIX . '_week_days_text_color' => '#585858',
            ECWD_PLUGIN_PREFIX . '_week_days_font_size' => 17,
            //days
            ECWD_PLUGIN_PREFIX . '_cell_bg_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_cell_weekend_bg_color' => '#EDEDED',
            ECWD_PLUGIN_PREFIX . '_cell_prev_next_bg_color' => '#F9F9F9',
            ECWD_PLUGIN_PREFIX . '_cell_border_color' => '#B6B6B6',
            ECWD_PLUGIN_PREFIX . '_day_number_bg_color' => '#E0E0E0',
            ECWD_PLUGIN_PREFIX . '_day_text_color' => '#5C5C5C',
            ECWD_PLUGIN_PREFIX . '_day_font_size' => 14,
            ECWD_PLUGIN_PREFIX . '_current_day_cell_bg_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_current_day_number_bg_color' => '#0071A0',
            ECWD_PLUGIN_PREFIX . '_current_day_text_color' => '#ffffff',
            //events
            ECWD_PLUGIN_PREFIX . '_event_title_color' => '',
            ECWD_PLUGIN_PREFIX . '_event_title_font_size' => 18,
            ECWD_PLUGIN_PREFIX . '_event_details_bg_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_event_details_border_color' => '#bfbfbf',
            ECWD_PLUGIN_PREFIX . '_event_details_text_color' => '#000000',
            //ECWD_PLUGIN_PREFIX . '_event_details_font_size',
            //events list view
            ECWD_PLUGIN_PREFIX . '_event_list_view_date_bg_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_event_list_view_date_text_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_event_list_view_date_font_size' => 15,
            //posterboard
            ECWD_PLUGIN_PREFIX . '_event_posterboard_view_date_bg_color' => '#585858',
            ECWD_PLUGIN_PREFIX . '_event_posterboard_view_date_text_color' => '#ffffff',
            //pagination
            ECWD_PLUGIN_PREFIX . '_page_numbers_bg_color' => '#ffffff',
            ECWD_PLUGIN_PREFIX . '_current_page_bg_color' => '#10738B',
            ECWD_PLUGIN_PREFIX . '_page_number_color' => '#A5A5A5',
        );

        if (isset($_REQUEST['theme']) && $_REQUEST['theme'] == 'reset') {
            $data = json_encode($default_theme);
            update_post_meta($post_id, self::THEME_POST_TYPE . '_params', $data);
            //wp_redirect('post.php?post='.$post_id.'&action=edit');
        }

        include_once( ECWD_DIR . '/views/admin/ecwd-theme-meta.php' );
    }

    /**
     * Add Themes post meta
     */
    public function venues_cpt_meta() {

        add_meta_box(
          ECWD_PLUGIN_PREFIX . '_venue_meta',
          __('Venue Details', 'event-calendar-wd'),
          array($this, 'display_venue_meta'),
          ECWD_PLUGIN_PREFIX . '_venue',
          'normal',
          'high'
        );

    }


    public function organizers_cpt_meta() {
        add_meta_box(
          ECWD_PLUGIN_PREFIX . '_organizer_meta',
          __('Organizer Details', 'event-calendar-wd'),
          array($this, 'display_organizer_meta'),
          ECWD_PLUGIN_PREFIX . '_organizer',
          'normal',
          'high'
        );

    }


    /**
     * Display Theme post meta
     */
    public function display_venue_meta() {
        $ip_addr = $_SERVER['REMOTE_ADDR'];
        $lat = '';
        $long = '';

        include_once( ECWD_DIR . '/views/admin/ecwd-venue-meta.php' );
    }

    public function display_organizer_meta(){
        include_once( ECWD_DIR . '/views/admin/ecwd-organizer-meta.php' );
    }


    //order orgs and venues by post name
    function ecwd_archive_order($vars) {
        global $ecwd_options;
        if(isset($ecwd_options['cpt_order']) && $ecwd_options['cpt_order'] !== 'post_name'){
			$orderby = $ecwd_options['cpt_order'];
		}else{
			$orderby = 'post_title';
		}

        $types = array(self::ORGANIZER_POST_TYPE, self::VENUE_POST_TYPE);
        if (!is_admin() && isset($vars['post_type']) && is_post_type_hierarchical($vars['post_type']) && in_array($vars['post_type'], $types)) {
            $vars['orderby'] = $orderby;
            $vars['order'] = 'ASC';
        }

        return $vars;
    }

    public function save_events() {
        $status = 'error';
        if (isset($_POST[ECWD_PLUGIN_PREFIX . '_event_id']) && isset($_POST[ECWD_PLUGIN_PREFIX . '_calendar_id']) && isset($_POST[ECWD_PLUGIN_PREFIX . '_action'])) {
            $event_id = esc_attr($_POST[ECWD_PLUGIN_PREFIX . '_event_id']);
            $calendar_id = esc_attr($_POST[ECWD_PLUGIN_PREFIX . '_calendar_id']);
            $event_calendars = get_post_meta($event_id, ECWD_PLUGIN_PREFIX . '_event_calendars', true);
            if (!$event_calendars) {
                $event_calendars = array();
            }
            if ($_POST[ECWD_PLUGIN_PREFIX . '_action'] == 'delete') {
                if (is_array($event_calendars) && in_array($calendar_id, $event_calendars)) {
                    unset($event_calendars[array_search($calendar_id, $event_calendars)]);
                    $status = 'ok';
                }
            } elseif (esc_attr($_POST[ECWD_PLUGIN_PREFIX . '_action']) == 'add') {
                if (is_array($event_calendars) && !in_array($calendar_id, $event_calendars)) {
                    $event_calendars[] = $calendar_id;
                    $status = 'ok';
                }
            }
            update_post_meta($event_id, ECWD_PLUGIN_PREFIX . '_event_calendars', $event_calendars);
        }
        echo json_encode(array('status' => $status));
        wp_die();
    }

    public function add_event() {
        $status = 'error';
        $data = '';
        if (isset($_POST[ECWD_PLUGIN_PREFIX . '_calendar_id'])) {
            $calendar_id = esc_attr($_POST[ECWD_PLUGIN_PREFIX . '_calendar_id']);
            $new_event = array(
                'post_type' => ECWD_PLUGIN_PREFIX . '_event',
                'post_title' => esc_attr($_POST[ECWD_PLUGIN_PREFIX . '_event_name']),
				'post_status'   => 'publish'
            );
            $new_event_id = wp_insert_post($new_event);
            if ($new_event_id) {
                $from = date("Y/m/d", strtotime(esc_attr($_POST[ECWD_PLUGIN_PREFIX . '_event_date_from'])));
                $to = date("Y/m/d", strtotime(esc_attr($_POST[ECWD_PLUGIN_PREFIX . '_event_date_to'])));
                update_post_meta($new_event_id, ECWD_PLUGIN_PREFIX . '_event_date_from', $from);
                update_post_meta($new_event_id, ECWD_PLUGIN_PREFIX . '_event_date_to', $to);
                update_post_meta($new_event_id, ECWD_PLUGIN_PREFIX . '_event_calendars', array($calendar_id));
                $status = 'success';
                $data = array('event_id' => $new_event_id);
            }
        }
        echo json_encode(array('status' => $status, 'data' => $data));
        wp_die();
    }

    /**
     * Function to save post meta for the event CPT
     */
    public function save_meta($post_id, $post, $post_before) {
        if (( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || ( defined('DOING_AJAX') && DOING_AJAX )) {
            return $post_id;
        }
        if (isset($_REQUEST['bulk_edit'])) {
            return $post_id;
        }
        if (wp_is_post_revision($post_id)) {
            return $post_id;
        }

        if($post->post_status === "trash" || $post_before->post_status === "trash"){
            return $post_id;
        }


      $types = array(
            ECWD_PLUGIN_PREFIX . '_calendar',
            ECWD_PLUGIN_PREFIX . '_event',
            ECWD_PLUGIN_PREFIX . '_theme',
            ECWD_PLUGIN_PREFIX . '_venue',
            ECWD_PLUGIN_PREFIX . '_organizer'
        );

        // If this isn't a  post, don't update it.
        if (!in_array($post->post_type, $types)) {
            return $post_id;
        }
        $post_type = get_post_type($post_id);

        if ($post_type == "ecwd_event") {

            if($_POST['ecwd_event_venue'] == 'new'){
                $_POST['ecwd_event_venue'] = '0';
            }

            if(!isset($_POST['ecwd_event_venue']) || $_POST['ecwd_event_venue'] == '0' && $_POST['ecwd_event_venue'] == 'new'){
                $_POST['ecwd_event_location'] = "";
                $_POST['ecwd_lat_long'] = "40.712784,-74.005941";
                $_POST['ecwd_event_show_map'] = 'no';
                $_POST['ecwd_map_zoom'] = 17;
            }else{
                $_POST['ecwd_event_location'] = get_post_meta($_POST['ecwd_event_venue'], 'ecwd_venue_location', true);
                $_POST['ecwd_lat_long'] = get_post_meta($_POST['ecwd_event_venue'], 'ecwd_venue_lat_long', true);
                $_POST['ecwd_event_show_map'] = get_post_meta($_POST['ecwd_event_venue'], 'ecwd_venue_show_map', true);
                $_POST['ecwd_map_zoom'] = get_post_meta($_POST['ecwd_event_venue'], 'ecwd_map_zoom', true);
            }
        }



        $ecwd_post_meta_fields[ECWD_PLUGIN_PREFIX . '_calendar'] = array(
            ECWD_PLUGIN_PREFIX . '_calendar_description',
            ECWD_PLUGIN_PREFIX . '_calendar_id',
            ECWD_PLUGIN_PREFIX . '_calendar_default_year',
            ECWD_PLUGIN_PREFIX . '_calendar_default_month',
            ECWD_PLUGIN_PREFIX . '_calendar_12_hour_time_format',
            ECWD_PLUGIN_PREFIX . '_calendar_theme',
            ECWD_PLUGIN_PREFIX . '_facebook_page_id',
            ECWD_PLUGIN_PREFIX . '_facebook_access_token',
            ECWD_PLUGIN_PREFIX . '_calendar_ical',
        );
        $ecwd_post_meta_fields[ECWD_PLUGIN_PREFIX . '_event'] = array(
            ECWD_PLUGIN_PREFIX . '_event_location',
            ECWD_PLUGIN_PREFIX . '_event_venue',
            ECWD_PLUGIN_PREFIX . '_lat_long',
            ECWD_PLUGIN_PREFIX . '_event_show_map',
            ECWD_PLUGIN_PREFIX . '_map_zoom',
            ECWD_PLUGIN_PREFIX . '_event_date_from',
            ECWD_PLUGIN_PREFIX . '_event_date_to',
            ECWD_PLUGIN_PREFIX . '_event_url',
            ECWD_PLUGIN_PREFIX . '_event_calendars',
            ECWD_PLUGIN_PREFIX . '_event_organizers',
            ECWD_PLUGIN_PREFIX . '_event_repeat_event',
            ECWD_PLUGIN_PREFIX . '_event_day',
            ECWD_PLUGIN_PREFIX . '_all_day_event',
            ECWD_PLUGIN_PREFIX . '_event_repeat_how',
            ECWD_PLUGIN_PREFIX . '_event_repeat_month_on_days',
            ECWD_PLUGIN_PREFIX . '_event_repeat_year_on_days',
            ECWD_PLUGIN_PREFIX . '_event_repeat_on_the_m',
            ECWD_PLUGIN_PREFIX . '_event_repeat_on_the_y',
            ECWD_PLUGIN_PREFIX . '_monthly_list_monthly',
            ECWD_PLUGIN_PREFIX . '_monthly_week_monthly',
            ECWD_PLUGIN_PREFIX . '_monthly_list_yearly',
            ECWD_PLUGIN_PREFIX . '_monthly_week_yearly',
            ECWD_PLUGIN_PREFIX . '_event_repeat_repeat_until',
            ECWD_PLUGIN_PREFIX . '_event_year_month',
            ECWD_PLUGIN_PREFIX . '_event_video',
        );

        $ecwd_post_meta_fields[ECWD_PLUGIN_PREFIX . '_theme'] = array(
            //general
            ECWD_PLUGIN_PREFIX . '_width',
            ECWD_PLUGIN_PREFIX . '_cal_border_color',
            ECWD_PLUGIN_PREFIX . '_cal_border_width',
            ECWD_PLUGIN_PREFIX . '_cal_border_radius',
            //header
            ECWD_PLUGIN_PREFIX . '_cal_header_color',
            ECWD_PLUGIN_PREFIX . '_cal_header_border_color',
            ECWD_PLUGIN_PREFIX . '_current_year_color',
            ECWD_PLUGIN_PREFIX . '_current_year_font_size',
            ECWD_PLUGIN_PREFIX . '_current_month_color',
            ECWD_PLUGIN_PREFIX . '_current_month_font_size',
            ECWD_PLUGIN_PREFIX . '_next_prev_color',
            ECWD_PLUGIN_PREFIX . '_next_prev_font_size',
            //views
            ECWD_PLUGIN_PREFIX . '_view_tabs_bg_color',
            ECWD_PLUGIN_PREFIX . '_view_tabs_border_color',
            ECWD_PLUGIN_PREFIX . '_view_tabs_current_color',
            ECWD_PLUGIN_PREFIX . '_view_tabs_text_color',
            ECWD_PLUGIN_PREFIX . '_view_tabs_font_size',
            ECWD_PLUGIN_PREFIX . '_view_tabs_current_text_color',
            //search
            ECWD_PLUGIN_PREFIX . '_search_bg_color',
            ECWD_PLUGIN_PREFIX . '_search_icon_color',
            //filter
            ECWD_PLUGIN_PREFIX . '_filter_header_bg_color',
            ECWD_PLUGIN_PREFIX . '_filter_header_left_bg_color',
            ECWD_PLUGIN_PREFIX . '_filter_header_text_color',
            ECWD_PLUGIN_PREFIX . '_filter_header_left_text_color',
            ECWD_PLUGIN_PREFIX . '_filter_bg_color',
            ECWD_PLUGIN_PREFIX . '_filter_border_color',
            ECWD_PLUGIN_PREFIX . '_filter_arrow_color',
            ECWD_PLUGIN_PREFIX . '_filter_reset_text_color',
            ECWD_PLUGIN_PREFIX . '_filter_reset_font_size',
            ECWD_PLUGIN_PREFIX . '_filter_text_color',
            ECWD_PLUGIN_PREFIX . '_filter_font_size',
            ECWD_PLUGIN_PREFIX . '_filter_item_bg_color',
            ECWD_PLUGIN_PREFIX . '_filter_item_border_color',
            ECWD_PLUGIN_PREFIX . '_filter_item_text_color',
            ECWD_PLUGIN_PREFIX . '_filter_item_font_size',
            //week days
            ECWD_PLUGIN_PREFIX . '_week_days_bg_color',
            ECWD_PLUGIN_PREFIX . '_week_days_border_color',
            ECWD_PLUGIN_PREFIX . '_week_days_text_color',
            ECWD_PLUGIN_PREFIX . '_week_days_font_size',
            //days
            ECWD_PLUGIN_PREFIX . '_cell_bg_color',
            ECWD_PLUGIN_PREFIX . '_cell_weekend_bg_color',
            ECWD_PLUGIN_PREFIX . '_cell_prev_next_bg_color',
            ECWD_PLUGIN_PREFIX . '_cell_border_color',
            ECWD_PLUGIN_PREFIX . '_day_number_bg_color',
            ECWD_PLUGIN_PREFIX . '_day_text_color',
            ECWD_PLUGIN_PREFIX . '_day_font_size',
            ECWD_PLUGIN_PREFIX . '_current_day_cell_bg_color',
            ECWD_PLUGIN_PREFIX . '_current_day_number_bg_color',
            ECWD_PLUGIN_PREFIX . '_current_day_text_color',
            //events
            ECWD_PLUGIN_PREFIX . '_event_title_color',
            ECWD_PLUGIN_PREFIX . '_event_title_font_size',
            ECWD_PLUGIN_PREFIX . '_event_details_bg_color',
            ECWD_PLUGIN_PREFIX . '_event_details_border_color',
            ECWD_PLUGIN_PREFIX . '_event_details_text_color',
            //ECWD_PLUGIN_PREFIX . '_event_details_font_size',
            //events list view
            ECWD_PLUGIN_PREFIX . '_event_list_view_date_bg_color',
            ECWD_PLUGIN_PREFIX . '_event_list_view_date_text_color',
            ECWD_PLUGIN_PREFIX . '_event_list_view_date_font_size',
            //posterboard
            ECWD_PLUGIN_PREFIX . '_event_posterboard_view_date_bg_color',
            ECWD_PLUGIN_PREFIX . '_event_posterboard_view_date_text_color',
            //pagination
            ECWD_PLUGIN_PREFIX . '_page_numbers_bg_color',
            ECWD_PLUGIN_PREFIX . '_current_page_bg_color',
            ECWD_PLUGIN_PREFIX . '_page_number_color',
        );
        $ecwd_post_meta_fields[ECWD_PLUGIN_PREFIX . '_venue'] = array(
          'ecwd_venue_meta_phone',
          'ecwd_venue_meta_website',
          'ecwd_venue_show_map',
          ECWD_PLUGIN_PREFIX . '_venue_location',
          ECWD_PLUGIN_PREFIX . '_venue_lat_long',
          ECWD_PLUGIN_PREFIX . '_map_zoom',
        );

        $ecwd_post_meta_fields[ECWD_PLUGIN_PREFIX . '_organizer'] = array(
          'ecwd_organizer_meta_website',
          'ecwd_organizer_meta_phone'
        );


        $ecwd_post_meta_fields[$post_type] = apply_filters($post_type . '_meta', $ecwd_post_meta_fields[$post_type]);

        if (current_user_can('edit_post', $post_id)) {
            if ($post_type == ECWD_PLUGIN_PREFIX . '_event' && !isset($_POST[ECWD_PLUGIN_PREFIX . '_event_show_map'])) {
                $_POST[ECWD_PLUGIN_PREFIX . '_event_show_map'] = 'no';
            }
// Loop through our array and make sure it is posted and not empty in order to update it, otherwise we delete it
            if ($post_type == ECWD_PLUGIN_PREFIX . '_theme') {
                $values = array();
                $data = json_encode($values);
                update_post_meta($post_id, $post_type . '_params', $data);
            } if ($post_type == ECWD_PLUGIN_PREFIX . '_event') {
              $this->save_event_metas($post_id);
            }else {
                foreach ($ecwd_post_meta_fields[$post_type] as $pmf) {
                    if (isset($_POST[$pmf]) && !empty($_POST[$pmf])) {
                        if ($post_type == ECWD_PLUGIN_PREFIX . '_calendar') {
                            if ($pmf == ECWD_PLUGIN_PREFIX . '_calendar_id') {
                                $str = $_POST[$pmf];
                                $id = str_replace('https://www.google.com/calendar/feeds/', '', $str);
                                $id = str_replace('/public/basic', '', $id);
                                $id = str_replace('%40', '@', $id);

                                update_post_meta($post_id, $pmf, trim($id));
                            } else {
                                update_post_meta($post_id, $pmf, stripslashes($_POST[$pmf]));
                            }
                        } else {

                            if (!is_array($_POST[$pmf])) {
                                $value = stripslashes($_POST[$pmf]);
                            } else {
                                $value = $_POST[$pmf];
                            }
                            update_post_meta($post_id, $pmf, $value);
                        }
                    } else {
                        delete_post_meta($post_id, $pmf);
                    }
                }
            }
        }

        do_action($post_type.'_after_save_meta',$post_id);
        return $post_id;
    }

    private function save_event_metas($post_id){
      include_once 'events/ecwd-single-event.php';
      include_once 'events/ecwd-events-controller.php';

      $event = new ecwd_single_event($post_id);
      $event->set_start_date($_POST['ecwd_event_date_from']);
      $event->set_end_date($_POST['ecwd_event_date_to']);

      if((isset($_POST['ecwd_all_day_event'])) && $_POST['ecwd_all_day_event'] === '1') {
        $event->set_all_day(true);
      } else {
        $event->set_all_day(false);
      }

      $event->calendars = !empty($_POST['ecwd_event_calendars']) ? $_POST['ecwd_event_calendars'] : array();
      $event->set_venue($_POST['ecwd_event_venue']);
      $event->organizers = !empty($_POST['ecwd_event_organizers']) ? $_POST['ecwd_event_organizers'] : array();
      $event->event_url = $_POST['ecwd_event_url'];
      $event->video_url = $_POST['ecwd_event_video'];
      $event->set_repeat();

      $event_controller = new ecwd_events_controller();
      $event_controller->update_meta_values($event);

    }

    public function error_messages($m) {
        global $post;

        return $m;
    }

    public function calendar_add_column_headers($defaults) {

        $new_columns = array(
            'cb' => $defaults['cb'],
            'calendar-id' => __('Calendar ID', 'event-calendar-wd'),
            'calendar-sc' => __('Calendar Shortcode', 'event-calendar-wd'),
            'calendar-dc' => __('Default Calendar', 'event-calendar-wd'),
        );

        return array_merge($defaults, $new_columns);
    }

    public function add_column_headers($defaults) {

        $new_columns = array(
            'cb' => $defaults['cb'],
            'event-id' => __('Event Dates', 'event-calendar-wd')
        );

        return array_merge($defaults, $new_columns);
    }

    /**
     * Fill out the calendar columns
     */
    public function calendar_column_content($column_name, $post_ID) {
        $default_id = get_option("ecwd_default_calendar");
        switch ($column_name) {

            case 'calendar-id':
                echo $post_ID;
                break;
            case 'calendar-sc':
                echo '<code>[ecwd id="' . $post_ID . '"]</code>';
                break;
            case 'calendar-dc':
                echo '<input id="ecwd_set_default_'.$post_ID.'" data-calendar_id="'.$post_ID.'" type="radio" '. ( $post_ID == $default_id ? ' checked="checked"' : ''). '  name="ecwd_set_default">';
                break;
        }
    }

    /**
     * Fill out the events columns
     */
    public function event_column_content($column_name, $post_ID) {
        switch ($column_name) {
            case 'event-id':
                $start = get_post_meta($post_ID, ECWD_PLUGIN_PREFIX . '_event_date_from', true);
                $end = get_post_meta($post_ID, ECWD_PLUGIN_PREFIX . '_event_date_to', true);
                if ($start) {
                    echo date('Y/m/d', strtotime($start));
                    echo ' - ' . date('Y/m/d', strtotime($end));
                } else {
                    echo 'No dates';
                }
                break;
        }
    }

    function create_taxonomies() {
        // Add new taxonomy, make it hierarchical (like categories)
        global $ecwd_options;
        $slug = (isset($ecwd_options['category_archive_slug']) && $ecwd_options['category_archive_slug'] != "") ? $ecwd_options['category_archive_slug'] : 'event_category';

        $labels = array(
            'name' => _x('Event Categories', 'taxonomy general name', 'event-calendar-wd'),
            'singular_name' => _x('Event Category', 'taxonomy singular name', 'event-calendar-wd'),
            'search_items' => __('Search Event Categories', 'event-calendar-wd'),
            'all_items' => __('All Event Categories', 'event-calendar-wd'),
            'parent_item' => __('Parent Category', 'event-calendar-wd'),
            'parent_item_colon' => __('Parent Category:', 'event-calendar-wd'),
            'edit_item' => __('Edit Category', 'event-calendar-wd'),
            'update_item' => __('Update Category', 'event-calendar-wd'),
            'add_new_item' => __('Add New Event Category', 'event-calendar-wd'),
            'new_item_name' => __('New Event Category Name', 'event-calendar-wd'),
            'menu_name' => __('Event Categories', 'event-calendar-wd'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => $slug),
        );
        //register_taxonomy_for_object_type(ECWD_PLUGIN_PREFIX.'_event_category', array(ECWD_PLUGIN_PREFIX.'_event'));
        register_taxonomy(ECWD_PLUGIN_PREFIX . '_event_category', array(ECWD_PLUGIN_PREFIX . '_event'), $args);

        register_taxonomy(
                ECWD_PLUGIN_PREFIX . '_event_tag', ECWD_PLUGIN_PREFIX . '_event', array(
            'hierarchical' => false,
            'label' => __('Event Tags', 'event-calendar-wd'),
            'singular_name' => __('Event Tag', 'event-calendar-wd'),
            'rewrite' => array('slug' => 'event_tag'),
            'query_var' => true
                )
        );
    }

    /*
     * Add metas to events categories
     *
     * */

    public function add_categories_metas($term) {
        $tax = $this->tax;
        $uploadID = '';
        $icon = '';
        $term_id = '';
        $term_meta = array();
        $term_meta['color'] = '';
        $term_meta[ECWD_PLUGIN_PREFIX . '_taxonomy_image'] = '';
        if ($term && is_object($term)) {
            $term_id = $term->term_id;
            $term_meta = get_option("{$this->tax}_$term_id");
            $term_meta[ECWD_PLUGIN_PREFIX . '_taxonomy_image'] = $this->get_image_url($term_meta[ECWD_PLUGIN_PREFIX . '_taxonomy_image']);
            //var_dump($term_meta);
        }
        include_once( ECWD_DIR . '/views/admin/ecwd-event-cat-meta.php' );
    }

    public function get_image_url($url, $size = null, $return_placeholder = false) {


        $taxonomy_image_url = $url;
        if (!empty($taxonomy_image_url)) {
            $attachment_id = $this->get_attachment_id_by_url($taxonomy_image_url);
            if (!empty($attachment_id)) {
                if (empty($size)) {
                    $size = 'full';
                }
                $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
                $taxonomy_image_url = $taxonomy_image_url[0];
            }
        }

        if ($return_placeholder) {
            return ( $taxonomy_image_url != '' ) ? $taxonomy_image_url : self::IMAGE_PLACEHOLDER;
        } else {
            return $taxonomy_image_url;
        }
    }

    public function get_attachment_id_by_url($image_src) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid = '$image_src'";
        $id = $wpdb->get_var($query);

        return (!empty($id) ) ? $id : null;
    }

    public function save_categories_metas($term_id) {
        //var_dump($_POST); die;
        if (isset($_POST[$this->tax])) {

            $t_id = $term_id;
            $term_meta = get_option("{$this->tax}_$t_id");
            $cat_keys = array_keys($_POST[$this->tax]);
            foreach ($cat_keys as $key) {
                if (isset($_POST[$this->tax][$key])) {
                    $term_meta[$key] = esc_attr($_POST[$this->tax][$key]);
                }
            }
            //save the option array
            update_option("{$this->tax}_$t_id", $term_meta);
        }
    }

    public function taxonomy_columns($columns) {
        $new_columns = array();
        $new_columns['cb'] = $columns['cb'];
        $new_columns['thumb'] = __('Icon', 'event-calendar-wd');
        $new_columns['color'] = __('Color', 'event-calendar-wd');

        unset($columns['cb']);

        return array_merge($new_columns, $columns);
    }

    public function taxonomy_column($columns, $column, $id) {
        $term_meta = get_option("{$this->tax}_$id");
        if (!$term_meta) {
            $term_meta = array(
                ECWD_PLUGIN_PREFIX . '_taxonomy_image' => '',
                'color' => ''
            );
        }
        if ($column == 'thumb') {
            $term_meta[ECWD_PLUGIN_PREFIX . '_taxonomy_image'] = $this->get_image_url($term_meta[ECWD_PLUGIN_PREFIX . '_taxonomy_image']);
            $columns = '<div><img src="' . $this->get_image_url($term_meta[ECWD_PLUGIN_PREFIX . '_taxonomy_image'], null, true) . '" alt="' . __('Icon', 'event-calendar-wd') . '" class="wp-post-image ecwd_icon" /></div>';
        }
        if ($column == 'color') {
            $columns .= '<div><div style="width: 10px; height: 10px; background-color: ' . $term_meta['color'] . '" ></div></div>';
        }

        return $columns;
    }

    public function event_restrict_manage() {
        include_once 'ecwd-cpt-filter.php';
        new Tax_CTP_Filter(
                array(
            self::EVENT_POST_TYPE => array(
                ECWD_PLUGIN_PREFIX . '_calendar',
                ECWD_PLUGIN_PREFIX . '_event_category',
                ECWD_PLUGIN_PREFIX . '_organizer',
                ECWD_PLUGIN_PREFIX . '_venue',
                ECWD_PLUGIN_PREFIX . '_event_tag'
            )
                )
        );
    }

    public function get_ecwd_calendars() {
        $args = array(
            'numberposts' => - 1,
            'post_type' => ECWD_PLUGIN_PREFIX . '_calendar'
        );
        $calendars = get_posts($args);

        return $calendars;
    }

    public function ecwd_templates($template) {
		global $ecwd_options;
        $post_types = array(self::EVENT_POST_TYPE);
        if (is_singular($post_types) && !file_exists(get_stylesheet_directory() . '/single-event.php') && (isset($ecwd_options['use_custom_template']) && $ecwd_options['use_custom_template'] == '1')) {
            $template = ECWD_DIR . '/views/single-event.php';
        } elseif (is_tax('ecwd_event_category')) {
            global $ecwd_options;
            if(isset($ecwd_options['ecwd_category_archive_template']) && $ecwd_options['ecwd_category_archive_template'] == '1'){
                $template = ECWD_DIR . '/views/taxonomy-ecwd_event_category.php';
            }
        }

        return $template;
    }



    public static function add_new_venue($post_data=null) {
        if($post_data == null){
            $post_data = $_POST;
        }

        $venue_title = (isset($post_data['ecwd_venue_title'])) ? sanitize_text_field($post_data['ecwd_venue_title']) : "";
        $venue_content = (isset($post_data['ecwd_venue_content'])) ? sanitize_text_field($post_data['ecwd_venue_content']) : "";
        $venue_location = (isset($post_data['ecwd_event_location'])) ? sanitize_text_field($post_data['ecwd_event_location']) : "";
        $venue_phone = (isset($post_data['ecwd_venue_meta_phone'])) ? sanitize_text_field($post_data['ecwd_venue_meta_phone']) : "";
        $venue_website = (isset($post_data['ecwd_venue_meta_website'])) ? sanitize_text_field($post_data['ecwd_venue_meta_website']) : "";
        $venue_show_map = (isset($post_data['ecwd_venue_show_map'])) ? sanitize_text_field($post_data['ecwd_venue_show_map']) : "";
        $venue_lat_long = (isset($post_data['ecwd_lat_long'])) ? sanitize_text_field($post_data['ecwd_lat_long']) : "";
        $venue_zoom = (isset($post_data['ecwd_map_zoom'])) ? sanitize_text_field($post_data['ecwd_map_zoom']) : "";


        $post_args = array(
          'post_title' => $venue_title,
          'post_content' => $venue_content,
          'post_status' => 'publish',
          'post_type' => 'ecwd_venue',
          'meta_input' => array(
            'ecwd_venue_show_map' => $venue_show_map,
            'ecwd_venue_location' => $venue_location,
            'ecwd_venue_lat_long' => $venue_lat_long,
            'ecwd_map_zoom' => $venue_zoom,
            'ecwd_venue_meta_phone' => $venue_phone,
            'ecwd_venue_meta_website' => $venue_website
          )
        );

        $post_id = wp_insert_post($post_args);

        $response = $post_args['meta_input'];
        $response['post_title'] = $post_args['post_title'];
        $response['id'] = $post_id;

        return $response;
    }


    public function category_archive_page_query($query) {
        if (is_admin() === false && is_tax('ecwd_event_category') === true) {
            $query->query_vars['posts_per_page'] = 5;
        }
    }

    public function ecwd_events_archive_page($post) {
        global $ecwd_options;

        if (is_admin() === true || is_archive() === false || is_post_type_archive(array("ecwd_event")) === false) {
            return $post;
        }
        $from = get_post_meta($post->ID, "ecwd_event_date_from", true);
        if (empty($from)) {
            return $post;
        }
        $date_format = (!empty($ecwd_options['date_format'])) ? str_replace('y', 'Y', $ecwd_options['date_format']) : "Y/m/d";
        $sec = strtotime($from);
        $date = date($date_format,$sec);
        $post->post_date = $date;
        return $post;
    }

    public function events_archive_page_query($query) {
        if (is_archive() && !is_admin()) {
          if ((isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'ecwd_event') || is_tax('ecwd_event_category') || is_tax('ecwd_event_tag')) {
                global $ecwd_options;
                $query->set('meta_key', 'ecwd_event_date_from');
                $query->set('orderby', 'meta_value');
                if (isset($ecwd_options['events_archive_page_order']) && $ecwd_options['events_archive_page_order'] == '1') {
                    $order = "ASC";
                }else{
                    $order = "DESC";
                }                
                $query->set('order',$order);                       
            }
        }
    }

    public function ecwd_clear_cache_option(){
        $cleared = $this->delete_transient();
        if ($cleared) {
            try {
                echo '<div class= "updated" ><p> ' . __('Cache has been deleted.', 'event-calendar-wd') . '</p></div>';
            } catch (Exception $e) {

            }
        }
    }

    public function delete_transient() {
        try {
            $calendars = $this->get_ecwd_calendars();
            foreach ($calendars as $calendar) {
                $ecwd_facebook_page_id = get_post_meta($calendar->ID, ECWD_PLUGIN_PREFIX . '_facebook_page_id', true);
                $ecwd_calendar_id = get_post_meta($calendar->ID, ECWD_PLUGIN_PREFIX . '_calendar_id', true);
                $ecwd_calendar_ical = get_post_meta($calendar->ID, ECWD_PLUGIN_PREFIX . '_calendar_ical', true);
                if ($ecwd_facebook_page_id) {
                    delete_transient(substr(ECWD_PLUGIN_PREFIX . '_calendar_' . $ecwd_facebook_page_id, 0, 30));
                }
                if ($ecwd_calendar_id) {
                    delete_transient(substr(ECWD_PLUGIN_PREFIX . '_calendar_' . $ecwd_calendar_id, 0, 30));
                }
                if ($ecwd_calendar_ical) {
                    delete_transient(substr(ECWD_PLUGIN_PREFIX . '_calendar_' . $ecwd_calendar_ical, 0, 30));
                }
            }

            return true;
        } catch (Exception $e) {
            //add log
            return false;
        }
    }

    private function is() {
        if (1 == get_option('ecwd_old_events')) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

}
