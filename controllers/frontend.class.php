<?php
/**
 * @package SS_TrackingCodeForMatomo\Controllers\Frontend
 */

if ( !defined( 'SS_TRACKINGCODEFORMATOMO_VERSION' ) ) {
	exit;
}

/**
 * Frontend controller class.
 *
 * Controls the frontend interface.
 *
 * @since 1.0.1
 */
abstract class SS_TrackingCodeForMatomo_ControllerFrontend {
	/**
	 * Set up.
	 *
	 * Performs all of the required actions for the frontend to work.
	 *
	 * @see output_code()
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public static function init() {
		// If the required files exist, prepare Wordpress.
		if ( is_file( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' )
				&& is_file( SS_TRACKINGCODEFORMATOMO_PATH . '/views/frontend/script.class.php' ) ) {
			add_action( 'wp_head', array( __CLASS__, 'output_head_code' ), 9999 );
			add_action( 'wp_footer', array( __CLASS__, 'output_footer_code' ), 9999 );
		}
	}

	/**
	 * Output the code.
	 *
	 * Gets the stored options and outputs the script to the head.
	 *
	 * @since 1.0.10
	 *
	 * @return void
	 */
	public static function output_head_code() {
		// Load the model.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' );
		// Load the view.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/views/frontend/script.class.php' );

		// Get the stored options.
		$options = SS_TrackingCodeForMatomo_ModelOptions::get_options();
		// If the plugin is enabled, display the code.
		if ( $options['enable'] ) {
			// Get any extra required data.
			$data = SS_TrackingCodeForMatomo_ModelOptions::get_data();
			SS_TrackingCodeForMatomo_ViewFrontendScript::output( $options, $data );
		}
	}

	/**
	 * Output the code.
	 *
	 * Gets the stored options and outputs the script to the footer.
	 *
	 * @since 1.0.10
	 *
	 * @return void
	 */
	public static function output_footer_code() {
		// Load the model.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/models/options.class.php' );
		// Load the view.
		require_once( SS_TRACKINGCODEFORMATOMO_PATH . '/views/frontend/script.class.php' );

		// Get the stored options.
		$options = SS_TrackingCodeForMatomo_ModelOptions::get_options();
		// If the plugin is enabled, display the code.
		if ( $options['enable'] ) {
			// Get any extra required data.
			$data = SS_TrackingCodeForMatomo_ModelOptions::get_data();
			SS_TrackingCodeForMatomo_ViewFrontendScript::alt_output( $options, $data );
		}
	}
}
