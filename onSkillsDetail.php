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

	//$sql_sel = "select objectId,name,telephone,service,date,time,region,province,city,district,village,address,choseTrait,remark,status,createdBy,createdAt,updatedBy,updatedAt from LS_SKILLS where status=1 and objectId='$_POST[objectId]'";

	$sql_sel = "select a.objectId,a.account,b.avatarUrl,a.name,a.telephone,a.region,a.province,a.city,a.district,a.village,a.skills,a.skillOne,a.skillTwo,a.skillThree,a.skillFour,a.skillFive,a.tools,a.toolOne,a.toolTwo,a.toolThree,a.toolFour,a.toolFive,a.remark,a.status,a.createdBy,a.createdAt,a.updatedBy,a.updatedAt from DT_SKILLS a, AUTH_USER b where a.objectId='$_POST[objectId]' and a.account = b.objectId and a.status=1 order by a.createdAt asc";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote) values("$cname","$cphone","$caddr","$cnote")";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote,cuserid) values('黄小龙', '18670000000','振业城二期3栋1208，测试', '要麻利的阿姨','89384')";

	//$sql_ins = "insert into t_service_booking(cdate,ctime,cservice) values('2018-08-23', '14:00','日常保洁')";

	$result = mysqli_query($conn,$sql_sel);

	class Skills{
		public $objectId;
		public $account;
		public $avatarUrl;
		public $name;
		public $telephone;
		public $region;
		public $province;
		public $city;
		public $district;
		public $village;
		public $skills;
		public $skillOne;
		public $skillTwo;
		public $skillThree;
		public $skillFour;
		public $skillFive;
		public $tools;
		public $toolOne;
		public $toolTwo;
		public $toolThree;
		public $toolFour;
		public $toolFive;
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
			$skills = new Skills();
			$skills->objectId = $row["objectId"];
			$skills->account = $row["account"];
			$skills->avatarUrl = $row["avatarUrl"];
			$skills->name = $row["name"];
			$skills->telephone = $row["telephone"];
			$skills->region = $row["region"];
			$skills->province = $row["province"];
			$skills->city = $row["city"];
			$skills->district = $row["district"];
			$skills->village = $row["village"];
			$skills->skills = $row["skills"];
			$skills->skillOne = $row["skillOne"];
			$skills->skillTwo = $row["skillTwo"];
			$skills->skillThree = $row["skillThree"];
			$skills->skillFour = $row["skillFour"];
			$skills->skillFive = $row["skillFive"];
			$skills->tools = $row["tools"];
			$skills->toolOne = $row["toolOne"];
			$skills->toolTwo = $row["toolTwo"];
			$skills->toolThree = $row["toolThree"];
			$skills->toolFour = $row["toolFour"];
			$skills->toolFive = $row["toolFive"];
			$skills->remark = $row["remark"];
			$skills->createdBy = $row["createdBy"];
			$skills->createdAt = $row["createdAt"];
			$skills->updatedBy = $row["updatedBy"];			
			$skills->updatedAt = $row["updatedAt"];

			$data[] = $skills;
			//echo "姓名:".$row["firstname"]."  "."昵称:".$row["lastname"]."  "."年龄:".$row["age"]."<br>";
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式，微信只能对json格式的数据进行操作
	}else{
		echo "The data is empty!"."<br>";
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