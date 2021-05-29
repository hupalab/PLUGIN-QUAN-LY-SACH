<?php

/**
 * Load domain cho phép dịch plugin đa ngôn ngữ. 
 * @since      1.0.0
 * @package    Books_Management_Tool
 * @subpackage Books_Management_Tool/includes
 */
class Books_Management_Tool_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'quan-ly-sach',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
