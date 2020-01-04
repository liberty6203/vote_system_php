<?php
	include_once('./dao.php');
	
	function getAllCandidateService(){
		
		$candidate_arr = getAllCandidate();
		$response = array();
		$response["candidate"] = $candidate_arr;
		
		echo json_encode($response);
	}
	
	function checkVoteStateService($username){
		$voted_result = checkVote($username);
		$response = array();
		if(!empty($voted_result)){
			$response["status"] = 0;
			$response["message"] = "已投票";
			$response["candidate"] = $voted_result;
		}else{
			$response["status"] = 1;
			$response["message"] = "未投票";
		}
		echo json_encode($response);
		
	}
	
	function voteService($candidate){
		session_start();
		$username = $_SESSION["username"];
//		$username = "voter1";
		$response = array();
		if($username){
			$vote_result = checkVote($username);
			if(!$vote_result){
				vote($username,$candidate);
				$response["status"]=0;
				$response["message"]="投票成功";
			}else{
				$response["status"]=1;
				$response["message"]="您已经投过票，请勿重复投票";
				$response["candidate"]=$vote_result;
			} 
		}else{
			$response["status"]=2;
			$response["message"]="您还未登录，请登录后再投票";
		}
		echo json_encode($response);
	}
	
	function getResultService(){
		$vote_result = getResult();
		
		echo json_encode($vote_result);
	}
	
	function getVoteDetailService(){
		$vote_detail = getVoteDetail();
		echo json_encode($vote_detail);
	}
	
	function resetVoteService(){
		$reset_result = resetVote();
		$response = array();
		if(!$reset_result){
			$response["status"] = 0;
			$response["message"] = "投票已重置";
		}else{
			$response["status"] = 1;
			$response["message"] = "重置投票失败";
		}
		echo json_encode($response);
	}
	
	function actionError(){
		echo "action类型错误";
	}
	
	
//	login_service("voter1","111111");
	
//	echo checkVoteState("voter6");
	
//	voteService("candidate3");
//	$arr=getVoteDetail();
//	$num = count($arr);
//	for($i=0;$i<$num;$i++){
//		echo $arr[$i]["username"]."-----".$arr[$i]["candidate"]."<br>";
//	}

	
//	$arr=getVoteDetail();
//	$num = count($arr);
//	for($i=0;$i<$count;$i++){
//		echo $arr[$i]["username"]."-----".$arr[$i]["candidate"];
//	}
	
	
//	getAllCandidateService();
	
//	getResultService();

//	resetVoteService();
	
	$action = $_POST["action"];
	switch($action){
		case "getAllCandidate":
			getAllCandidateService();
			break;
		case "checkVoteState":
			$username = $_POST["username"];
			checkVoteStateService($username);
			break;
		case "vote":
			$candidate = $_POST["candidate"];
			voteService($candidate);
			break;
		case "getResult":
			getResultService();
			break;
		case "getDatil":
			getVoteDetailService();
			break;
		case "resetVote":
			resetVoteService();
			break;
		default:
			actionError();
	}
?>