<?php
	//打开数据库连接
	include 'connect.php';

	//$sql_sel = 'select firstname, lastname, age from persons where 1=1';
	//$sql_sel = 'select cname, cphone, caddr, cnote from booking where 1=1';

	//带变量进行操作
	//$sql_sel = 'select firstname, lastname, age from persons where age>$_POST[name]';

	//$cage = intval('$_POST[note]');

	//常规操作
	//$sql_sel = "select c_name, c_imgurl, c_birthdate, c_district, c_tech_1, c_tech_2, c_tech_3, c_tech_4, c_note from t_technician
				//where c_district='$_POST[filter]' and (c_tech_1 = '$_POST[service]' or c_tech_1 = '$_POST[service]' 
				//or c_tech_1 = '$_POST[service]' or c_tech_1 = '$_POST[service]');";

	//$sql_sel = "select nowtime,name,telephone,service,date,time,region,village,area,servicetrait,remark from t_service where where region like '$_POST[region]' and service='$_POST[service]';";

	$sql_sel = "select nowtime,name,telephone,service,date,time,region,village,area,servicetrait,remark from t_service where service='$_POST[service]';";


	$result = mysqli_query($conn,$sql_sel);

	class service{
		public $name;
		public $telephone;
		public $service;
		public $date;
		public $time;
		public $region;
		public $area;
		public $village;
		public $servicetrait;
		public $remark;
	}

	$data = array();

	if(mysqli_num_rows($result)>0)
	{
		//输出数据
		while($row=mysqli_fetch_assoc($result))
		{
			$service = new service();
			$service->name = $row["name"];
			$service->telephone = $row["telephone"];
			$service->service = $row["service"];
			$service->date = $row["date"];
			$service->time = $row["time"];
			$service->region = $row["region"];
			$service->area = $row["area"];
			$service->village = $row["village"];
			$service->servicetrait = $row["servicetrait"];
			$service->remark = $row["remark"];

			$data[] = $service;
			//echo "姓名:".$row["firstname"]."  "."昵称:".$row["lastname"]."  "."年龄:".$row["age"]."<br>";
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式，微信只能对json格式的数据进行操作
	}else{
		echo "The data is empty!"."<br>";
	}

	//关闭数据库
	if(mysqli_close($conn))
	{
		//echo 'The connect has been disconnect.'.'<br>';
	}else{
		//echo 'Fatal ERROR for database close.'.'<br>';
	}
?>