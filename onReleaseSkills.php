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
	$sql_ins = "insert into LS_SKILLS(objectId,account,name,telephone,region,province,city,district,village,skills,skillOne,skillTwo,skillThree,skillFour,skillFive,tools,toolOne,toolTwo,toolThree,toolFour,toolFive,remark,status,createdBy,createdAt,updatedBy,updatedAt) values(uuid(),'$_POST[objectId]','$_POST[name]','$_POST[telephone]','$_POST[region]','$_POST[province]','$_POST[city]','$_POST[district]','$_POST[village]','$_POST[choseTrait]','$_POST[traitOne]','$_POST[traitTwo]','$_POST[traitThree]','$_POST[traitFour]','$_POST[traitFive]','$_POST[choseTools]','$_POST[toolOne]','$_POST[toolTwo]','$_POST[toolThree]','$_POST[toolFour]','$_POST[toolFive]','$_POST[remark]',1,'$_POST[nickName]','$curDateTime','$_POST[nickName]','$curDateTime')";

	//$sql_ins = "insert into LS_SKILLS(objectId,account,name,telephone,region,province,city,district,village,skills,tools,remark,status,createdBy,createdAt,updatedBy,updatedAt) values(uuid(),'$_POST[objectId]','$_POST[name]','$_POST[telephone]','$_POST[region]','$_POST[province]','$_POST[city]','$_POST[district]','$_POST[village]','$_POST[choseTrait]','$_POST[choseTools]','$_POST[remark]',1,'$_POST[nickName]','$curDateTime','$_POST[nickName]','$curDateTime')";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote) values("$cname","$cphone","$caddr","$cnote")";

	//$sql_ins = "insert into booking(cname,cphone,caddr,cnote,cuserid) values('黄小龙', '18670000000','振业城二期3栋1208，测试', '要麻利的阿姨','89384')";

	//$sql_ins = "insert into t_service_booking(cdate,ctime,cservice) values('2018-08-23', '14:00','日常保洁')";

	if(!mysqli_query($conn,$sql_ins))
	{
		die('Error:'.mysqli_error($conn));
	}

	//echo "1 record added"."<br>";

	//关闭数据库
	if(mysqli_close($conn))
	{
		//echo 'The connect has been disconnect.'.'<br>';
	}else{
		//echo 'Fatal ERROR for database close.'.'<br>';
	}

?>