<?php

namespace MailPoet\Premium\Config;

use MailPoet\Config\AccessControl;
use MailPoet\Models\Newsletter;
use MailPoet\WP\Hooks;

class Menu {

  /** @var Renderer */
  private $renderer;

  /** @var AccessControl */
  private $access_control;

  /** @var \MailPoet\Config\Menu */
  private $free_plugin_menu;

  function __construct(Renderer $renderer, AccessControl $access_control, \MailPoet\Config\Menu $free_plugin_menu) {
    $this->access_control = $access_control;
    $this->free_plugin_menu = $free_plugin_menu;
    $this->renderer = $renderer;
  }

  function afterLists() {
    if($this->access_control->validatePermission(AccessControl::PERMISSION_MANAGE_SEGMENTS)) {
      // Dynamic segments page
      // Only show this page in menu if the Premium plugin is activated
      $dynamic_segments_page = add_submenu_page(
        \MailPoet\Config\Menu::MAIN_PAGE_SLUG,
        $this->free_plugin_menu->setPageTitle(__('Segments', 'mailpoet-premium')),
        __('Segments', 'mailpoet-premium'),
        AccessControl::PERMISSION_MANAGE_SEGMENTS,
        'mailpoet-dynamic-segments',
        array(
          $this,
          'dynamicSegments'
        )
      );

      // add limit per page to screen options
      add_action('load-' . $dynamic_segments_page, function() {
        add_screen_option('per_page', array(
          'label' => _x('Number of segments per page', 'segments per page (screen options)', 'mailpoet-premium'),
          'option' => 'mailpoet_dynamic_segments_per_page'
        ));
      });
    }
  }

  function dynamicSegments() {
    $data = array();

    $data['page_name'] = 'dynamic_segments';

    Hooks::addAction(
      'mailpoet_pages_dynamic_segments',
      array($this, 'renderDynamicSegments')
    );
    Hooks::addAction(
      'mailpoet_pages_translations_dynamic_segments',
      array($this, 'renderDynamicSegmentsTranslations')
    );
    $this->free_plugin_menu->displayPage('blank.html', $data);
  }

  function renderDynamicSegments() {
    $data = array();

    $data['items_per_page'] = $this->free_plugin_menu->getLimitPerPage('dynamic_segments');
    $wp_roles = get_editable_roles();
    $data['wordpress_editable_roles_list'] = array_map(function($role_id, $role) {
      return array(
        'role_id' => $role_id,
        'role_name' => $role['name'],
      );
    }, array_keys($wp_roles), $wp_roles);
    $data['newsletters_list'] = Newsletter::select(array('id', 'subject', 'sent_at'))
      ->whereNull('deleted_at')
      ->where('type', Newsletter::TYPE_STANDARD)
      ->orderByExpr('ISNULL(sent_at) DESC, sent_at DESC')->findArray();


    $data['product_categories'] = get_categories(array('taxonomy' => 'product_cat'));
    usort($data['product_categories'], function ($a, $b) {
      return strcmp($a->cat_name, $b->cat_name);
    });
    $data['products'] = $this->getProducts();
    $data['is_woocommerce_active'] = is_plugin_active('woocommerce/woocommerce.php');

    echo $this->renderer->render('dynamicSegments.html', $data);
  }

  private function getProducts() {
    $args = array('post_type' => 'product', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1);
    $products = get_posts($args);
    return array_map(function ($product) {
      return array(
        'title' => $product->post_title,
        'ID' => $product->ID,
      );
    }, $products);
  }

  function renderDynamicSegmentsTranslations() {
    $data = array();

    echo $this->renderer->render('dynamicSegmentsTranslations.html', $data);
  }

}