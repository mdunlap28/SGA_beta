<?php
/*
Plugin Name: Notify Bar
Plugin URI: http://wordpress.org/extend/plugins/notify-bar/
Description: Adds a Notify Bar across the top of some or all pages on your website. 
Version: 1.2
Author: Milton Brian Jones
Author URI: http://www.miltonbjones.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

/* create the plugin admin page */

add_action('admin_menu', 'mbj_notify_bar_add_page');

function mbj_notify_bar_add_page() {
	add_options_page( 'Notify Bar', 'Notify Bar', 'manage_options', 'mbj_notify_bar', 'mbj_notify_bar_options_page' );
}


/* add the farbtastic color picker script so it can be used later */

add_action('load-settings_page_mbj_notify_bar', 'mbj_notify_bar_ilc_farbtastic_script');
	function mbj_notify_bar_ilc_farbtastic_script() {
  		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'mbj_notify_bar_farbtastic_js', plugins_url( 'notify-bar/js/notify-bar-farbtastic.js' ), array( 'farbtastic','jquery' ), '', true );
}


/* add the jQuery cookie plugin so it can be used in the hiding of the Notify Bar */

add_action('wp_enqueue_scripts', 'mbj_notify_bar_jquery_cookie_script_include');
	function mbj_notify_bar_jquery_cookie_script_include() {
		wp_enqueue_script( 'mbj_notify_bar_jquery_cookie_script', plugins_url( 'notify-bar/js/jquery.cookie.js' ), array( 'jquery' ), '', true );
}


/* add this little jQuery script that hides the Notify Bar when the user clicks Hide This */

add_action('wp_enqueue_scripts', 'mbj_notify_bar_hide_include');
	function mbj_notify_bar_hide_include() {
		wp_enqueue_script( 'mbj_notify_bar_hide', plugins_url( 'notify-bar/js/notify-bar-hide.js' ), array( 'jquery', 'mbj_notify_bar_jquery_cookie_script' ), '', true );
}


/* add custom css for the front end display of the Notify Bar */

add_action('wp_enqueue_scripts', 'mbj_notify_bar_custom_css');
	function mbj_notify_bar_custom_css() {
		wp_register_style( 'mbj_notify_bar_style', plugins_url( 'notify-bar/css/notify-bar.css' ));	
		wp_enqueue_style( 'mbj_notify_bar_style' );		
}


/* register the settings for the admin page */

add_action('admin_init', 'mbj_notify_bar_register_settings');

function mbj_notify_bar_register_settings() {

	register_setting(
		'mbj_notify_bar_options',
		'mbj_notify_bar_options',
		'mbj_notify_bar_validate_options'
		);	
	
	add_settings_section(
		'mbj_notify_bar_main',
		'Notify Bar Settings',
		'mbj_notify_bar_section_text',
		'mbj_notify_bar'
		);
		
		
	add_settings_field(
		'mbj_notify_bar_active',
		'Activate the Notify Bar?',
		'mbj_notify_bar_setting_active',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);
		
	add_settings_field(
		'mbj_notify_bar_hide_this',
		'Include Hide This link?',
		'mbj_notify_bar_setting_hide_this',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);	
		
	add_settings_field(
		'mbj_notify_bar_headline',
		'Headline:',
		'mbj_notify_bar_setting_headline',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);
	
	add_settings_field(
		'mbj_notify_bar_message',
		'Message:',
		'mbj_notify_bar_setting_message',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);
		
	add_settings_field(
		'mbj_notify_bar_background_color',
		'Background color:',
		'mbj_notify_bar_setting_background_color',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);	
		
	add_settings_field(
		'mbj_notify_bar_headline_color',
		'Headline color:',
		'mbj_notify_bar_setting_headline_color',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);	
		
	add_settings_field(
		'mbj_notify_bar_message_color',
		'Message color:',
		'mbj_notify_bar_setting_message_color',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);				
			
	add_settings_field(
		'mbj_notify_bar_link_color',
		'Link color:',
		'mbj_notify_bar_setting_link_color',
		'mbj_notify_bar',
		'mbj_notify_bar_main'
		);					
			
}


add_action('plugins_loaded', 'mbj_notify_bar_set_default_options');

function mbj_notify_bar_set_default_options(){
		$options = get_option( 'mbj_notify_bar_options' );
		
		/* set default options for initial install */
		$defaults = array(
			'active' => 'no',
			'hide_this' => 'yes',
			'background_color' => '#ffff33',
			'headline_color' => '#000000',
			'message_color' => '#000000',
			'link_color' => '#0000ff',
			'headline' => 'Type Headline Here',
			'message' => 'Type Message Here'
		);
		
		/* if the option doesn't exist, set it to the default value assigned above */
		if ( !$options )
			update_option( 'mbj_notify_bar_options', $defaults );
}


