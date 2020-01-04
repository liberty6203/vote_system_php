<?php
	
	function getConnection(){
		$sql_host="localhost";
		$sql_username="election";
		$sql_password="election";
		$conn = mysql_connect($sql_host,$sql_username,$sql_password);
		if(!$conn){
			die('database connection fail');
		}
		mysql_select_db("election",$conn);
		return $conn;
	}
	
	//封装数据库操作
	function getConnection_pdo(){
		
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=election', 'election', 'election');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		return $pdo;
	}
	
	function login($username,$password){
		$pdo = getConnection_pdo();

		$sql = "select * from voter where username= ? and password= ? ";
		
		$sta = $pdo->prepare($sql); //准备 SQL 模版，其中 ? 代表一个参数。
		$sta->execute(array($username,$password)); //通过数组设置参数，执行 SQL 模版
		$result = $sta->fetchAll();
//		echo $result[0]["username"]."-----------".$result[0]["password"];
		$rownum = count($result);
		$return_value = 0;
		if($rownum>0){
			$return_value = 1;
		}
		return $return_value;
	}
	
	login("admin","admin111");
	
	function getAllCandidate(){
		$conn = getConnection();
		$sql = "select * from candidate";
		$result_set = mysql_query($sql);
		$return_value = array();
		$i=0;
		while($row = mysql_fetch_array($result_set)){
			$return_value[$i] = $row["candidate"];
			$i++;
		}
		mysql_close($conn);
		return $return_value;
	}

	//选了返回名字，没选返回空
	function checkVote($username){
		$conn = getConnection();
		$sql = "select candidate from voter where username = '$username'";
		$result_set = mysql_query($sql);
		
		$row = mysql_fetch_array($result_set);
		$return_value = $row["candidate"];
		
		mysql_close($conn);
		return $return_value;
	}
	
	function getResult(){
		$conn = getConnection();
		$sql = "select candidate,count(*) num from voter group by candidate";
		$result_set = mysql_query($sql);
		$return_value = array();
		
		$i=0;
		while($row = mysql_fetch_array($result_set)){
			if($row["candidate"]){
				$return_value[$i] = array();
				$return_value[$i]["candidate"] = $row["candidate"];
				$return_value[$i]["number"] = $row["num"];
				$i++;
			}	
		}
		
		mysql_close($conn);
		return $return_value;
	}
	
	function vote ($username,$candidate){
		$conn = getConnection();
		$sql = "update voter set candidate='$candidate' where username='$username'";
		$result = mysql_query($sql);
//		echo $result;
		if($result)
			$return_value = false;
		else
			$return_value = true;
		
		mysql_close($conn);
		return $return_value;
	}

	function resetVote (){
		$conn = getConnection();
		$sql = "update voter set candidate=NULL";
		$result = mysql_query($sql);
		
		mysql_close($conn);
		return $result;
	}
	
	function addCandidate($candidate){
		$conn = getConnection();
		$sql = "insert into candidate('candidate') value('$candidate') ";
		$result = mysql_query($sql);
		
		mysql_close($conn);
		return $result;
	}
	
	function getVoteDetail(){
		$conn = getConnection();
		$sql = "select  username,candidate from voter;";
		$result_set = mysql_query($sql);
		$return_value = array();
		$i=0;
		while($row = mysql_fetch_array($result_set)){
			if($row["candidate"]){
				$return_value[$i] = array();
				$return_value[$i]["username"]=$row["username"];
				$return_value[$i]["candidate"] = $row["candidate"];
				$i++;
			}	
		}
		
		mysql_close($conn);
		return $return_value;
	}
	
//	$arr=getVoteDetail();
//	$num = count($arr);
//	for($i=0;$i<$num;$i++){
//		echo $arr[$i]["username"]."-----".$arr[$i]["candidate"]."<br>";
//	}
	
//	echo login("admin","admin");

//	example for getAllCandidate
//	$arr = getAllCandidate();
//	$num = count($arr);
//	echo $num."<br>";
//	for($i=0;$i<$num;$i++){
//		echo $arr[$i]."<br>";
//	}

//	echo checkVote("voter1");

//	getResult
//	$array = getResult();
//	$arr = getAllCandidate();
//	$num = count($arr);
//	for($i=0;$i<$num;$i++){
//		if($array[$arr[$i]["candidate"]]){
//			echo $arr[$i]["candidate"]."-------".$array[$arr[$i]["candidate"]]."<br>";
//		}else{
//			$array[$arr[$i]["candidate"]] = 0;
//			echo $arr[$i]["candidate"]."-------".$array[$arr[$i]["candidate"]]."<br>";
//		}
//		
//	}

//	成功返回1
//	vote("voter10","candidate3");
?>