<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/pdutie94
 * @since      1.0.0
 *
 * @package    Tp_Wps
 * @subpackage Tp_Wps/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tp_Wps
 * @subpackage Tp_Wps/includes
 * @author     TienPham <pdutie94@gmail.com>
 */
class Tp_Wps_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        global $wpdb;
        $tpwpc_db_version = '1.0';
        $table_name = $wpdb->prefix . "tpwps";

        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name(
              `id` mediumint(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
              `product_show` int(11) NOT NULL DEFAULT '15',
              `auto_play` tinyint(1) DEFAULT '1',
              `auto_play_speed` int(11) DEFAULT '500',
              `loop` tinyint(1) DEFAULT '1',
              `show_nav` tinyint(1) DEFAULT '1',
              `show_dot` tinyint(1) DEFAULT '1',
              `rewind` tinyint(1) DEFAULT '1',
              `cat_id` int(11) NOT NULL,
              `product_per_row` int(11) NOT NULL DEFAULT '4',
              `order_by` varchar(10) NOT NULL DEFAULT 'name',
              `order_type` varchar(10) NOT NULL DEFAULT 'asc',
              `shortcode` varchar(255) NOT NULL,
              `status` tinyint(1) NOT NULL DEFAULT '1',
              `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        add_option( 'tpwps_db_version', $tpwpc_db_version );
	}

}
