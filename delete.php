<?php
	//打开数据库连接
	include "connect.php";

	$sql_sel = "select age from persons";

	$result = mysqli_query($conn,$sql_sel);

	if(mysqli_num_rows($result)>0)
	{
		//输出数据
		while($row=mysqli_fetch_assoc($result))
		{	
			echo "Age:".$row["age"]."<br>";
			if($row["age"]<18)
			{
				$sql_del = "delete from persons where age<18";
				mysqli_query($conn,$sql_del);
				echo "The record of AGE is ".$row["age"]." years old has been deleted."."<br>";
			}
		}
	}

	//关闭数据库
	if(mysqli_close($conn))
	{
		echo 'The connect has been disconnect.'.'<br>';
	}else{
		echo 'Fatal ERROR for database close.'.'<br>';
	}
?>