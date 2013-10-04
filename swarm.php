<?php

/*
 * Plugin Name: Swarm Tweaks
 * Plugin URI:  http://www.github.com/wikitopian/swarm
 * Description: Collection of tweaks and improvements
 * Version:     2.0
 * Author:      @wikitopian
 * Author URI:  http://www.swarmstrategies.com/matt
 * License:     GPLv2
 */

require_once 'inc/swarm-options.php'; // settings page
require_once 'inc/swarm-login.php';   // login page customization

define( 'PREFIX', 'swarm' );

class Swarm {
	private $options;

	private $swarm_options;
	private $swarm_login;

	public function __construct() {
		$defaults = array(
			'maintenance' => false,
			'message_active' => false,
			'message' => '',
		);
		$this->options = get_option( PREFIX, $defaults );

		$this->swarm_options = new Swarm_Options( PREFIX, $this->options );
		$this->swarm_login   = new Swarm_Login( PREFIX, $this->options );

		add_action( 'wp_dashboard_setup', array( &$this, 'remove_db_widgets' ) );

		add_action( 'init', array( &$this, 'initialize' ) );
		add_action( 'graphene_before_content-main', array( &$this, 'do_message' ) );
		add_action( 'graphene_copyright', array( &$this, 'disable_credit' ) );
	}
	public static function remove_image_linking() {
		update_option( 'image_default_link_type', 'none' );
	}
	public static function remove_db_widgets() {
		global $wp_meta_boxes;

		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}
	public function initialize() {
		$this->maintenance_mode();
	}
	public function disable_credit() {
		global $graphene_settings;
		$graphene_settings['disable_credit'] = true;
	}
	public function maintenance_mode() {
		if (
			$this->options['maintenance']
			&& !is_user_logged_in()
			&& !in_array(
				$GLOBALS['pagenow'],
				array( 'wp-login.php', 'wp-register.php' )
			)
		) {
			auth_redirect();
			exit();
		}
	}
	public static function uninstall() {
		if ( !current_user_can( 'activate_plugins' ) ) {
			return;
		}
		delete_option( PREFIX );
	}
	public function do_message() {
		if ( !empty( $this->options['message_active'] ) && $this->options['message_active'] ) {
			echo '<div class="message-block">' . $this->options['message'] . '</div>';
		}
	}
}
$swarm = new Swarm();
register_activation_hook( __FILE__, array( 'Swarm', 'remove_image_linking' ) );
register_uninstall_hook( __FILE__, array( 'Swarm', 'uninstall' ) );

?>
