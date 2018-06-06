<?php
	/*
	Plugin Name: qdt-components
	Plugin URI: https://github.com/qlik-demo-team/qdt-wordpress-plugin
	Description: A plugin that uses qdt-components to connect to Qlik Sense. 
		- Unzip the plugin into your plugins directory
		- Activate from the admin panel
		- Go to "qdt-components" settings and add the host, virtual proxy and the app id
		- then add the shortcode into your posts "[sense-object qvid="ZwjJQq" height="400" nointeraction="true"]"
	Version: 0.0.1
	Author: yianni.ververis@qlik.com
	License: MIT
	Text Domain: qdt-components
	Domain Path: /languages
	*/
	defined('ABSPATH') or die("No script kiddies please!"); //Block direct access to this php file

    define( 'QDT_COMPONENTS_PLUGIN_VERSION', '0.0.1' );
    define( 'QDT_COMPONENTS_PLUGIN_MINIMUM_WP_VERSION', '4.0' );
    define( 'QDT_COMPONENTS_PLUGIN_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );

    // Register the js script
    wp_register_script( 'qdt-components-js', QDT_COMPONENTS_PLUGIN_PLUGIN_DIR . 'scripts/index.js', array(), QDT_COMPONENTS_PLUGIN_VERSION, $in_footer = true );
    wp_register_script( 'qdt-components-js-lib', QDT_COMPONENTS_PLUGIN_PLUGIN_DIR . 'scripts/qdt-components/qdt-components.js', array(), QDT_COMPONENTS_PLUGIN_VERSION, $in_footer = true );
        
    // Localize the script with new data (pass it to the index.js)
    $qdt = esc_attr( get_option('qdt') );
    $translation_array = array(	
        'version'		=> QDT_COMPONENTS_PLUGIN_VERSION,
        'qdt_host'		=> esc_attr( get_option('qdt_host') ),
        'qdt_prefix'	=> esc_attr( get_option('qdt_prefix') ),
        'qdt_appId'		=> esc_attr( get_option('qdt_appId') ),
        'qdt_port'		=> esc_attr( get_option('qdt_port') ),
        'qdt_secure'	=> esc_attr( get_option('qdt_secure') )						
    );
    wp_localize_script( 'qdt-components-js', 'vars', $translation_array );

    // Settings Menu    
	add_action('admin_menu', 'qdt_components_plugin_menu');
	function qdt_components_plugin_menu() {
		add_menu_page( esc_attr__('Qdt-components Plugin Settings', 'qdt-components'), 'Qdt-components', 'administrator', 'qdt_components_plugin_settings', 'qdt_components_plugin_settings_page', QDT_COMPONENTS_PLUGIN_PLUGIN_DIR . 'assets/qlik.png', null );
    }
    
	// Create the options to be saved in the Database
	add_action( 'admin_init', 'qdt_components_plugin_settings' );	
	function qdt_components_plugin_settings() {
		register_setting( 'qdt-components-plugin-settings-group', 'qdt_host' );
		register_setting( 'qdt-components-plugin-settings-group', 'qdt_prefix' );
		register_setting( 'qdt-components-plugin-settings-group', 'qdt_appId' );
		register_setting( 'qdt-components-plugin-settings-group', 'qdt_port' );
		register_setting( 'qdt-components-plugin-settings-group', 'qdt_secure' );
    }
    
	// Create the Admin Setting Page
	function qdt_components_plugin_settings_page() {
		?>
		<div class="wrap">
			<h2><?php esc_html__('Qdt-components Plugin Settings', 'qdt-components'); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'qdt-components-plugin-settings-group' ); ?>
				<?php do_settings_sections( 'qdt-components-plugin-settings-group' ); ?>
				<div style="border-bottom:1px solid #ccc;padding-bottom:35px;"><h1>Qlik Sense Settings</h1></div>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e('Host', 'qdt-components'); ?>:</th>
						<td><input type="text" name="qdt_host" size="50" value="<?php echo esc_attr( get_option('qdt_host') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e('Virtual Proxy (Prefix)', 'qdt-components'); ?>:</th>
						<td><input type="text" name="qdt_prefix" size="5" value="<?php echo esc_attr( get_option('qdt_prefix') ); ?>" /></td>
					</tr>	
					<tr valign="top">
						<th scope="row"><?php esc_html_e('Port', 'qdt-components'); ?>:</th>
						<td><input type="text" name="qdt_port" size="5" value="<?php echo esc_attr( get_option('qdt_port') ); ?>" /></td>
					</tr>	
					<tr valign="top">
						<th scope="row"><?php esc_html_e('Is it over Https?', 'qdt-components'); ?></th>
						<td><input type="checkbox" name="qdt_secure" value="1" <?php checked( esc_attr( get_option('qdt_secure') ), 1 ); ?> /></td>
					</tr>	
					<tr valign="top">
						<th scope="row"><?php esc_html_e('App ID', 'qdt-components'); ?>:</th>
						<td><input type="text" name="qdt_appId" size="50" value="<?php echo esc_attr( get_option('qdt_appId') ); ?>" /></td>
					</tr>			
					<tr valign="top">
						<th scope="row">&nbsp;</th>
						<td><?php submit_button(); ?></td>
					</tr>
				</table>
				
				<div style="border-top:1px solid #ccc;padding-top:35px;"><a href="https://www.qlik.com/us/"><img src="<?php echo QDT_COMPONENTS_PLUGIN_PLUGIN_DIR . "assets/QlikLogo-RGB.png"?>" width="200"></a></div>
			</form>
		</div>
		<?php
    }
    
    // Create the Html Snippet for use inside the posts/pages
	// [qdt-component type="QdtViz" id="ZwjJQq" height="400"]
	function qdt_component_func( $atts ) {
        wp_localize_script( 'qdt-components-js', 'atts', $atts );
		wp_enqueue_script( 'qdt-components-js-lib' );
		wp_enqueue_script( 'qdt-components-js' );
		
		return "<div id=\"qdt_{$atts['id']}\"></div>";
	}
    add_shortcode( 'qdt-component', 'qdt_component_func' );
    
	// Uninstall the settings when the plugin is uninstalled
	function qdt_components_uninstall() {
		unregister_setting( 'qdt-components-plugin-settings-group', 'qdt_host' );
		unregister_setting( 'qdt-components-plugin-settings-group', 'qdt_prefix' );
		unregister_setting( 'qdt-components-plugin-settings-group', 'qdt_id' );
		unregister_setting( 'qdt-components-plugin-settings-group', 'qdt_port' );
		unregister_setting( 'qdt-components-plugin-settings-group', 'qdt_secure' );
	}
	register_uninstall_hook(  __FILE__, 'qdt_components_uninstall' );
?>