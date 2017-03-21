<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/pdutie94
 * @since      1.0.0
 *
 * @package    Tp_Wps
 * @subpackage Tp_Wps/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Tp_Wps
 * @subpackage Tp_Wps/includes
 * @author     TienPham <pdutie94@gmail.com>
 */
class Tp_Wps_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        global $wpdb;
        $table_name = $wpdb->prefix . "tpwps";
        $sql = "DROP TABLE IF EXISTS $table_name;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $wpdb->query($sql);
        delete_option("tpwps_db_version");
	}

}
