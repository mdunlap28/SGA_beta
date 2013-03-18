<?php
/*
	Plugin Name: WP Forum Server
	Plugin Author: VastHTML
	Author URI: http://forumpress.org/
    Plugin URI: http://forumpress.org/
	Version: 1.7.5
*/

include_once("wpf.class.php");

// Short and sweet :)
$vasthtml = new vasthtml();

// Activating?
register_activation_hook(__FILE__ ,array(&$vasthtml,'wp_forum_install'));

add_action("the_content", array(&$vasthtml, "go"));

//if(ini_get('output_buffering')){
//    add_action('wp_head', array(&$vasthtml, "buffer_start"));
//    add_action('wp_footer', array(&$vasthtml, "buffer_end"));
//} else {
//    add_action("the_content", array(&$vasthtml, "go"));
//}

add_action('admin_head-forum-server/fs-admin/fs-admin.php', 'jquery_init');
add_action('init', array(&$vasthtml,'set_cookie'));
add_action('wp_logout', array(&$vasthtml,'unset_cookie'));
add_filter("wp_title", array(&$vasthtml, "set_pagetitle"));

function latest_activity($num = 5){
	global $vasthtml;
	return $vasthtml->latest_activity($num);
}
function jquery_init() {
	// comment out the next two lines to load the local copy of jQuery
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js');
	wp_enqueue_script('jquery');
}
?>