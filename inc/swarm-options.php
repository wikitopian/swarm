<?php

class Swarm_Options {
	private $prefix;
	private $options;

	public function __construct( $prefix, $options ) {
		$this->prefix  = $prefix;
		$this->options = $options;

		if ( is_admin() ) {
			add_action( 'admin_init', array( &$this, 'register' ) );
			add_action( 'admin_menu', array( &$this, 'menu' ) );
		}
	}
	public function register() {
		register_setting( $this->prefix, $this->prefix );
	}
	public function menu() {
		add_options_page(
			'Swarm Options',
			'Swarm Options',
			'manage_options',
			$this->prefix,
			array( $this, 'page' )
		);
	}
	public function page() {
?>

<div class="wrap">
<h2>Swarm Options</h2>

<form method="post" action="options.php">
	<?php settings_fields( $this->prefix ); ?>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Maintenance Mode</th>
		<td>
			<input
				type="checkbox"
				name="<?php echo sanitize_text_field( $this->prefix ); ?>[maintenance]"
				value="1"
				<?php checked( $this->options['maintenance'] ) ?>
				/>
		</td>
		</tr>
	</table>
	<?php submit_button(); ?>
</form>
</div>

<?php
	}
}

?>
