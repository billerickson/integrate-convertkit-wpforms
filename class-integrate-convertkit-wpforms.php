<?php
/**
 * Integrate ConvertKit and WPForms
 *
 * @package    Integrate_ConvertKit_WPForms
 * @since      1.0.0
 * @copyright  Copyright (c) 2017, Bill Erickson
 * @license    GPL-2.0+
 */

class Integrate_ConvertKit_WPForms {

    /**
     * Primary Class Constructor
     *
     */
    public function __construct() {

        add_filter( 'wpforms_builder_settings_sections', array( $this, 'settings_section' ), 20, 2 );
        add_filter( 'wpforms_form_settings_panel_content', array( $this, 'settings_section_content' ), 20 );
        add_action( 'wpforms_process_complete', array( $this, 'send_data_to_convertkit' ), 10, 4 );

    }

    /**
     * Add Settings Section
     *
     */
    function settings_section( $sections, $form_data ) {
        $sections['be_convertkit'] = __( 'ConvertKit', 'integrate-convertkit-wpforms' );
        return $sections;
    }


    /**
     * ConvertKit Settings Content
     *
     */
    function settings_section_content( $instance ) {
        echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-be_convertkit">';
        echo '<div class="wpforms-panel-content-section-title">' . __( 'ConvertKit', 'integrate-convertkit-wpforms' ) . '</div>';

        if( empty( $instance->form_data['settings']['be_convertkit_api'] ) ) {
            printf(
                '<p>%s <a href="http://mbsy.co/convertkit/28981746" target="_blank" rel="noopener noreferrer">%s</a></p>',
                __( 'Don\'t have an account?', 'integrate-convertkit-wpforms' ),
                __( 'Sign up now!', 'integrate-convertkit-wpforms' )
            );
        }

        wpforms_panel_field(
            'text',
            'settings',
            'be_convertkit_api',
            $instance->form_data,
            __( 'ConvertKit API Key', 'integrate-convertkit-wpforms' )
        );

        wpforms_panel_field(
            'text',
            'settings',
            'be_convertkit_form_id',
            $instance->form_data,
            __( 'ConvertKit Form ID', 'integrate-convertkit-wpforms' )
        );

        wpforms_panel_field(
            'select',
            'settings',
            'be_convertkit_field_first_name',
            $instance->form_data,
            __( 'First Name', 'integrate-convertkit-wpforms' ),
            array(
                'field_map'   => array( 'text', 'name' ),
                'placeholder' => __( '-- Select Field --', 'integrate-convertkit-wpforms' ),
            )
        );

        wpforms_panel_field(
            'select',
            'settings',
            'be_convertkit_field_email',
            $instance->form_data,
            __( 'Email Address', 'integrate-convertkit-wpforms' ),
            array(
                'field_map'   => array( 'email' ),
                'placeholder' => __( '-- Select Field --', 'integrate-convertkit-wpforms' ),
            )
        );

        echo '</div>';
    }

    /**
     * Integrate WPForms with ConvertKit
     *
     */
    function send_data_to_convertkit( $fields, $entry, $form_data, $entry_id ) {

        // Get API key and CK Form ID
        $api_key = $ck_form_id = false;
        if( !empty( $form_data['settings']['be_convertkit_api'] ) )
            $api_key = esc_html( $form_data['settings']['be_convertkit_api'] );
        if( !empty( $form_data['settings']['be_convertkit_form_id'] ) )
            $ck_form_id = intval( $form_data['settings']['be_convertkit_form_id'] );

        if( ! ( $api_key && $ck_form_id ) )
            return;

		$args = array(
            'api_key'    => $api_key
		);


        // Return early if no email
        $email_field_id = $form_data['settings']['be_convertkit_field_email'];
		if( empty( $email_field_id ) || empty( $fields[ $email_field_id ]['value'] ) )
			return;

		$args['email'] = $fields[ $email_field_id ]['value'];

        $first_name_field_id = $form_data['settings']['be_convertkit_field_first_name'];
		if( !empty( $first_name_field_id ) && !empty( $fields[ $first_name_field_id ]['value'] ) )
			$args['first_name'] = $fields[ $first_name_field_id ]['value'];

		// Custom Fields and tags
		// @link https://www.billerickson.net/setup-convertkit-wordpress-form/#custom-fields-and-tags
		foreach( $form_data['fields'] as $i => $field ) {
			if( empty( $field['css'] ) )
				continue;

			$value = !empty( $fields[$i]['value_raw'] ) ? $fields[$i]['value_raw'] : $fields[$i]['value'];
			$classes = explode( ' ', $field['css'] );
			foreach( $classes as $class ) {

				// Custom Fields
				if( false !== strpos( $class, 'ck-custom-' ) ) {
					$key = str_replace( 'ck-custom-', '', $class );
					$args['fields'][ $key ] = $value;
				}

				// Tags
				if( 'ck-tag' == $class ) {
					$args['tags'][] = $value;
				}
			}
		}

		// Filter for customizing arguments
		// @link https://www.billerickson.net/code/integrate-convertkit-wpforms-custom-fields/
		$args = apply_filters( 'be_convertkit_form_args', $args, $fields, $form_data );

		// Filter for limiting integration
		// @link https://www.billerickson.net/code/integrate-convertkit-wpforms-conditional-processing/
        if( ! apply_filters( 'be_convertkit_process_form', true, $fields, $form_data ) )
            return;

        // Submit to ConvertKit
        $request = wp_remote_post( add_query_arg( $args, 'https://api.convertkit.com/v3/forms/' . $ck_form_id . '/subscribe' ) );

    }

}
new Integrate_ConvertKit_WPForms;
