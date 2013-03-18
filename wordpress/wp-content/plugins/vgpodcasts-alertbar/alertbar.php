<?php
    /* 
    Plugin Name: VGPodcasts AlertBar Plugin 
    Plugin URI: http://vgpodcasts.com 
    Description: Adds an configurable alertbar to the top of your Wordpress blog pages when enabled. I use it to advertise when I'm recording a live podcast on my site, but you may have some other use for it. Enjoy!
	Author: Lloyd Hannesson
    Version: 1.5.1
    Author URI: http://dasme.org
    */  

	add_action('admin_init', 'vgp_alertbar_init' );
	add_action('admin_menu', 'vgp_alertbar_add_page');
	add_action('wp_print_styles', 'vgp_alertbar_css');
	add_action('admin_print_styles', 'vgp_alertbar_css');
	add_action('wp_dashboard_setup', 'vgp_add_dashboard_widget' );


	// Show the bar in the footer, the CSS will force it to the top of the screen
	add_action('wp_footer', 'vgp_alertbar_show');	
	
	// Init plugin options to white list our options
	function vgp_alertbar_init(){
		register_setting( 'vgp_alertbar_options', 'vgp_alertbar', 'vgp_alertbar_validate' );
	}

	function vgp_add_dashboard_widget() {
		wp_add_dashboard_widget( 'vgp-custom-widget', 'VGP AlertBar Options', 'vgp_dashboard_widget' );
	}

	function vgp_dashboard_widget() {
	?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php 
					settings_fields('vgp_alertbar_options');
					$options = get_option('vgp_alertbar'); 
					if($options['alertmessage'] == "") { $options['alertmessage'] = "Come Join Us LIVE! &raquo;"; }
				?>
				<table class="form-table">
					<tr valign="top"><th scope="row">AlertBar enabled?</th>
						<td><input name="vgp_alertbar[enabled]" type="checkbox" value="1" <?php checked('1', $options['enabled']); ?> /></td>
					</tr>
					<tr valign="top"><th scope="row">Linking URL:</th>
						<td><input type="text" size="60" name="vgp_alertbar[liveurl]" value="<?php echo $options['liveurl']; ?>" /></td>
					</tr>
					<tr valign="top"><th scope="row">AlertBar Message:</th>
						<td><input type="text" size="60" name="vgp_alertbar[alertmessage]" value="<?php echo stripslashes($options['alertmessage']); ?>" /></td>
					</tr>
				</table>
				<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /><br/><br/>
				<em>Other options can be configured on the <a href="options-general.php?page=vgp_alertbar">Settings</a> page.</em>
				</p>
			</form>
		</div>			
	<?php
	}

	// Add menu page
	function vgp_alertbar_add_page() {
		add_options_page('VGP AlertBar', 'VGP AlertBar',1, 'vgp_alertbar', 'vgp_alertbar_do_page');
	}

	// Draw the menu page itself
	function vgp_alertbar_do_page() {
				
		?>
		<div class="wrap">
			<h2>VGP AlertBar Options</h2>
			<form method="post" action="options.php">
				<?php 
					settings_fields('vgp_alertbar_options');
					$options = get_option('vgp_alertbar'); 
					if($options['alertbg'] == "") { $options['alertbg'] = "#FF0000"; }
					if($options['alerttxt'] == "") { $options['alerttxt'] = "#FFFFFF"; }
					if($options['alertmessage'] == "") { $options['alertmessage'] = "Come Join Us LIVE! &raquo;"; }
				?>
				<table class="form-table">
					<tr valign="top"><th scope="row">AlertBar enabled?</th>
						<td><input name="vgp_alertbar[enabled]" type="checkbox" value="1" <?php checked('1', $options['enabled']); ?> /></td>
					</tr>
					<tr valign="top"><th scope="row">Linking URL:</th>
						<td><input type="text" size="60" name="vgp_alertbar[liveurl]" value="<?php echo $options['liveurl']; ?>" /></td>
					</tr>
					<tr valign="top"><th scope="row">AlertBar Message:</th>
						<td><input type="text" size="60" name="vgp_alertbar[alertmessage]" value="<?php echo stripslashes($options['alertmessage']); ?>" /></td>
					</tr>
					<tr valign="top"><th scope="row">AlertBar Background Color:</th>
						<td><input type="text" size="20" name="vgp_alertbar[alertbg]" value="<?php echo $options['alertbg']; ?>" /> &nbsp; &nbsp; <em>Defaults to Red: #FF0000</em></td>
					</tr>
					<tr valign="top"><th scope="row">AlertBar Text Color:</th>
						<td><input type="text" size="20" name="vgp_alertbar[alerttxt]" value="<?php echo $options['alerttxt']; ?>" /> &nbsp; &nbsp; <em>Defaults to White: #FFFFFF</em></td>
					</tr>
				</table>
				<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
			
			<hr/>
					
			<h2>Preview</h2>
			<p>This is what your AlertBar will look like on your site.</p>
			
			<?php vgp_alertbar_showAdmin(); ?>
			
			<br/><br/>
			<p><em>Note: If you are running any caching plugins, you may have to clear your cache after activating and deactivating the AlertBar. I've seen some cases where it wasn't showing when it was supposed to, or hung around longer than I wanted.</em></p>
			
		</div>
		
		<?php	
	}

	// Display the alert
	function vgp_alertbar_show() {
		
		$options = get_option('vgp_alertbar');
		
		if($options['enabled'] == true || $bypass == true) {
			?>
				<div id="alertbarContainer">
					<div class="alertbar" style="background: <?php echo $options['alertbg']; ?> ">
						<p><a href="<?php echo $options['liveurl']; ?>" style="color: <?php echo $options['alerttxt']; ?> "><?php echo stripslashes($options['alertmessage']); ?></a></p>
					</div>
				</div>
			<?php
		} 
	}

	function vgp_alertbar_showAdmin() {

		$options = get_option('vgp_alertbar');
		if($options['alertbg'] == "") { $options['alertbg'] = "#FF0000"; }
		if($options['alerttxt'] == "") { $options['alerttxt'] = "#FFFFFF"; }
		if($options['alertmessage'] == "") { $options['alertmessage'] = "Come Join Us LIVE! &raquo;"; }
		
			?>
				<div id="alertbarContainerAdmin">
					<div class="alertbar" style="background: <?php echo $options['alertbg']; ?> ">
						<p><a href="<?php echo $options['liveurl']; ?>" style="color: <?php echo $options['alerttxt']; ?> "><?php echo stripslashes($options['alertmessage']); ?></a></p>
					</div>
				</div>
			<?php
	}

	// Sanitize and validate input. Accepts an array, return a sanitized array.
	function vgp_alertbar_validate($input) {
		$input['enabled'] = ( $input['enabled'] == 1 ? 1 : 0 );
		$input['alertmessage'] =  wp_filter_nohtml_kses($input['alertmessage']);
		$input['liveurl'] =  wp_filter_nohtml_kses($input['liveurl']);

		$input['alertbg'] = (preg_match('/^#([0-9a-f]{1,2}){3}$/i', $input['alertbg']) == true ? $input['alertbg'] : "" );
		$input['alertbg'] = ($input['alertbg'] == "" ? "#FF0000" : $input['alertbg']);
		
		$input['alerttxt'] = (preg_match('/^#([0-9a-f]{1,2}){3}$/i', $input['alerttxt']) == true ? $input['alerttxt'] : "" );
		$input['alerttxt'] = ($input['alerttxt'] == "" ? "#FFFFFF" : $input['alerttxt']);
		return $input;
	}
	
	// Enqueue style-file, if it exists.
	function vgp_alertbar_css() {
        $myStyleUrl = WP_PLUGIN_URL . '/vgpodcasts-alertbar/style.css';
        $myStyleFile = WP_PLUGIN_DIR . '/vgpodcasts-alertbar/style.css';
        if ( file_exists($myStyleFile) ) {
            wp_register_style('alertbar', $myStyleUrl);
            wp_enqueue_style( 'alertbar');
        }
    }
?>
