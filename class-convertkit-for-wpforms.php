<?php
/**
 * ConvertKit for WPForms
 *
 * @package    BE_WPForms_ConvertKit
 * @since      1.0.0
 * @copyright  Copyright (c) 2017, Bill Erickson
 * @license    GPL-2.0+
 */

class ConvertKit_For_WPForms {

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
        $sections['be_convertkit'] = __( 'ConvertKit', 'convertkit-for-wpforms' );
        return $sections;
    }


    /**
     * ConvertKit Settings Content
     *
     */
    function settings_section_content( $instance ) {
        echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-be_convertkit">';
        echo '<div class="wpforms-panel-content-section-title">' . __( 'ConvertKit', 'convertkit-for-wpforms' ) . '</div>';

        wpforms_panel_field(
            'text',
            'settings',
            'be_convertkit_api',
            $instance->form_data,
            __( 'ConvertKit API Key', 'convertkit-for-wpforms' )
        );

        wpforms_panel_field(
            'text',
            'settings',
            'be_convertkit_form_id',
            $instance->form_data,
            __( 'ConvertKit Form ID', 'convertkit-for-wpforms' )
        );

        wpforms_panel_field(
            'select',
            'settings',
            'be_convertkit_field_first_name',
            $instance->form_data,
            __( 'First Name', 'convertkit-for-wpforms' ),
            array(
                'field_map'   => array( 'text', 'name' ),
                'placeholder' => __( '-- Select Field --', 'convertkit-for-wpforms' ),
            )
        );

        wpforms_panel_field(
            'select',
            'settings',
            'be_convertkit_field_email',
            $instance->form_data,
            __( 'Email Address', 'convertkit-for-wpforms' ),
            array(
                'field_map'   => array( 'email' ),
                'placeholder' => __( '-- Select Field --', 'convertkit-for-wpforms' ),
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

        // Get email and first name
        $email_field_id = $form_data['settings']['be_convertkit_field_email'];
        $first_name_field_id = $form_data['settings']['be_convertkit_field_first_name'];

        $args = array(
            'api_key'    => $api_key,
            'email'      => $fields[$email_field_id]['value'],
            'first_name' => $fields[$first_name_field_id]['value']
        );

        if( empty( $args['email'] ) || empty( $args['first_name'] ) )
            return;

        // Submit to ConvertKit
        $request = wp_remote_post( add_query_arg( $args, 'https://api.convertkit.com/v3/forms/' . $ck_form_id . '/subscribe' ) );

    }

}
new ConvertKit_For_WPForms;
