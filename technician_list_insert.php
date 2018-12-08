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


	//Error:You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '''')' at line 1
	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote) values('$_POST[name]','$_POST[phone]','$_POST[addr]','$_POST[note]')";

	/**$sql_ins = "insert into t_technician(c_name,c_imgurl,c_phone,c_id_num,c_district,
				c_address,c_tech_1,c_tech_2,c_tech_3,c_tech_4,c_note) values('$_POST[name]','$_POST[imgurl]','$_POST[phone]','$_POST[id_num]','$_POST[district]','$_POST[address]','$_POST[tech_1]','$_POST[tech_2]','$_POST[tech_3]','$_POST[tech_4]','$_POST[note]')";**/

	$sql_ins = "insert into t_technician(c_reg_date,c_name,c_sex,c_phone,c_imgurl,
				c_tech_1,c_tech_2,c_district,c_address,c_remark) values('$_POST[c_reg_date]','$_POST[c_name]','$_POST[c_sex]','$_POST[c_phone]','$_POST[c_imgurl]','$_POST[c_tech_1]','$_POST[c_tech_2]','$_POST[c_district]','$_POST[c_address]','$_POST[c_remark]')";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote) values("$cname","$cphone","$caddr","$cnote")";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote,cuserid) values('黄小龙', '18670000000','振业城二期3栋1208，测试', '要麻利的阿姨','89384')";

	//$sql_ins = "insert into t_service_booking(cdate,ctime,cservice) values('2018-08-23', '14:00','日常保洁')";

	if(!mysqli_query($conn,$sql_ins))
	{
		die('Error:'.mysqli_error($conn));
	}

	echo "1 record added"."<br>";

	//关闭数据库
	if(mysqli_close($conn))
	{
		echo 'The connect has been disconnect.'.'<br>';
	}else{
		echo 'Fatal ERROR for database close.'.'<br>';
	}

?>