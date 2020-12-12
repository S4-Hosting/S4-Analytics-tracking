<?php
/**
 * @package SS_TrackingCodeForMatomo\Controllers\Backend
 */

if ( !defined( 'SS_TRACKINGCODEFORMATOMO_VERSION' ) ) {
	exit;
}

/**
 * Backend controller class.
 *
 * Controls the backend interface.
 *
 * @since 1.0.1
 */
abstract class SS_TrackingCodeForMatomo_ControllerBackend {
	/**
	 * Initialise backend.
	 *
	 * Performs all of the required actions for the backend to work.
	 *
	 * @see set_up()
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public static function init() {
		// If the required files exist and the current user is admin, prepare Wordpress.
		if ( is_file( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' )
				&& is_file( SS_TRACKINGCODEFORMATOMO_PATH . '/views/backend/settings.class.php' )
				&& is_admin() ) {
			add_action( 'admin_menu', array( __CLASS__, 'set_up' ) );
		}
	}

	/**
	 * Update.
	 *
	 * Performs all of the required actions upon updating.
	 *
	 * @see set_up()
	 *
	 * @since 1.0.8
	 *
	 * @return void
	 */
	public static function update() {
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' );
		SS_TrackingCodeForMatomo_ModelOptions::migrate_options();
	}

	/**
	 * Set up backend.
	 *
	 * Does the necessary Wordpress configurations.
	 *
	 * @see SS_TrackingCodeForMatomo_ModelOptions::set_up(),SS_TrackingCodeForMatomo_ViewBackendSettings::set_up()
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public static function set_up() {
		// Load the model.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' );
		// Load the view.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/views/backend/settings.class.php' );

		SS_TrackingCodeForMatomo_ModelOptions::set_up();
		SS_TrackingCodeForMatomo_ViewBackendSettings::set_up();
	}

	/**
	 * Sanitize options.
	 *
	 * Checks and corrects the supplied options. Displays any errors found.
	 *
	 * @see SS_TrackingCodeForMatomo_ModelOptions::sanitize_options(),SS_TrackingCodeForMatomo_ViewBackendSettings::output_error()
	 *
	 * @since 1.0.1
	 *
	 * @param array $options The array of options to sanitize.
	 * @return array The sanitized options.
	 */
	public static function sanitize_options( $options ) {
		// Load the model.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' );
		// Load the view.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/views/backend/settings.class.php' );

		$errors = SS_TrackingCodeForMatomo_ModelOptions::sanitize_options( $options );

		foreach( $errors as &$error ) {
			SS_TrackingCodeForMatomo_ViewBackendSettings::output_error( $error );
		}

		return $options;
	}

	/**
	 * Add settings link.
	 *
	 * Adds the settings link to the list of links displayed in the plugins page.
	 *
	 * @see SS_TrackingCodeForMatomo_ViewBackendSettings::get_settings_link()
	 *
	 * @since 1.0.1
	 *
	 * @param array $links The original plugin links.
	 * @return array The updated plugin links.
	 */
	public static function add_settings_link( $links ) {
		// Load the view.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/views/backend/settings.class.php' );

		$link = SS_TrackingCodeForMatomo_ViewBackendSettings::get_settings_link( admin_url( 'options-general.php?page=' . SS_TRACKINGCODEFORMATOMO_SLUG ) );
		array_unshift( $links, $link );

		return $links;
	}

	/**
	 * Output settings page.
	 *
	 * Outputs the HTML code of the settings page.
	 *
	 * @see SS_TrackingCodeForMatomo_ViewBackendSettings::output_page()
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function output_settings_page() {
		// Load the view.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/views/backend/settings.class.php' );

		SS_TrackingCodeForMatomo_ViewBackendSettings::output_page();
	}

	/**
	 * Output section header code.
	 *
	 * Outputs the HTML code to display at the top of the General section.
	 * Though required, it is useless for the time being - but it may still have some use in the future.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public static function output_settings_section() {
	}

	/**
	 * Output form fields.
	 *
	 * Depending on the arguments received, outputs a field for the settings form.
	 * It gets the saved options to display the field accordingly.
	 *
	 * @see SS_TrackingCodeForMatomo_ModelOptions::get_options(),SS_TrackingCodeForMatomo_ViewBackendSettings::output_field()
	 *
	 * @since 1.0.1
	 *
	 * @param array $args {
	 *     An array of arguments.
	 *     @type type 'id' The name of the option.
	 *                     Accepts 'enable', 'address', 'ssl_compat', 'site_id'.
	 *     @type type 'label_for' The unique id of the option's field.
	 *                            Accepts 'SS_TrackingCodeForMatomo-enable', 'SS_TrackingCodeForMatomo-address', 'SS_TrackingCodeForMatomo-ssl_compat', 'SS_TrackingCodeForMatomo-site_id'.
	 * }
	 * @return void
	 */
	public static function output_settings_field( $args ) {
		// Load the model.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' );
		// Load the view.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/views/backend/settings.class.php' );

		$name = array_key_exists( 'id', $args ) ? $args['id'] : str_replace( 'SS_TrackingCodeForMatomo-', '', $args['label_for'] );
		$value = SS_TrackingCodeForMatomo_ModelOptions::get_option( $name );
		SS_TrackingCodeForMatomo_ViewBackendSettings::output_field( $name, $value );
	}
}
