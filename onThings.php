<?php
	//打开数据库连接
	include "connect.php";
	
	//$sql_ins = "insert into persons(FirstName,LastName,Age) values ('$_POST[firstname]','$_POST[lastname]','$_POST[age]')";
	
	//$cname = $_REQUEST['cname'];
	//$cphone = $_REQUEST['cphone'];
	//$caddr = $_REQUEST['caddr'];
	//$cnote = $_REQUEST['cnote'];
	//$cuserid = $_REQUEST['cuserid'];

	//$cname = $_POST["cname"];
	//$cphone = $_POST["cphone"];
	//$caddr = $_POST["caddr"];
	//$cnote = $_POST["cnote"];

	//echo 'Name is:'.$cname.'<br>';

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote,cuserid) values($_REQUEST['cname'], $_REQUEST['cphone'], $_REQUEST['caddr'], $_REQUEST['cnote'], $_REQUEST['cuserid'])";

	//Error:You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ',,)' at line 1
	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote) values($_POST[name],$_POST[phone],$_POST[addr],$_POST[note])";

	$curDateTime = date('Y-m-d H:i:s');

	//Error:You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '''')' at line 1

	//$sql_ins = "insert into LS_THINGS(account,name,telephone,service,date,time,region,village,address,choseTrait,remark,status,createdBy,createdAt,updatedBy,updatedAt) values('$_POST[account]','$_POST[name]','$_POST[telephone]','$_POST[service]','$_POST[date]','$_POST[time]','$_POST[region]','$_POST[village]','$_POST[address]','$_POST[choseTrait]','$_POST[remark]',1,'$_POST[nickName]','$curDateTime','$_POST[nickName]','$curDateTime')";

	$sql_sel = "select objectId,name,telephone,service,date,time,region,province,city,district,village,address,choseTrait,remark,status,createdBy,createdAt,updatedBy,updatedAt from DT_THINGS where status=1 order by date,time asc";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote) values("$cname","$cphone","$caddr","$cnote")";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote,cuserid) values('黄小龙', '18670000000','振业城二期3栋1208，测试', '要麻利的阿姨','89384')";

	//$sql_ins = "insert into t_service_booking(cdate,ctime,cservice) values('2018-08-23', '14:00','日常保洁')";

	$result = mysqli_query($conn,$sql_sel);

	class Things{
		public $objectId;
		public $name;
		public $telephone;
		public $service;
		public $date;
		public $time;
		public $region;
		public $province;
		public $city;
		public $district;
		public $village;
		public $address;
		public $choseTrait;
		public $remark;
		public $status;
		public $createdBy;
		public $createdAt;
		public $updatedBy;
		public $updatedAt;
	}

	$data = array();

	if(mysqli_num_rows($result)>0)
	{
		//输出数据
		while($row=mysqli_fetch_assoc($result))
		{
			$things = new Things();
			//$things->account = $row["account"];
			$things->objectId = $row["objectId"];
			$things->name = $row["name"];
			$things->telephone = $row["telephone"];
			$things->service = $row["service"];
			$things->date = $row["date"];
			$things->time = $row["time"];
			$things->region = $row["region"];
			$things->province = $row["province"];
			$things->city = $row["city"];
			$things->district = $row["district"];
			$things->village = $row["village"];
			$things->address = $row["address"];
			$things->choseTrait = $row["choseTrait"];
			$things->remark = $row["remark"];
			$things->createdAt = $row["createdAt"];

			$data[] = $things;
			//echo "姓名:".$row["firstname"]."  "."昵称:".$row["lastname"]."  "."年龄:".$row["age"]."<br>";
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式，微信只能对json格式的数据进行操作
	}else{
		//echo "The data is empty!"."<br>";
		//die('Error:'.mysqli_error($conn));
	}

	//关闭数据库
	if(mysqli_close($conn))
	{
		//echo 'The connect has been disconnect.'.'<br>';
	}else{
		//echo 'Fatal ERROR for database close.'.'<br>';
	}

?>