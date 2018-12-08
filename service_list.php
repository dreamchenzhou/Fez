<?php
	//打开数据库连接
	include 'connect.php';

	//$sql_sel = 'select firstname, lastname, age from persons where 1=1';
	//$sql_sel = 'select cname, cphone, caddr, cnote from booking where 1=1';

	//带变量进行操作
	//$sql_sel = 'select firstname, lastname, age from persons where age>$_POST[name]';

	//$cage = intval('$_POST[note]');

	//常规操作
	$sql_sel = "select c_name, c_photo, c_birthdate, c_district, c_tech_1, c_tech_2, c_tech_3, c_tech_4 from t_technician
				where c_district='$_POST[filter]' and (c_tech_1 = '$_POST[service]' or c_tech_1 = '$_POST[service]' 
				or c_tech_1 = '$_POST[service]' or c_tech_1 = '$_POST[service]');";

	$result = mysqli_query($conn,$sql_sel);

	class technician{
		public $name;
		public $photo;
		public $birthdate;
		public $district;
		public $tech_1;
		public $tech_2;
		public $tech_3;
		public $tech_4;
	}

	$data = array();

	if(mysqli_num_rows($result)>0)
	{
		//输出数据
		while($row=mysqli_fetch_assoc($result))
		{	
			$technician = new technician();
			$technician->name = $row["name"];
			$technician->photo = $row["photo"];
			$technician->birthdate = $row["birthdate"];
			$technician->district = $row["district"];
			$technician->tech_1 = $row["tech_1"];
			$technician->tech_2 = $row["tech_2"];
			$technician->tech_3 = $row["tech_3"];
			$technician->tech_4 = $row["tech_4"];

			$data[] = $technician;
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