/* set the explanatory text that introduces the settings */
function mbj_notify_bar_section_text() {
	echo 'Complete the fields below to set up your Notify Bar.  (<a href="http://wordpress.org/extend/plugins/notify-bar/faq/">More instructions here if needed</a>)';
}


/* set up and dislay the form element for activating the Notify Bar (should it be on?  yes or no) */
function mbj_notify_bar_setting_active() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['active'];
	// echo the field
		echo "<input id='active' type='radio' name='mbj_notify_bar_options[active]' value='yes'" . checked($text_string, 'yes', 0) . " />Yes
          	  <input id='active' type='radio' name='mbj_notify_bar_options[active]' value='no'" . checked($text_string, 'no', 0) . " />No";
}

/* set up and display the form element for whether or not to include a Hide This link */
function mbj_notify_bar_setting_hide_this() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['hide_this'];
	// echo the field
		echo "<input id='hide_this' type='radio' name='mbj_notify_bar_options[hide_this]' value='yes'" . checked($text_string, 'yes', 0) . " />Yes
          	  <input id='hide_this' type='radio' name='mbj_notify_bar_options[hide_this]' value='no'" . checked($text_string, 'no', 0) . " />No";
}



/* set up and display the form element for inputting the headline */
function mbj_notify_bar_setting_headline() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['headline'];
	// echo the field
	echo "<input id='headline' name='mbj_notify_bar_options[headline]' type='text' value='$text_string' />";
}


/* set up and display the form element for inputting the message */
function mbj_notify_bar_setting_message() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['message'];
	// echo the field
	echo "<textarea id='message' cols='80' rows='10' name='mbj_notify_bar_options[message]' type='text'>$text_string</textarea>";
}


/* set up and display the form element for setting the background color */
function mbj_notify_bar_setting_background_color() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['background_color'];
	// echo the field
	echo "<input type='text' id='background_color' name='mbj_notify_bar_options[background_color]' value='$text_string' /><div id='ilctabscolorpicker-background'>    																																									          </div>";
}


/* set up and display the form element for setting the headline color */
function mbj_notify_bar_setting_headline_color() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['headline_color'];
	// echo the field
	echo "<input type='text' id='headline_color' name='mbj_notify_bar_options[headline_color]' value='$text_string' /><div id='ilctabscolorpicker-headline'>    																																									          </div>";
}


/* set up and display the form element for setting the message color */
function mbj_notify_bar_setting_message_color() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['message_color'];
	// echo the field
	echo "<input type='text' id='message_color' name='mbj_notify_bar_options[message_color]' value='$text_string' /><div id='ilctabscolorpicker-message'>    																																									          </div>";
}


/* set up and display the form element for setting the link color */
function mbj_notify_bar_setting_link_color() {
	$options = get_option( 'mbj_notify_bar_options' );
	$text_string = $options['link_color'];
	// echo the field
	echo "<input type='text' id='link_color' name='mbj_notify_bar_options[link_color]' value='$text_string' /><div id='ilctabscolorpicker-link'              																																									          </div>";
}



