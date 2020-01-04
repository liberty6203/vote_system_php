<?php
	include_once('./safe_dao.php');
//	include_once('./dao.php');
	//需要处理登录请求，返回信息
	function login_service($username,$password){
		
		$login_result = login($username,$password);
		$response = array();
		if($login_result == true){
			session_start();
			$_SESSION["username"]=$username;
		
			$response["status"] = 0;
			$response["message"] = "login sucess";
			echo json_encode($response);
		}else{
			$response["status"] = 1;
			$response["message"] = "login failed";
			echo json_encode($response);
		}
		
	}
	function actionError(){
		echo "action类型错误";
	}
	
	
//	login_service("voter1","111111");
	
	$action = $_POST["action"];
	switch($action){
		case "login":
			$username = $_POST["username"];
			$password = $_POST["password"];
			login_service($username,$password);
			break;
		default:
			actionError();
	}
	
	
?>