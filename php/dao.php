<?php
	
	//封装数据库操作
	
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
	
//	function getDB() {
//	    $dbhost="localhost";
//	    $dbuser="election";
//	    $dbpass="election";
//	    $dbname="Users";
//	    // Create a DB connection
//	    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
//	    if ($conn->connect_error) {
//	      die("Connection failed: " . $conn->connect_error . "\n");
//	    }
//	    return $conn;
//	}
	
//	function login($username,$password){
//		$conn = getDB();
//		$sql = "select * from voter where username='$username' and password='$password'";
//		$return_value = false;
//		if ($result = $conn->query($sql)) {
//			$return_value = true;
//			echo "登陆成功";
//		}
//		return $return_value;
//	}
	
	function login($username,$password){
		$conn = getConnection();
		$sql = "select * from voter where username='$username' and password='$password'";
		$result_set = mysql_query($sql);
		$return_value = false;
		if($row = mysql_fetch_array($result_set)){
			$return_value = true;
		}
		mysql_close($conn);
		return $return_value;
	}
	
//	login("voter1';Update voter set candidate='candidate1' where username='voter1';#","111");
	
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