/* validate the input */
function mbj_notify_bar_validate_options($input) { 

	// set up an array to put the validated values
	$valid = array();

	// only accept yes or no for the active value
	if (($input['active'] == 'yes') || ($input['active'] == 'no')) {
		$valid['active'] = $input['active'];
	}
	
	// only accept yes or no for the active value
	if (($input['hide_this'] == 'yes') || ($input['hide_this'] == 'no')) {
		$valid['hide_this'] = $input['hide_this'];
	}

	// only accept certain tags for headline
	if ($input['headline']) {

		$allowed = array(
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'b'      => array(),
			'i'      => array(),
			'span'   => array(),
			'a'      => array(
			'href'  => array(),
			'title' => array(),
			'alt'   => array()
			)
 		);
		$clean_headline = wp_kses($input['headline'], $allowed);
		$valid['headline'] = $clean_headline;
  		}
  
	// only accept certain tags for the message
	if ($input['message']) {

		$allowed = array(
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'b'      => array(),
			'i'      => array(),
			'span'   => array(),
			'a'      => array(
			'href'  => array(),
			'title' => array(),
			'alt'   => array()
			)
 		);
		$clean_message = wp_kses($input['message'], $allowed);
		$valid['message'] = $clean_message;
 		 }  

	// use regex to check that first character is # sign and then only accept 7 characters for the background color
	// otherwise use #ffff33, which is the same as default background color
	if (preg_match('/^#/', $input['background_color'])) {
		$valid['background_color'] = substr($input['background_color'], 0, 7); 
	}
	else {
		$valid['background_color'] = '#ffff33';
	}
	
	// use regex to check that first character is # sign and then only accept 7 characters for the headline color
	// otherwise use #000000, which is the same as default headline color
	if (preg_match('/^#/', $input['headline_color'])) {
		$valid['headline_color'] = substr($input['headline_color'], 0, 7); 
	}
	else {
		$valid['headline_color'] = '#000000';
	}
	
	// use regex to check that first character is # sign and then only accept 7 characters for the message color
	// otherwise use #000000, which is the same as default message color
	if (preg_match('/^#/', $input['message_color'])) {
		$valid['message_color'] = substr($input['message_color'], 0, 7); 
	}
	else {
		$valid['message_color'] = '#000000';
	}
			
	// use regex to check that first character is # sign and then only accept 7 characters for the link color
	// otherwise use #0000ff, which is the same as default link color
	if (preg_match('/^#/', $input['link_color'])) {
		$valid['link_color'] = substr($input['link_color'], 0, 7); 
	}
	else {
		$valid['link_color'] = '#0000ff';
	}
	
return $valid;  
  
}


/* set up the options page putting a form tag on the page and then calling the settings sections and fields */

function mbj_notify_bar_options_page() {
	?>
    <div class="wrap"><?php screen_icon(); ?>
    <h2>Notify Bar</h2>
    <form action="options.php" method="post">
    <?php
	settings_fields('mbj_notify_bar_options');
	do_settings_sections('mbj_notify_bar');
	?>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"  /></p>
    </form></div>

<?php
}


// this function is used to put the Notify Bar on the page
// it grabs the options and changes them to local variables
// then it echoes out some HTML that writes the Notify Bar

function mbj_notify_bar_display() {
	
	$mbj_notify_bar_display_options = get_option( 'mbj_notify_bar_options' );
	$mbj_notify_bar_display_options_active = $mbj_notify_bar_display_options['active'];	
	$mbj_notify_bar_display_options_hide_this = $mbj_notify_bar_display_options['hide_this'];	
	$mbj_notify_bar_display_options_headline = $mbj_notify_bar_display_options['headline'];
	$mbj_notify_bar_display_options_message = $mbj_notify_bar_display_options['message'];
	$mbj_notify_bar_display_options_background_color = $mbj_notify_bar_display_options['background_color'];
	$mbj_notify_bar_display_options_headline_color = $mbj_notify_bar_display_options['headline_color'];
	$mbj_notify_bar_display_options_message_color = $mbj_notify_bar_display_options['message_color'];
	$mbj_notify_bar_display_options_link_color = $mbj_notify_bar_display_options['link_color'];

	if (($mbj_notify_bar_display_options_active == 'yes') && ($mbj_notify_bar_display_options_hide_this == 'yes')) {	
		echo "<style>div#mbj-notify-bar-wrapper a{color:$mbj_notify_bar_display_options_link_color;}</style><div id='mbj-notify-bar-wrapper' style='background-color:$mbj_notify_bar_display_options_background_color;'>
		<div id='mbj-notify-bar'>
		<h2 style='color:$mbj_notify_bar_display_options_headline_color;'>$mbj_notify_bar_display_options_headline</h2>
		<p style='color:$mbj_notify_bar_display_options_message_color;'>$mbj_notify_bar_display_options_message</p>
	    <p id='hide'><a href=''>(Hide This)</a></p>
		</div>
		</div>";
        }
	elseif (($mbj_notify_bar_display_options_active == 'yes') && ($mbj_notify_bar_display_options_hide_this == 'no')) {	
		echo "<style>div#mbj-notify-bar-wrapper a{color:$mbj_notify_bar_display_options_link_color;}</style><div id='mbj-notify-bar-wrapper' style='background-color:$mbj_notify_bar_display_options_background_color;'>
		<div id='mbj-notify-bar'>
		<h2 style='color:$mbj_notify_bar_display_options_headline_color;'>$mbj_notify_bar_display_options_headline</h2>
		<p style='color:$mbj_notify_bar_display_options_message_color;'>$mbj_notify_bar_display_options_message</p>
		</div>
		</div>";
    	}
		
}

?>