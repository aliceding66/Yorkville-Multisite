<?php

add_action( 'personal_options', 'rpa_profile_ban_field' );
add_action( 'edit_user_profile_update', 'rpa_profile_ban_field_save' );

function rpa_profile_ban_field( \WP_User $user ) {
  $current = wp_get_current_user();
  if ( ! is_admin() || $user->ID === $current->ID ) return;
  if ( ! user_can( $current, 'edit_users' ) ) return;
  $target = new WP_User( $user->ID ); 
  if ( $target->exists() &&  ! user_can( $target, 'edit_users' ) ) {
    $banned = (int) get_user_meta( $user->ID, '_profile_banned', TRUE );
  ?>
  <table class="form-table"><tbody><tr>
  <th scope="row">Profile Ban</th><td>
  <input<?php checked(1, $banned); ?> name="_profile_banned" value="1" type="checkbox">
  Ban user to enter profile?
  </td></tr></tbody></table>
  <?php
  }
}

function rpa_profile_ban_field_save( $userid ) {
  $current = wp_get_current_user();
  if ( ! is_admin() || $user->ID === $current->ID ) return;
  if ( ! user_can( $current, 'edit_users' ) ) return;
  $target = new WP_User( $userid );
  if ( ! $target->exists() || user_can( $target, 'edit_users' ) ) return; 
  $ban = filter_input( INPUT_POST, '_profile_banned', FILTER_SANITIZE_NUMBER_INT );
  if ( (int) $ban > 0 ) {
    update_user_meta( $userid, '_profile_banned', 1 );
  } elseif ( get_user_meta( $userid, '_profile_banned', TRUE ) ) {
    delete_user_meta( $userid, '_profile_banned' );
  }
}



// remove admin menu link
add_action( 'admin_menu', 'rpa_profile_menu_remove' );

function rpa_profile_menu_remove(){
  $remove = get_user_meta( get_current_user_id(), '_profile_banned', TRUE );
  if ( ! current_user_can( 'edit_users' ) && (int) $remove > 0 ) {
    remove_menu_page( 'profile.php' );
  }
}  


// remove admin top bar edit profile
add_action( 'wp_before_admin_bar_render', 'rpa_profile_adminbar_remove' );

function rpa_profile_adminbar_remove() {
  $remove = get_user_meta( get_current_user_id(), '_profile_banned', TRUE );
  if ( (int) $remove !== 1 || current_user_can( 'edit_users' ) ) return;
  global $wp_admin_bar;
  $account = (array) $wp_admin_bar->get_node('my-account');
  $info = (array) $wp_admin_bar->get_node('user-info');
  $logout = (array) $wp_admin_bar->get_node('logout');
  $account['href'] = $info['href'] = '#';
  $wp_admin_bar->remove_node('my-account');
  $wp_admin_bar->remove_node('user-info');
  $wp_admin_bar->remove_node('edit-profile');
  $wp_admin_bar->remove_node('logout');
  $wp_admin_bar->add_node($account);
  $wp_admin_bar->add_node($info);
  $wp_admin_bar->add_node($logout);
}

// disable http://www.xxx.com/wp-admin/profile.php

add_action( 'load-profile.php', 'rpa_profile_banned_check' );
add_action( 'load-index.php', 'rpa_profile_banned_msg' );
add_action( 'all_admin_notices', 'rpa_profile_banned_msg' );

function rpa_profile_banned_check() {
  $remove = get_user_meta( get_current_user_id(), '_profile_banned', TRUE );
  if ( (int) $remove === 1 && ! current_user_can( 'edit_users' ) ) {
    wp_redirect( add_query_arg( array( 'pbanned' => 1), admin_url('index.php') ) );
    exit();
  }
}

function rpa_profile_banned_msg() {
  if ( current_user_can( 'edit_users' ) ) return;
  static $show = false;
  if ( current_filter() === 'load-index.php' ) {
    $msg = (int) filter_input( INPUT_GET, 'pbanned', FILTER_SANITIZE_NUMBER_INT);
    $banned = (int) get_user_meta( get_current_user_id(), '_profile_banned', TRUE );
    $show = ( $msg === $banned && $banned === 1 );    
  } elseif ( current_filter() === 'all_admin_notices' && $show ) {
    echo '<div class="error"><p>Sorry, you are not allowed to edit your profile.</p></div>';
  }
}

