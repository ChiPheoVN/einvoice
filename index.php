<?php
	ob_start();
	date_default_timezone_set("Asia/Ho_Chi_Minh");

	require_once 'Config/Config.php';
	require_once 'Config/Database.php';
	require_once 'Config/Router.php';

	// ThirdParty
	require_once 'ThirdParty/Php_excel/PHPExcel.php';
	require_once 'ThirdParty/Api_vt/api_function.php';

	// libs
	require_once 'Library/K_Lib.php';
	require_once 'Library/NhatKyChung_Lib.php';
	require_once 'Library/Excel_Libs.php';
	require_once 'Library/md5_Lib.php';

	require_once 'Core/Database.php';

	require_once 'Core/MY_Core.php';
	require_once 'Core/MY_Controller.php';
	require_once 'Core/MY_Model.php';

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$_key_session_admin_id = 'admin_id';

	$current_url 	= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$_controller 	= '';
	$_function 		= '';

	if($current_url === $_base_url){
		$_controller 	= $_default_controller;
		$_function		= 'index';		
	}else{
		$_new_url = str_replace($_base_url, '', $current_url);
		$_url_without_get = explode('?', $_new_url)[0];

		$_controller 	= isset($_url_rewrite[$_url_without_get]) ? $_url_rewrite[$_url_without_get] : $_url_without_get;

		$_str_split = explode('/',$_controller);


		$_controller 	= $_str_split[0];


		$_function		= isset($_str_split[1]) ? $_str_split[1] : 'index';
	}

	$_controller 	.= '_Controller';

	if(file_exists('Controller/'.$_controller.'.php')){
		require_once 'Controller/'.$_controller.'.php';

		if(class_exists($_controller)){
			$instance		= new $_controller();

			if(method_exists($instance, $_function)){
				$instance->$_function();
			}else{
				echo '<h1>Không tìm thấy yêu cầu</h1>';
			}
		}
	}else{
		echo '<h1>Not found 404</h1>';
	}

	ob_flush();
?>
