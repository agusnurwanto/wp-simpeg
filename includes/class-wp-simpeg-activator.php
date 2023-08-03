<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Simpeg
 * @subpackage Wp_Simpeg/includes
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Wp_Simpeg_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $path = SIMPEG_PLUGIN_PATH.'/tabel.sql';
        $sql = file_get_contents($path);
        dbDelta($sql);
        update_option('_wp_simpeg_db_version', WP_SIMPEG_VERSION);
	}

}
