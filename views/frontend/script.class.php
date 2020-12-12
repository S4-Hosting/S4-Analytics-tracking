<?php
/**
 * @package SS_TrackingCodeForMatomo\Views\Frontend
 */

if ( !defined( 'SS_TRACKINGCODEFORMATOMO_VERSION' ) ) {
	exit;
}

/**
 * Frontend script class.
 *
 * Outputs the frontend data.
 *
 * @since 1.0.0
 */
abstract class SS_TrackingCodeForMatomo_ViewFrontendScript {
	/**
	 * Output code.
	 *
	 * Outputs JavaScript code according to the options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $options The values defined in the backend.
	 * @return void
	 */
	public static function output( $options, $data = NULL ) {
?>

<!-- BEGIN Tracking code for Matomo -->
<script type="text/javascript">var _paq = window._paq || []; <?php
		if ( !$options['enable_cookies'] ) {
			echo '_paq.push(["disableCookies"]); ';
		}
		if ( $options['heartbeat_timer'] ) {
			echo '_paq.push(["enableHeartBeatTimer", ' . $options['heartbeat_timer'] . ']); ';
		}
		if ( $options['log_usernames'] && isset( $data['username'] ) ) {
			if ( !$options['use_old_username_logging_method'] ) {
				echo '_paq.push(["setUserId", "' . $data['username'] . '"]); ';
			}
			else {
				$customVars[1] = array( 'Visitor', $data['username'] );
				echo '_paq.push(["setCustomVariable",1,"Visitor","' . $data['username'] . '","visit"]); ';
			}
		}
		if ( !is_search() ) {
			echo '_paq.push(["trackPageView"]); ';
		}
		else {
			$searchQuery = get_search_query( false );
			$search = new WP_Query( 's=' . urlencode( $searchQuery ) . '&showposts=0' );
			$searchResultCount = intval( $search->found_posts );
			echo '_paq.push(["trackSiteSearch", ' . json_encode( $searchQuery ) . ', "", ' . $searchResultCount . ']); ';
		}
?>_paq.push(["enableLinkTracking"]); (function() { var u=<?php
		echo ( $options['ssl_compat'] ? '"https' : '"http' ) . '://' . $options['address'] . '/"; ';
?>_paq.push(["setTrackerUrl", u+"piwik.php"]); _paq.push(["setSiteId", "<?php echo $options['site_id']; ?>"]); var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript"; g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s); })();</script>
<!-- END Tracking code for Matomo -->

<?php
	}

	/**
	 * Output code.
	 *
	 * Outputs HTML code according to the options.
	 *
	 * @since 1.0.10
	 *
	 * @param array $options The values defined in the backend.
	 * @return void
	 */
	public static function alt_output( $options, $data = NULL ) {
?>

<!-- BEGIN Alternate tracking code for Matomo -->
<noscript><img src="<?php echo ( $options['ssl_compat'] ? 'https' : 'http' ) . '://' . $options['address']; ?>/piwik.php?<?php
		echo 'idsite=' . $options['site_id'];
		echo '&amp;rec=1';
		$customVars = array();
		if ( $options['log_usernames'] && isset( $data['username'] ) ) {
			if ( !$options['use_old_username_logging_method'] ) {
				echo '&amp;uid=' . $data['username'];
			}
			else {
				$customVars[1] = array( 'Visitor', $data['username'] );
			}
		}
		if ( !empty($customVars) ) {
			echo '&amp;_cvar=' . urlencode(json_encode($customVars));
		}
		if ( is_search() ) {
			$searchQuery = get_search_query( false );
			$search = new WP_Query( 's=' . urlencode( $searchQuery ) . '&showposts=0' );
			$searchResultCount = intval( $search->found_posts );
			echo '&amp;search=' . urlencode($searchQuery);
			echo '&amp;search_count=' . urlencode($searchResultCount);
		}

?>" style="margin:0; border:0; padding:0; vertical-align:middle;" alt="" /></noscript>
<!-- END Alternate tracking code for Matomo -->

<?php
	}
}
