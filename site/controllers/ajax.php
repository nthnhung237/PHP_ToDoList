<?php

require('site/models/home.php');

	class AjaxController extends HomeModel {

		public function delete_list() {

			$id = $_POST["list_id"];

			if (isset($id)) {

				$result = parent::delete_item($id);

				$response = array();
				$response['success'] = 1;

				echo json_encode($response);

			} else{
				require('404.php');
			}

		}

		public function add_list() {

			$name = $_POST["name"];
			$start_day = $_POST["start_day"];
			$end_day = $_POST["end_day"];
			$status_id = $_POST["status_id"];

			if (isset($name) && isset($start_day) && isset($end_day) && isset($status_id)) {

				$result = parent::insert_item($name, $start_day, $end_day, intval($status_id));

				$response = array();
				$response['success'] = 1;
				$response['id'] = $result;

				echo json_encode($response);

			} else {
				require('404.php');
			}

		}

		public function update_list() {

			$id = $_POST["id"];
			$name = $_POST["name"];
			$start_day = $_POST["start_day"];
			$end_day = $_POST["end_day"];
			$status_id = $_POST["status_id"];

			if (isset($id) && isset($name) && isset($start_day) && isset($end_day) && isset($status_id)) {

				$result = parent::update_item($id, $name, $start_day, $end_day, $status_id);

				$response = array();
				$response['success'] = 1;

				echo json_encode($response);

			} else{
				require('404.php');
			}

		}

	}

?>