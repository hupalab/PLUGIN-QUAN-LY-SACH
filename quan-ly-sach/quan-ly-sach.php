<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Quản lý sách
 * Plugin URI:        http://hpseoer.com/
 * Description:       Đây là plugin quản lý sách (đây là mã nguồn mở bạn cho phép bạn sử dụng với mục đích thương mại - đọc thêm quy định về bản quyền ở file license.txt trước khi sử dụng nhé)
 * Version:           1.0.0
 * Author:            hpSEO
 * Author URI:        http://hpseoer.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quan-ly-sach
 * Domain Path:       /languages
 */

// Ngăn file này gọi trực tiếp từ người dùng
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Định nghĩa các hằng số dùng trong plguin.
 */
define( 'BOOKS_MANAGEMENT_TOOL_VERSION', '1.0.0' );
define( 'BOOKS_MANAGEMENT_TOOL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define('BOOKS_MANAGEMENT_TOOL_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin activation.
 * Khi kích hoạt plugin này thì các hoạt động sẽ được thực hiện tại file includes/class-quan-ly-sach-activator.php
 */
function activate_books_management_tool() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quan-ly-sach-activator.php';
	$activator = new Books_Management_Tool_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * Khi NGỪNG kích hoạt plugin này thì các hoạt động sẽ được thực hiện tại includes/class-quan-ly-sach-deactivator.php
 */
function deactivate_books_management_tool() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quan-ly-sach-activator.php';
	$activator = new Books_Management_Tool_Activator();

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quan-ly-sach-deactivator.php';
	$deactivator  = new Books_Management_Tool_Deactivator($activator);
	$deactivator->deactivate();
}

register_activation_hook( __FILE__, 'activate_books_management_tool' );
register_deactivation_hook( __FILE__, 'deactivate_books_management_tool' );

/**
 * Trung tâm điều khiển các vị trí đặt (hook) và các chức năng của plugin
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quan-ly-sach.php';

/**
 * Bắt đầu thực thi chạy plugin.
 */
function run_books_management_tool() {

	$plugin = new Books_Management_Tool();
	$plugin->run();

}
run_books_management_tool();
