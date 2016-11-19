<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/menu-walkers.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Nav Options to Customer */
require_once( 'library/custom-nav.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/protocol-relative-theme-assets.php' );

function loginRedirect($data){
  $user = wp_get_current_user();
  if( $user ){
    $redirect = 'home-1';
  }
  else{
    $redirect = 'mm-error';
  }
   return $redirect;
}

add_filter( 'mm_login_redirect', 'loginRedirect' );

function customMoreText(){

  return '';
}

add_filter ( 'excerpt_more', 'customMoreText');

function getMMUsers(){
  global $wpdb;
  $str = "SELECT first_name, last_name, phone, wp_user_id, mm_img_url FROM `mm_user_data`";
  $query = $wpdb->get_results($str, OBJECT);
  return $query;
}

function getMMUser($id){
  global $wpdb;
  $str = "SELECT first_name, last_name, phone, wp_user_id, mm_img_url FROM `mm_user_data` WHERE wp_user_id = '$id'";
  $query = $wpdb->get_results($str, OBJECT);
  return $query;
}
/*return a array of member information*/
function getMMUserEmail($id){
  global $wpdb;
  $str = "SELECT user_email FROM wny_users WHERE ID='$id'";
  $query = $wpdb->get_results($str, OBJECT);
  return $query;
}

function customExcerpt($param){

  $substring = substr($param, 0, 800);
  $lastSpace = strrpos($substring, ' ');
  $excerpt = substr($substring, 0 , $lastSpace);
  return $excerpt;
}

function insertImgUrl ($url, $id){
  global $wpdb;
  $urlStr = $url;

  return $wpdb->update('mm_user_data', array('mm_img_url' => "$urlStr"), array('wp_user_id' => "$id"), '%s', null);
}

function nextBillingDate($userID){
  global $wpdb;
  $str = "SELECT scheduled_date FROM mm_scheduled_events where id = '$userID'";
  $startDateObject = $wpdb->get_results($str, OBJECT);
  foreach ( $startDateObject as $date){
    $startDate = $date;
  }
  return $startDate;
}
function remove_admin_menu_items() {
  $remove_menu_items = array(__('member profiles'));
  global $menu;
  end ($menu);
  while (prev($menu)){
    $item = explode(' ',$menu[key($menu)][0]);
    if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
    unset($menu[key($menu)]);}
  }
}

/*
get custom_field_id and Value from custom_field_data
get the custom_field_name from customs_fields and display the field name next to the field value
*/
function getCustomFieldIDs($param){
  global $wpdb;
  $str = "SELECT custom_field_id, value FROM mm_custom_field_data WHERE user_id = '$userID' ";
  $parameterObject = $wpdb->get_results($str, OBJECT);
  return $parameterObject;
}

function getCustomFieldValues($param){
  global $wpdb;
  $str = "SELECT custom_field_id, value FROM mm_custom_field_data WHERE user_id = '$userID' ";
  $parameterObject = $wpdb->get_results($str, OBJECT);
  return $parameterObject;
}

function getCustomFieldName($param) {
  global $wpdb;
  foreach($param as $field){
    $str = "SELECT display_name from mm_custom_fields where id = '$field'";
    $field_array[] = array($wpdb->get_results($str, string));
  }
    return $field_array;
}
add_action('admin_menu', 'remove_admin_menu_items');
