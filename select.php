<?php
	//打开数据库连接
	include 'connect.php';

	//$sql_sel = 'select firstname, lastname, age from persons where 1=1';
	//$sql_sel = 'select cname, cphone, caddr, cnote from booking where 1=1';

	//带变量进行操作
	//$sql_sel = 'select firstname, lastname, age from persons where age>$_POST[name]';

	//$cage = intval('$_POST[note]');

	//常规操作
	$sql_sel = "select firstname, lastname, age from persons where age>'$_POST[note]';";

	$result = mysqli_query($conn,$sql_sel);

	class persons{
		public $firstname;
		public $lastname;
		public $age;
	}

	$data = array();

	if(mysqli_num_rows($result)>0)
	{
		//输出数据
		while($row=mysqli_fetch_assoc($result))
		{	
			$person = new persons();
			$person->firstname = $row["firstname"];
			$person->lastname = $row["lastname"];
			$person->age = $row["age"];

			$data[] = $person;
			//echo "姓名:".$row["firstname"]."  "."昵称:".$row["lastname"]."  "."年龄:".$row["age"]."<br>";
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式，微信只能对json格式的数据进行操作
	}else{
		echo "The data is empty!"."<br>";
	}	

	//关闭数据库
	if(mysqli_close($conn))
	{
		echo 'The connect has been disconnect.'.'<br>';
	}else{
		echo 'Fatal ERROR for database close.'.'<br>';
	}
?>