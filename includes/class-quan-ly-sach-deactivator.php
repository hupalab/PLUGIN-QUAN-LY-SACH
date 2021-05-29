<?php

/**
 * file này được thực thi khi plugin deactivation
 *
 * @package    Books_Management_Tool
 * @subpackage Books_Management_Tool/includes
 */

class Books_Management_Tool_Deactivator {

	private $table_activator;

	public function __construct($activator){
		$this->table_activator = $activator;
	}

	public function deactivate() {

		global $wpdb;

		// Xóa bảng khi người dùng plugin uninstall
        // $wpdb->query("DROP TABLE IF EXISTS ".$this->table_activator->wp_smc_tbl_books());
        // $wpdb->query("DROP TABLE IF EXISTS ". $this->table_activator->wp_smc_tbl_book_shelf());

        // Xóa trang khi người dùng plugin uninstalls
        $get_data =$wpdb->get_row(
	    	$wpdb->prepare(
	    		"SELECT ID from ".$wpdb->prefix."posts WHERE post_name = %s", 'book_tool'
	    	)
	    );

	    $page_id = $get_data->ID;

	    if($page_id > 0){

	    	// wp_delete_post($page_id, true); // delete post wp function
	    }
	}

}
