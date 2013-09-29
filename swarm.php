<?php

/*
 * Plugin Name: Swarm
 * Plugin URI:  http://www.github.com/wikitopian/swarm
 * Description: Maintenance Mode plugin adapted to provide basic admin skin
 * Version:     2.0
 * Author:      @wikitopian
 * Author URI:  http://www.swarmstrategies.com/matt
 * License:     GPL2
 */

require_once 'inc/swarm-options.php'; // settings page

define( 'PREFIX', 'swarm' );

class Swarm {
	private $options;

	private $swarm_options;

	public function __construct() {
		$defaults = array(
			'maintenance' => false,
		);
		$this->options = get_option( PREFIX, $defaults );

		$this->swarm_options = new Swarm_Options( PREFIX, $this->options );

		add_action( 'init', array( &$this, 'initialize' ) );
	}
	public function initialize() {
	}
	public static function uninstall() {
		if ( !current_user_can( 'activate_plugins' ) ) {
			return;
		}
		delete_option( PREFIX );
	}
}
$swarm = new Swarm();
register_uninstall_hook( __FILE__, array( 'Swarm', 'uninstall' ) );

?>
