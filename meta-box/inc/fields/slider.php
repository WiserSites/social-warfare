<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'SW_META_Slider_Field' ) )
{
	class SW_META_Slider_Field extends SW_META_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			$url = SW_META_CSS_URL . 'jqueryui';
			wp_enqueue_style( 'jquery-ui-core', "{$url}/jquery.ui.core.css", array(), '1.8.17' );
			wp_enqueue_style( 'jquery-ui-theme', "{$url}/jquery.ui.theme.css", array(), '1.8.17' );
			wp_enqueue_style( 'jquery-ui-slider', "{$url}/jquery.ui.slider.css", array(), '1.8.17' );
			wp_enqueue_style( 'SW_META-slider', SW_META_CSS_URL . 'slider.css' );

			wp_enqueue_script( 'SW_META-slider', SW_META_JS_URL . 'slider.js', array( 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-core' ), SW_META_VER, true );
		}

		/**
		 * Get div HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			return sprintf(
				'<div class="clearfix">
					<div class="SW_META-slider" id="%s" data-options="%s"></div>
					<span class="SW_META-slider-value-label">%s<span>%s</span>%s</span>
					<input type="hidden" name="%s" value="%s" class="SW_META-slider-value">
				</div>',
				$field['id'], esc_attr( json_encode( $field['js_options'] ) ),
				$field['prefix'], $meta, $field['suffix'],
				$field['field_name'], $meta
			);
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field               = wp_parse_args( $field, array(
				'prefix'     => '',
				'suffix'     => '',
				'js_options' => array(),
			) );
			$field['js_options'] = wp_parse_args( $field['js_options'], array(
				'range' => 'min', // range = 'min' will add a dark background to sliding part, better UI
			) );

			return $field;
		}
	}
}
