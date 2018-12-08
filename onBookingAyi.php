<?php
	//打开数据库连接
	include "connect.php";

	$curDateTime = date('Y-m-d H:i:s');

	//插入一条预定记录
	$sql_ins = "insert into LS_BOOKING_AYI(objectId,requestId,thingsId,acceptId,status,createdBy,createdAt,updatedBy,updatedAt) values(uuid(),'$_POST[requestId]','$_POST[thingsId]','$_POST[acceptId]',1,'$_POST[nickName]','$curDateTime','$_POST[nickName]','$curDateTime')";

	//更新当前技能，如果被预定了，其技能则暂时被隐藏
	$sql_upt = "update LS_SKILLS set status = 0 where objectId= '$_POST[thingsId]' and status = 1";

	if(!mysqli_query($conn,$sql_ins))
	{
		die('Error:'.mysqli_error($conn));
	}

	if(!mysqli_query($conn,$sql_upt))
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