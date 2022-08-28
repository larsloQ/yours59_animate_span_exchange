<?php
/**
 *
 * Plugin Name:  yours59_animate_span_exchange
 * Plugin URI:   https://github.com/larsloQ/yours59_animate_span_exchange
 * Description:  Plugin adds a button to Gutenberg RichTextToolbarButtons allowing you to animate text-spans (exchange the shown text)
 * Author:       larsloQ (larslo.de)
 * Author URI:   https://larslo.de
 * Version:      0.9.0
 * Text Domain:  yours59
 *
 */

namespace Yours59AnimateSpanExchange;

$yours59_animate_span_exchange = Yours59AnimateSpanExchange::get_instance();

class Yours59AnimateSpanExchange {

	// static $saved_options;
	protected static $version = '0.9.0';
	protected static $instance = null;
	private static $name       = 'yours59_animate_span_exchange';


	// Method to get the unique instance.
	// Singleton
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self(); }
		self::$instance->init();

		return self::$instance;
	}

	/**
	 * is not allowed to call from outside to prevent from creating multiple instances,
	 * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
	 */
	private function __construct() {}

	/**
	 * prevent the instance from being cloned (which would create a second instance of it)
	 */
	private function __clone() {}

	/**
	 * prevent from being unserialized (which would create a second instance of it)
	 */
	public function __wakeup() {
		throw new Exception( 'Cannot unserialize' );
	}

	public function init() {


		/* enqueue block-editor js and css */
		add_action(
			'enqueue_block_editor_assets',
			function() {
				$is_dev = IS_LARSLOS_TESTING_ENV ? 'dev' : 'prod';
				/* JSON-EDITOR (https://github.com/json-editor/json-editor) files with spectre styles*/
				wp_enqueue_script(
					'jsoneditor',
					plugins_url( 'editor/json-editor/jsoneditor.' . $is_dev . '.js', __FILE__ ),
					array( 'wp-blocks', 'wp-element', 'wp-edit-post' ),
					self::$version,
				);
				wp_enqueue_script(
					'yours59_animate_span_exchange',
					plugins_url( 'editor/yours59_animate_span_exchange_editor.js', __FILE__ ),
					array( 'jsoneditor', 'wp-blocks', 'wp-element', 'wp-edit-post' ),
					self::$version,
				);
				wp_enqueue_style(
					'spectre',
					plugins_url( 'editor/json-editor/spectre.min.css', __FILE__ ),
					array(),
					self::$version,
				);
				wp_enqueue_style(
					'spectre-exp',
					plugins_url( 'editor/json-editor/spectre-exp.min.css', __FILE__ ),
					array(),
					self::$version,
				);
				wp_enqueue_style(
					'spectre-icon',
					plugins_url( 'editor/json-editor/spectre-icons.min.css', __FILE__ ),
					array(),
					self::$version,
				);
				wp_enqueue_style(
					'yours59_animate_span_exchange_editor',
					plugins_url( 'editor/yours59_animate_span_exchange_editor.css', __FILE__ ),
					array(),
					self::$version,
				);
			}
		);

		/* enqueue frontend assets */
		add_action(
			'wp_enqueue_scripts',
			function() {
				wp_enqueue_script(
					'yours59_animate_span_exchange',
					plugins_url( 'js/build-yours59_animate_span_exchange.js?' . self::$version, __FILE__ ),
					array(),
					self::$version,
				);
				wp_enqueue_style(
					'animate-core-blocks',
					plugin_dir_url( __FILE__ ) . 'css/yours59_animate_span_exchange.css?' . self::$version,
					array(),
					self::$version,
				);
			},
			10
		);
	}

} // class



