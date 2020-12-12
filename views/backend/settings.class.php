<?php
/**
 * @package SS_TrackingCodeForMatomo\Views\Backend
 */

if ( !defined( 'SS_TRACKINGCODEFORMATOMO_VERSION' ) ) {
	exit;
}

/**
 * Backend options class.
 *
 * Displays the backend interface.
 *
 * @since 1.0.0
 */
abstract class SS_TrackingCodeForMatomo_ViewBackendSettings {
	/**
	 * Set up Wordpress.
	 *
	 * Prepares Wordpress for the settings page.
	 *
	 * @see SS_TrackingCodeForMatomo_ControllerBackend::add_settings_link(),SS_TrackingCodeForMatomo_ControllerBackend::output_settings_page(),SS_TrackingCodeForMatomo_ControllerBackend::output_settings_section(),SS_TrackingCodeForMatomo_ControllerBackend::output_settings_field()
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function set_up() {
		add_filter( 'plugin_action_links_' . SS_TRACKINGCODEFORMATOMO_SLUG . '/' . SS_TRACKINGCODEFORMATOMO_SLUG . '.php', array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'add_settings_link' ) );

		add_options_page( __( 'Settings for tracking code for Matomo', SS_TRACKINGCODEFORMATOMO_SLUG ), __( 'Tracking code for Matomo', SS_TRACKINGCODEFORMATOMO_SLUG ), 'manage_options', SS_TRACKINGCODEFORMATOMO_SLUG, array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_page' ) );

		add_settings_section( 'general', ''/*__( 'General', SS_TRACKINGCODEFORMATOMO_SLUG )*/, array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_section' ) , SS_TRACKINGCODEFORMATOMO_SLUG );
		add_settings_field( 'SS_TrackingCodeForMatomo-enable', __( 'Enable', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-enable' ) );
		add_settings_field( 'SS_TrackingCodeForMatomo-address', __( 'Address', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-address' ) );
		add_settings_field( 'SS_TrackingCodeForMatomo-ssl_compat', __( 'SSL compatibility', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-ssl_compat' ) );
		add_settings_field( 'SS_TrackingCodeForMatomo-site_id', __( 'Site Id', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-site_id') );
		add_settings_field( 'SS_TrackingCodeForMatomo-enable_cookies', __( 'Enable cookies', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-enable_cookies' ) );
		add_settings_field( 'SS_TrackingCodeForMatomo-log_usernames', __( 'Log usernames', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-log_usernames' ) );
		add_settings_field( 'SS_TrackingCodeForMatomo-use_old_username_logging_method', __( 'Use old username logging method', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-use_old_username_logging_method' ) );
		add_settings_field( 'SS_TrackingCodeForMatomo-heartbeat_timer', __( 'Heartbeat timer', SS_TRACKINGCODEFORMATOMO_SLUG ), array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'output_settings_field' ), SS_TRACKINGCODEFORMATOMO_SLUG, 'general', array( 'label_for' => 'SS_TrackingCodeForMatomo-heartbeat_timer' ) );
	}

	/**
	 * Generate settings link.
	 *
	 * Returns the HTML code of the settings link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url The URL.
	 * @return string The code.
	 */
	public static function get_settings_link( $url ) {
		return '<a href="' . $url . '"> '.__( 'Settings', SS_TRACKINGCODEFORMATOMO_SLUG ).' </a>';
	}

	/**
	 * Output settings page.
	 *
	 * Outputs the HTML code of the settings page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function output_page() {
?>
<div id="SS_TrackingCodeForMatomo" class="wrap"><?php screen_icon(); ?>
<h2><?php _e( 'Settings for tracking code for Matomo', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></h2>
<form method="post" action="options.php">
<?php settings_fields( 'SS_TrackingCodeForMatomo' ); ?>
<?php do_settings_sections( SS_TRACKINGCODEFORMATOMO_SLUG ); ?>
<?php submit_button(); ?>
</form>
</div>
<?php
	}

	/**
	 * Output form fields.
	 *
	 * Depending on the arguments received, outputs a field for the settings form.
	 * It gets the saved options to display the field accordingly.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The name of the option.
	 * @param mixed $value The value of the option.
	 * @return void
	 */
	public static function output_field( $name, $value ) {
		switch ( $name ) {
			case 'enable':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="checkbox" value="1"<?php echo $value ? ' checked="checked"' : ''; ?> />
<p class="description"><?php _e( 'Enable tracking code for Matomo?', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></p>
<?php
				break;
			case 'address':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="text" class="regular-text" value="<?php echo $value; ?>" />
<p class="description"><?php printf( __( 'The address of your Matomo install, without protocol (e.g. %s/matomo).', SS_TRACKINGCODEFORMATOMO_SLUG ), $_SERVER["SERVER_NAME"] ); ?></p>
<?php
				break;
			case 'ssl_compat':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="checkbox" value="1"<?php echo $value ? ' checked="checked"' : ''; ?> />
<p class="description"><?php _e( 'Does your Matomo install support SSL access? (HTTP<b>S</b>://)', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></p>
<?php
				break;
			case 'site_id':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="text" class="regular-text" value="<?php echo $value; ?>" />
<p class="description"><?php _e( 'The id of this site on your Matomo install.', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></p>
<?php
				break;
			case 'enable_cookies':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="checkbox" value="1"<?php echo $value ? ' checked="checked"' : ''; ?> />
<p class="description"><?php _e( 'Do you want Matomo to use cookies?<br/>(Disabling cookies will make some data less accurate.)', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></p>
<?php
				break;
			case 'log_usernames':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="checkbox" value="1"<?php echo $value ? ' checked="checked"' : ''; ?> />
<p class="description"><?php _e( 'Do you want Matomo to log the usernames of logged in users?', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></p>
<?php
				break;
			case 'use_old_username_logging_method':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="checkbox" value="1"<?php echo $value ? ' checked="checked"' : ''; ?> />
<p class="description"><?php _e( 'Do you want to use the old method for logging usernames?<br/>(Will use SetCustomVariable instead of SetUserID. Enable this only if you need to keep backward compatibility with previously tracked data.)', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></p>
<?php
				break;
			case 'heartbeat_timer':
?>
<input id="SS_TrackingCodeForMatomo-<?php echo $name; ?>" name="SS_TrackingCodeForMatomo[<?php echo $name; ?>]" type="text" class="regular-text" value="<?php echo $value; ?>" />
<p class="description"><?php _e( 'The time between heartbeats, in seconds. Set 0 to disable.<br/>(If you\'re unsure of what this is, it\'s better to leave it disabled.)', SS_TRACKINGCODEFORMATOMO_SLUG ); ?></p>
<?php
				break;
			default:
				break;
		}
	}

	/**
	 * Output error messages.
	 *
	 * Sets Wordpress to display an error message according to the supplied option id.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The name of the option.
	 * @return void
	 */
	public static function output_error( $name ) {
		switch ( $name ) {
			case 'address':
				add_settings_error( 'SS_TrackingCodeForMatomo-address', 'invalid-SS_TrackingCodeForMatomo-address', __( 'The "Address" seems invalid.<br />Please check this field and try again.', SS_TRACKINGCODEFORMATOMO_SLUG ) );
				break;
			case 'site_id':
				add_settings_error( 'SS_TrackingCodeForMatomo-site_id', 'invalid-SS_TrackingCodeForMatomo-site_id', __( '"Site Id" must be an integer number greater than zero.<br />Please check this field and try again.', SS_TRACKINGCODEFORMATOMO_SLUG ) );
				break;
			case 'heartbeat_timer':
				add_settings_error( 'SS_TrackingCodeForMatomo-heartbeat_timer', 'invalid-SS_TrackingCodeForMatomo-heartbeat_timer', __( '"Heartbeat timer" must be an integer number equal to or greater than zero.<br />Please check this field and try again.', SS_TRACKINGCODEFORMATOMO_SLUG ) );
				break;
			default:
				break;
		}
	}
}
