<?php

class Swarm_Login {
	private $prefix;
	private $options;

	public function __construct( $prefix, $options ) {
		$this->prefix  = $prefix;
		$this->options = $options;

		add_action( 'login_enqueue_scripts', array( &$this, 'do_style' ) );
		add_action( 'login_headerurl', array( &$this, 'do_logo_url' ) );
		add_action( 'login_headertitle', array( &$this, 'do_logo_title' ) );
	}
	public function do_style() {
		echo '<link rel="stylesheet" id="custom_wp_admin_css"  href="';
		echo esc_html( plugin_dir_path( __FILE__ ) ) . '../css/swarm-login.css';
		echo '" type="text/css" media="all" />';
	}
	public function do_logo_url() {
		return get_bloginfo( 'url' );
	}
	public function do_logo_title() {
		return get_bloginfo( 'description' );
	}
}

?>
