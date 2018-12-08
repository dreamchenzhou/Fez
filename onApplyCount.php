<?php
	//打开数据库连接
	include "connect.php";

	//$curDateTime = date('Y-m-d H:i:s');

	//$sql_sel = "select a.objectId,a.account,b.avatarUrl,a.name,a.telephone,a.region,a.province,a.city,a.district,a.village,a.skills,a.skillOne,a.skillTwo,a.skillThree,a.skillFour,a.skillFive,a.tools,a.toolOne,a.toolTwo,a.toolThree,a.toolFour,a.toolFive,a.remark,a.status,a.createdBy,a.createdAt,a.updatedBy,a.updatedAt from LS_SKILLS a, AUTH_USER b where a.objectId='$_POST[objectId]' and a.account = b.objectId and a.status=1 order by a.createdAt asc";

	$sql_sel = "select a.objectId,a.requestId,a.thingsId,a.acceptId,a.status,a.createdBy,a.createdAt,a.updatedBy,a.updatedAt from LS_BOOKING_AYI a where a.acceptId='$_POST[acceptId]' and a.status=1 order by a.createdAt asc";

	$result = mysqli_query($conn,$sql_sel);
	$count = mysqli_num_rows($result);

	/**class BookingAyi{
		public $objectId;
		public $requestId;
		public $thingsId;
		public $acceptId;
		public $status;
		public $createdBy;
		public $createdAt;
		public $updatedBy;
		public $updatedAt;
		public $count;
	}**/

	$data = array();

	if($count>0)
	{
		$data = $count;
		//输出数据
		/**while($row=mysqli_fetch_assoc($result))
		{
			$bookingAyi = new BookingAyi();
			$bookingAyi->objectId = $row["objectId"];
			$bookingAyi->requestId = $row["requestId"];
			$bookingAyi->thingsId = $row["thingsId"];
			$bookingAyi->acceptId = $row["acceptId"];
			$bookingAyi->status = $row["status"];
			$bookingAyi->createdBy = $row["createdBy"];
			$bookingAyi->createdAt = $row["createdAt"];
			$bookingAyi->updatedBy = $row["updatedBy"];			
			$bookingAyi->updatedAt = $row["updatedAt"];
			$data = $count;

			//$data[] = $bookingAyi;
			//echo "姓名:".$row["firstname"]."  "."昵称:".$row["lastname"]."  "."年龄:".$row["age"]."<br>";
		}**/
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