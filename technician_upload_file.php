<!--?php
	$imgname = $_FILES['file']['name'];
	$tmp = $_FILES['file']['tmp_name'];
	$filepath = 'images/'  //自定义目录
	if(move_uploaded_file($tmp, $filepath.$imgname.".png")){
		echo "上传成功";
	} else {
		echo "上传失败";
	}
?-->

<?php
 	date_default_timezone_set("Asia/Shanghai"); //设置时区
	$code = $_FILES['file'];//获取小程序传来的图片
	if(is_uploaded_file($_FILES['file']['tmp_name'])) {  
    	//把文件转存到你希望的目录（不要使用copy函数）  
    	$uploaded_file=$_FILES['file']['tmp_name'];  
    	$username = "test";
   		//我们给每个用户动态的创建一个文件夹  
    	//$user_path=$_SERVER['DOCUMENT_ROOT']."/m_pro/".$username;  
    	$user_path = 'C:\xampp\htdocs\images';
    	//判断该用户文件夹是否已经有这个文件夹  
    	if(!file_exists($user_path)) {  
        	mkdir($user_path);  
    	}  
 
    	//$move_to_file=$user_path."/".$_FILES['file']['name'];  
    	$file_true_name=$_FILES['file']['name'];  
    	$move_to_file=$user_path."/".time().rand(1,1000)."-".date("Y-m-d").substr($file_true_name,strrpos($file_true_name,"."));//strrops($file_true,".")查找“.”在字符串中最后一次出现的位置  
    	//echo "$uploaded_file   $move_to_file";  
    	if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {  
        	echo $_FILES['file']['name']."--上传成功".date("Y-m-d H:i:sa"); 
 
    	} else {  
        	echo "上传失败".date("Y-m-d H:i:sa"); 
 
    	}  
	} else {  
    	echo "上传失败".date("Y-m-d H:i:sa");  
	}  

?>
