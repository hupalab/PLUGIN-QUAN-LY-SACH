<?php

/**
 * Trung tâm điều khiển plugin (core plugin)
 * File này chứa class khai báo các thuộc tính, vị trí (hook) & chức năng... thực thi ở admin cũng trang giao diện người dùng
 */

class Books_Management_Tool {

	/**
	 * @var      Books_Management_Tool_Loader    $loader    Biến này nhằm duy trì và đăng ký tất cả các hook cho plugin
	 */
	protected $loader;

	/**
	 * @var      string    $plugin_name   Đặt tên plguin là duy nhất.
	 */
	protected $plugin_name;

	/**
	 * @var      string    $version    Phiên bản hiện tại của plugin.
	 */
	protected $version;

	/**
	 * Khởi chạy các core functionality của plugin.
	 */
	public function __construct() {
		if ( defined( 'BOOKS_MANAGEMENT_TOOL_VERSION' ) ) {
			$this->version = BOOKS_MANAGEMENT_TOOL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'quan-ly-sach';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Tải tất cả các file cần thiết cho plugin.
	 *
	 * Những file này bao gồm:
	 *
	 * - Books_Management_Tool_Loader. Sắp sếp các vị trí (hook) trong plugin.
	 * - Books_Management_Tool_i18n. dành cho đa Ngôn ngữ.
	 * - Books_Management_Tool_Admin. Tạo và quy định các hook trong trang admin.
	 * - Books_Management_Tool_Public. Tạo và quy định các hook cho trang người dùng ngoài website.
	 *
	 * khai báo và đăng ký vị trí - hooks
	 */
	private function load_dependencies() {

		/**
		 * Class này chịu trách nhiệm đăng ký các hooks trong plugin
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-quan-ly-sach-loader.php';

		/**
		 * Class này chịu trách nhiệm tạo các chức năng chính cho plugin
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-quan-ly-sach-i18n.php';

		/**
		 * Class này chịu trách nhiệm tạo các hành động sảy ra ở trang admin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-quan-ly-sach-admin.php';

		/**
		 * Class này chịu trách nhiệm tạo các hành động sảy ra ở trang public người dùng.
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-quan-ly-sach-public.php';

		// Tạo đối tượng và gọi run() để đăng ký tất cả các filter hook và action hook
		$this->loader = new Books_Management_Tool_Loader();

	}

	/**
	 * Class Books_Management_Tool_i18n thiết lập tên domain và đa ngôn ngữ
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Books_Management_Tool_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Đăng ký tất cả các hook tại trang admin
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Books_Management_Tool_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    	
		// Thực thi tại vị trí admin menu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'book_management_menu' );

		// thực thi ajax
		$this->loader->add_action("wp_ajax_admin_ajax_request" , $plugin_admin, 'handle_ajax_requests_admin' );

	}

	/**
	 * Đăng ký tất cả các hook tại trang public khách dùng
	 */
	private function define_public_hooks() {

		$plugin_public = new Books_Management_Tool_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Hiển thị ra page template
		$this->loader->add_filter("page_template", $plugin_public, "our_own_custom_page_template");

		add_shortcode("render-my-content", array($plugin_public, "load_book_tool_content"));

		// // this is for login case
		$this->loader->add_action("wp_ajax_public_ajax_request", $plugin_public, "handle_ajax_request_public");
	}

	/**
	 * Chạy để thực thi tất cả các hook cho plugin.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Tạo hàm lấy tên của plugin nếu cần
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * lấy đăng ký để tham khảo các hooks
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Lấy version plugin -  số 1.0
	 */
	public function get_version() {
		return $this->version;
	}

}
