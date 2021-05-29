<?php

class Books_Management_Tool_Public {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quan-ly-sach-public.css', array(), $this->version, 'all' );

	}
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quan-ly-sach-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script($this->plugin_name, "smc_book",array(
			"name" => "Smart Coder",
			"author" => "Raihan Islam",
			"ajaxurl" => admin_url("admin-ajax.php")
		));

	}

	public function our_own_custom_page_template(){

		global $post;

		if($post->post_name == "book_tool"){

			$page_template = BOOKS_MANAGEMENT_TOOL_PLUGIN_PATH."public/partials/book-tool-layout.php";
		}

		return $page_template;
	}

	public function load_book_tool_content(){

		ob_start();

		include_once BOOKS_MANAGEMENT_TOOL_PLUGIN_PATH.'public/partials/tmpl-book-tool-content.php';

		$template = ob_get_contents();

		ob_end_clean();

		echo $template;
	}

	public function handle_ajax_request_public(){

		$param = isset($_REQUEST['param']) ? $_REQUEST['param'] : "";

		if(!empty($param)){

			if($param == "first_ajax_request"){
				echo "hiii đây là json data";
				echo json_encode(array(
					"status" => 1,
					"message" => "Successfully completed first ajax from frontend"
				));
			}
		}

		wp_die();
	}

}
