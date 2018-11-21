<?php

	require('site/models/home.php');

	class HomeController extends HomeModel{

		public function index() {

			$list = parent::get_all_product_new();
			require('site/views/home/index.php');

		}

	}