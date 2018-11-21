<?php

	class HomeModel extends MasterModel{

		public static function get_all_product_new(){
			return  parent::get_all_from();
		}

		public static function insert_item($name, $start, $end, $status) {
			$id = parent::insert_list(array('name'=> $name,'start_day'=> $start,'end_day'=> $end, 'status' => $status));
			return $id;
		}

		public static function update_item($id, $name, $start, $end, $status){
			return parent::update_list($id , array('name'=> $name,'start_day'=> $start,'end_day'=> $end, 'status' => $status));
		}

		public static function delete_item($id) {
			return parent::delete_list($id);
		} 

	}