<?php
/**
 * @package SS_TrackingCodeForMatomo
 */

/*
Plugin Name: Tracking code for Matomo, by Sergio Santos
Plugin URI: https://www.sergiosantos.me/
Description: Add a tracking code for Matomo to your WordPress website.
Version: 1.1.3
Author: Sergio Santos
Author URI: https://www.sergiosantos.me/
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: piwik-tracking-by-mente-binaria
Domain Path: /assets/i18n
*/

/*
Copyright (C) 2013-2020  Sergio Santos  (email : ipse@sergiosantos.me)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 3
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( !function_exists( 'add_action' ) ) {
	exit;
}

// Set some constants required throughout the application.
define( 'SS_TRACKINGCODEFORMATOMO_VERSION', '1.1.3' );
define( 'SS_TRACKINGCODEFORMATOMO_SLUG', 'piwik-tracking-by-mente-binaria' );
define( 'SS_TRACKINGCODEFORMATOMO_PATH', realpath( dirname( __FILE__ ) ) );

/**
 * Plugin's main controller class.
 *
 * Coordinates all of the plugin's functioning.
 *
 * @since 1.0.0
 */
abstract class SS_TrackingCodeForMatomo {
	/**
	 * Initialise plugin.
	 *
	 * Performs all of the required actions for the plugin to work.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function init() {
		// Load the translations.
		load_plugin_textdomain( SS_TRACKINGCODEFORMATOMO_SLUG, false, basename( dirname( __FILE__ ) ) . '/assets/i18n' );

		// Load the controllers.
		require_once( 'controllers/backend.class.php' );
		require_once( 'controllers/frontend.class.php' );

		// Set things up.
		SS_TrackingCodeForMatomo_ControllerBackend::init();
		SS_TrackingCodeForMatomo_ControllerFrontend::init();

		// ToDo: Find a better way to do this.
		static::update();
	}

	/**
	 * Update plugin.
	 *
	 * Performs all of the required actions upon updating the plugin.
	 *
	 * @since 1.0.8
	 *
	 * @return void
	 */
	public static function update() {
		require_once( 'controllers/backend.class.php' );
		SS_TrackingCodeForMatomo_ControllerBackend::update();
	}
}

// Update the plugin.
register_activation_hook( __FILE__, array( 'SS_TrackingCodeForMatomo', 'update' ) );

// Load this plugin.
add_action( 'init', array( 'SS_TrackingCodeForMatomo', 'init') );

