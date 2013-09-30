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

		add_action( 'login_message', array( &$this, 'do_message' ) );
	}
	public function do_style() {
		echo '<link rel="stylesheet" id="custom_wp_admin_css"  href="';
		echo esc_html( plugin_dir_path( __FILE__ ) ) . '../css/swarm-login.css';
		echo '" type="text/css" media="all" />';

		global $graphene_settings;
		echo '<style type="text/css">';
		echo 'body.login { background-color: ';
		echo sanitize_text_field( $graphene_settings['bg_content_wrapper'] );
		echo ";}\n";
		echo 'body.login div#login h1 a {';
		echo 'background-image: url(';
		echo esc_url( get_header_image() );
		echo ');';
		echo '}';
		echo '</style>';
	}
	public function do_logo_url() {
		return get_bloginfo( 'url' );
	}
	public function do_logo_title() {
		return get_bloginfo( 'description' );
	}
	public function do_message( $message ) {
		if ( !empty( $this->options['message_active'] ) && $this->options['message_active'] ) {
			return '<p class="message">' . $this->options['message'] . '</p>';
		} else {
			return $message;
		}
	}
}

?>
