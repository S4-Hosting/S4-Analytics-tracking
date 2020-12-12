<?php
/**
 * @package SS_TrackingCodeForMatomo\Models
 */

if ( !defined( 'SS_TRACKINGCODEFORMATOMO_VERSION' ) ) {
	exit;
}

/**
 * Options model class.
 *
 * Handles all option-related operations.
 *
 * @since 1.0.0
 */
abstract class SS_TrackingCodeForMatomo_ModelOptions {
	/**
	 * Set up Wordpress.
	 *
	 * Prepares Wordpress' options subsystem.
	 *
	 * @see sanitize_address()
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function set_up() {
		add_option( 'SS_TrackingCodeForMatomo', static::get_defaults() , '', 'no' );

		register_setting( 'SS_TrackingCodeForMatomo', 'SS_TrackingCodeForMatomo', array( 'SS_TrackingCodeForMatomo_ControllerBackend', 'sanitize_options' ) );
	}

	/**
	 * Migrate saved options.
	 *
	 * Gets the options stored in Wordpress.
	 *
	 * @since 1.0.8
	 *
	 * @return bool 'true' on success, 'false' otherwise.
	 */
	public static function migrate_options() {
		$options = get_option( 'MB_PiwikTracking' );
		if ( !empty( $options ) ) {
			update_option( 'SS_MatomoTracking', $options );
			delete_option( 'MB_PiwikTracking' );
			return true;
		}

		$options = get_option( 'SS_PiwikTracking' );
		if ( !empty( $options ) ) {
			update_option( 'SS_MatomoTracking', $options );
			delete_option( 'SS_PiwikTracking' );
			return true;
		}

		$options = get_option( 'SS_MatomoTracking' );
		if ( !empty( $options ) ) {
			update_option( 'SS_TrackingCodeForMatomo', $options );
			delete_option( 'SS_MatomoTracking' );
			return true;
		}

		return false;
	}

	/**
	 * Get saved options.
	 *
	 * Gets the options stored in Wordpress.
	 *
	 * @since 1.0.0
	 *
	 * @return array The stored options.
	 */
	public static function get_options() {
		$options = get_option( 'SS_TrackingCodeForMatomo' );
		return array_replace(static::get_defaults(), $options);
	}

	/**
	 * Get saved option.
	 *
	 * Gets one of the options stored in Wordpress.
	 *
	 * @see get_options()
	 *
	 * @since 1.0.1
	 *
	 * @param string $name The name of the option to retrieve.
	 * @return mixed The value, or 'null' if the option doesn't exist.
	 */
	public static function get_option( $name ) {
		$options = static::get_options();
		if ( array_key_exists( $name, $options ) ) {
			return $options[$name];
		}
		return null;
	}

	/**
	 * Get default options.
	 *
	 * Gets the default options for this plugin.
	 *
	 * @since 1.0.11
	 *
	 * @return array The default options.
	 */
	public static function get_defaults() {
		$defaults = array(
			'enable' => false,
			'address' => $_SERVER["SERVER_NAME"] . '/matomo',
			'ssl_compat' => false,
			'site_id' => 0,
			'enable_cookies' => 1,
			'log_usernames' => false,
			'use_old_username_logging_method' => true, // ToDo: Set this to false in a future version. (Added on 1.1.2 .)
			'heartbeat_timer' => 0,
		);
		return $defaults;
	}

