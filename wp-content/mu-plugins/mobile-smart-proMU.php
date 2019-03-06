<?php 
/*
Plugin Name: Mobile Smart Pro MU
Plugin URI: http://www.mobile-smart.co.uk/
Version: v1.3.9
Author: <a href="http://www.dansmart.co.uk/">Dan Smart</a>
Description: Helper plugin for Mobile Smart Pro
 */
 
if (file_exists(ABSPATH . "wp-content/plugins/mobile-smart-pro/")) {
 
  include ABSPATH . "wp-content/plugins/mobile-smart-pro/mobile-smart-pro.php";
  
  /**
   * MU Helper class
   */
  class MobileSmartMU {
      /**
       * Disable any selected plugins
       */
      function disablePlugins($pluginList) {
        
        if (is_admin()) return $pluginList; // only deactivate on front end
        
        global $mobile_smart;
        
        // get options
        if (isset($mobile_smart) && $mobile_smart) {
            $options = $mobile_smart->getAdminOptions();
          
          // if theme switching enabled
          $is_mobile = $mobile_smart->switcher_isMobile();
          
          if ($is_mobile) {
            // do mobile specific disabling
            if (!$mobile_smart->DetectIsTablet()) {
                if (isset($options['plugins']) && $options['plugins']) {
                
                foreach ($options['plugins'] as $plugin) {
                  if (in_array($plugin, $pluginList)) {
                    unset($pluginList[array_search($plugin, $pluginList)]);
                  }
                }
              }
            }
            
            // do tablet specific disabling
            if ($mobile_smart->DetectIsTablet()) {
              
              if (isset($options['tablet_plugins']) && $options['tablet_plugins']) {
                
                foreach ($options['tablet_plugins'] as $plugin) {
                  if (in_array($plugin, $pluginList)) {
                    unset($pluginList[array_search($plugin, $pluginList)]);
                  }
                }
              }
            }
          }
        }
        
        return $pluginList;
        
      }
  
  }
  
  $MobileSmartMU = new MobileSmartMU();
  
  add_filter('option_active_plugins', array($MobileSmartMU, 'disablePlugins'), 10, 1);
  
}