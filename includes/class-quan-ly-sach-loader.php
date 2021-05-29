<?php

/**
 * Đăng ký tất cả các filter và action của plugin cho wordpress.
 */
class Books_Management_Tool_Loader {

	/**
	 * Biến array đăng ký các hoạt động (action) với WordPress.
	 */
	protected $actions;

	/**
	 * Biến array đăng ký các bộ lọc (filter) với WordPress.
	 */
	protected $filters;

	/**
	 * Khởi tạo khi các action và filter
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Hàm thêm một action mới vào trong WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             tên hook đăng ký vào wordpress
	 * @param    object               $component        Tham chiếu tới action hook
	 * @param    string               $callback         Hàm hực hiện hook này
	 * @param    int                  $priority         Độ ưu tiên vị trí đặt (mặc định 10)
	 * @param    int                  $accepted_args    Tùy chọn số lượng đối số truyền vào (mặc định là 1)
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Hàm thêm một filter mới vào trong WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             
	 * @param    object               $component        
	 * @param    string               $callback         
	 * @param    int                  $priority         
	 * @param    int                  $accepted_args    
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * đăng ký nhiều filter và action cùng một lúc
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            Có thể là tên filter hoặc action
	 * @param    string               $hook             Tên filter đã được đăng ký 
	 * @param    object               $component        Tham chiếu tới filter
	 * @param    string               $callback         Hàm thực thi $component
	 * @param    int                  $priority         Độ ưu tiên
	 * @param    int                  $accepted_args    Số lượng đối số
	 * @return   array                                  Tập hợp các tên filter và action đăng ký với wordpress
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Thực thi đăng ký filter và action với wordpress
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

}