	/**
	 * Sanitize the new options.
	 *
	 * Checks the supplied options for errors.
	 * If an option is not valid, its value is replaced with the previously stored one.
	 *
	 * @see get_options()
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_options {
	 *	 The array of options to sanitize.
	 *	 @type bool 'enable' Enable the plugin or not.
	 *	 @type string 'address' Address of the Matomo install to use.
	 *	 @type bool 'ssl_compat' Is Matomo compatible SSL access or not.
	 *	 @type int 'site_id' The id of this site in Matomo's configuration.
	 *						 Accepts any integer number greater than zero.
	 * }
	 * @return array A list of found errors.
	 */
	public static function sanitize_options( &$new_options ) {
		$old_options = static::get_options();
		$errors = array();

		static::sanitize_checkbox( $new_options['enable'] );
		if ( !static::sanitize_address( $new_options['address'] ) ) {
			$new_options['address'] = $old_options['address'];
			$errors[] = 'address';
		}
		static::sanitize_checkbox( $new_options['ssl_compat'] );
		if ( !static::sanitize_id( $new_options['site_id'] ) ) {
			$new_options['site_id'] = $old_options['site_id'];
			$errors[] = 'site_id';
		}
		static::sanitize_checkbox( $new_options['enable_cookies'] );
		static::sanitize_checkbox( $new_options['log_usernames'] );
		static::sanitize_checkbox( $new_options['use_old_username_logging_method'] );
		if ( !static::sanitize_uint( $new_options['heartbeat_timer'] ) ) {
			$new_options['heartbeat_timer'] = $old_options['heartbeat_timer'];
			$errors[] = 'heartbeat_timer';
		}

		return $errors;
	}

	/**
	 * Sanitize checkbox.
	 *
	 * Converts value to its boolean equivalent.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value The value to sanitize.
	 *
	 * @return bool Always returns 'true'.
	 */
	public static function sanitize_checkbox( &$value ) {
		$value = (bool) $value;
		return true;
	}

	/**
	 * Sanitize address.
	 *
	 * Converts value to a valid URL - but removes its protocol.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Returns 'true' if the value is a valid URL (without protocol) after sanitization, or 'false' if otherwise.
	 */
	public static function sanitize_address( &$value ) {
		// remove whitespace
		$value = preg_replace( '{[\s]*}', '', $value );
		// discard protocol
		$value = preg_replace( '{^https?://}i', '', $value, 1 );
		// discard port
		//preg_replace( '{:[0-9]+/?}', '', $value, 1 );
		// remove invalid characters
		$value = preg_replace( '{[^a-zA-Z0-9\-_/.:#?&%]*}', '', $value );
		// remove trailing slash
		$value = preg_replace( '{/$}', '', $value );

		// check length and format of address
		if ( strlen( $value ) < 6 || !preg_match( '{^localhost|([a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+)(:[0-9]{1,5})?(/[a-zA-Z0-9\-_.#?&%]*)*$}', $value ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Sanitize id.
	 *
	 * Converts value to a valid integer number.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Returns 'true' if after sanitization the value is an integer number greater than zero, or 'false' if otherwise.
	 */
	public static function sanitize_id( &$value ) {
		if ( !static::sanitize_uint( $value ) || $value < 1 ) {
			return false;
		}
		return true;
	}

	/**
	 * Sanitize unsigned integer.
	 *
	 * Converts value to a valid integer number.
	 *
	 * @since 1.0.11
	 *
	 * @return bool Returns 'true' if after sanitization the value is an integer number equal to or greater than zero, or 'false' if otherwise.
	 */
	public static function sanitize_uint( &$value ) {
		// remove invalid characters
		$value = preg_replace( '$[^0-9]*$', '', $value );
		$value = (int) $value;

		if ( $value < 0 ) {
			return false;
		}
		return true;
	}

	/**
	 * Get extra data.
	 *
	 * Get any extra required data.
	 *
	 * @since 1.0.4
	 *
	 * @return array The data.
	 */
	public static function get_data() {
		$data = array();
		if ( static::get_option( 'log_usernames' ) ) {
			if ( is_user_logged_in() ) {
				$currentUser = wp_get_current_user();
				$data['username'] = $currentUser->user_nicename;
			}
			// if user isn't logged in or something went wrong
			if ( !isset( $data['username'] ) ) {
				$data['username'] = '_unknown';
			}
		}
		return $data;
	}
}
