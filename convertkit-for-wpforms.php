<?php
/**
 * Plugin Name: ConvertKit Integration for WPForms
 * Description: Create ConverKit signup forms using WPForms
 * Version:     1.0.0
 * Author:      Bill Erickson
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.  You may NOT assume that you can use any other
 * version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * @package    BE_WPForms_ConvertKit
 * @since      1.0.0
 * @copyright  Copyright (c) 2017, Bill Erickson
 * @license    GPL-2.0+
 */

 // Exit if accessed directly
 if ( ! defined( 'ABSPATH' ) ) exit;

 // Plugin version
 define( 'BE_WPFORMS_CONVERTKIT_VERSION', '1.0.0' );

/**
 * Load the class
 *
 */
function be_wpforms_convertkit() {

    load_plugin_textdomain( 'be_wpforms_convertkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    require_once( plugin_dir_path( __FILE__ ) . 'class-be-wpforms-convertkit.php' );

}
add_action( 'wpforms_loaded', 'be_wpforms_convertkit' );
