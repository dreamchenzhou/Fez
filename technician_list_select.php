<?php
	//打开数据库连接
	include 'connect.php';

	//$sql_sel = 'select firstname, lastname, age from persons where 1=1';
	//$sql_sel = 'select cname, cphone, caddr, cnote from booking where 1=1';

	//带变量进行操作
	//$sql_sel = 'select firstname, lastname, age from persons where age>$_POST[name]';

	//$cage = intval('$_POST[note]');

	//常规操作
	$sql_sel = "select c_name, c_imgurl, c_birthdate, c_district, c_tech_1, c_tech_2, c_tech_3, c_tech_4, c_note from t_technician
				where c_district='$_POST[filter]' and (c_tech_1 = '$_POST[service]' or c_tech_1 = '$_POST[service]' 
				or c_tech_1 = '$_POST[service]' or c_tech_1 = '$_POST[service]');";

	$result = mysqli_query($conn,$sql_sel);

	class technician{
		public $c_name;
		public $c_imgurl;
		public $c_birthdate;
		public $c_district;
		public $c_tech_1;
		public $c_tech_2;
		public $c_tech_3;
		public $c_tech_4;
		public $c_note;
	}

	$data = array();

	if(mysqli_num_rows($result)>0)
	{
		//输出数据
		while($row=mysqli_fetch_assoc($result))
		{
			$technician = new technician();
			$technician->c_name = $row["c_name"];
			$technician->c_imgurl = $row["c_imgurl"];
			$technician->c_birthdate = $row["c_birthdate"];
			$technician->c_district = $row["c_district"];
			$technician->c_tech_1 = $row["c_tech_1"];
			$technician->c_tech_2 = $row["c_tech_2"];
			$technician->c_tech_3 = $row["c_tech_3"];
			$technician->c_tech_4 = $row["c_tech_4"];
			$technician->c_note = $row["c_note"];

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
		//echo 'The connect has been disconnect.'.'<br>';
	}else{
		//echo 'Fatal ERROR for database close.'.'<br>';
	}
?>