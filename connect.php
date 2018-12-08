<?php
	//echo "This is the CONNECT page!"."<br>";

	$servername = "193.112.100.96";
	$username = "zuolinyoushe";
	$password = "yxhxl718439ait";
	$dbname = "zuolinyoushe";

	//连接数据库
	$conn = mysqli_connect($servername,$username,$password,$dbname);

	//编码设置
	mysqli_query($conn,"set character set 'utf8'");//读库 
	mysqli_query($conn,"set names 'utf8'");//写库
	//时区设置
	date_default_timezone_set("Asia/Shanghai");

	if(!$conn)
	{
		die('Could not connect:' .mysqli_connect_error());
	}

	//调用该文件必须必须要有关闭操作
	//mysqli_close($con);
?>