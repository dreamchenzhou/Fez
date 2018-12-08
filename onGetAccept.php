<?php
	//打开数据库连接
	include "connect.php";

	$curDateTime = date('Y-m-d H:i:s');

	//$sql_sel = "select a.objectId,a.account,b.avatarUrl,a.name,a.telephone,a.region,a.province,a.city,a.district,a.village,a.skills,a.skillOne,a.skillTwo,a.skillThree,a.skillFour,a.skillFive,a.tools,a.toolOne,a.toolTwo,a.toolThree,a.toolFour,a.toolFive,a.remark,a.status,a.createdBy,a.createdAt,a.updatedBy,a.updatedAt from LS_SKILLS a, AUTH_USER b where a.acceptId='$_POST[acceptId]' and a.account = b.objectId and a.status=1 order by a.createdAt asc";

	$sql_sel = "select a.objectId,a.account,a.name,a.telephone,a.region,a.province,a.city,a.district,a.village,a.skills,a.skillOne,a.skillTwo,a.skillThree,a.skillFour,a.skillFive,a.tools,a.toolOne,a.toolTwo,a.toolThree,a.toolFour,a.toolFive,a.remark,a.status,a.createdBy,a.createdAt,a.updatedBy,a.updatedAt from LS_SKILLS a, LS_BOOKING_AYI b where b.acceptId='$_POST[acceptId]' and a.objectId = b.thingsId and b.status = 1";

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