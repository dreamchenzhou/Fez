<?php

    include_once "wxBizDataCrypt.php";
    include "http.php";
    include "connect.php";


    $appid="wxd1705da19e26cc90";//微信开发者appId
    $secret="148610d2678bd387767801cf0ec596cc";// appId秘钥
    $code =$_POST['code'];
    $signature =$_POST['signature'];

    //示例：code是动态的，一旦用过则失效
    //https://api.weixin.qq.com/sns/jscode2session?appid=wxd1705da19e26cc90&secret=293468ff717a909a1e0aa4d9cb3220e0&js_code=023ipVCT17Abe61BiXBT19cFCT1ipVCx&grant_type=authorization_code
    $api="https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code"; //调用官方接口

    //$info = file_get_contents($api);//发送HTTPs请求并获取返回的数据，推荐使用curl
    $json = httpGet($api); //执行方法：从接口中获取内容（json格式）

    //在获取值之前需要做一下判断
    //$openId = $obj->{'openid'}; 另外一种引用方法，还不确定
    $arr = json_decode($json,true);
    //echo $arr;

    //$arr = get_object_vars($arr);

    //if($arr['openid'] != NULL &&  $arr['session_key'] != NULL){
        $openId = $arr['openid'];
        $sessionKey = $arr['session_key'];
        //只有用户关注了微信公众号且小程序绑定了微信公众号才可能获取到
        //$unionId = $arr['unionid'];
        
        //数字签名校验
        $signature2 = sha1($_POST['rawData'].$sessionKey);
        if($signature != $signature2){
            echo "数字签名校验失败";
            die('signature failed');
        }

    /**} else {
        $errCode = $arr['errcode'];
        $errMsg = $arr['errmsg'];
    }**/

    //用于用户注册或登录验证
    $encryptedData = $_POST['encryptedData'];
    $iv = $_POST['iv'];
    
    //账号密码信息
    $account = $_POST['account'];
    $password = $_POST['password'];

    
    $length = 20;
    //生成一串随机字符串作为盐值
    function getRandomString($length){
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length*2);
            if ($bytes === false){
                throw new RuntimeException('Unable to generate a random string');
            }
            return substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);
        }
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //echo $pool;
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    //$salt = openssl_random_pseudo_bytes(16); //函数不存在
    //$salt=base64_encode(mcrypt_create_iv(32,MCRYPT_DEV_RANDOM)); //乱码
    $iterations = 1000;
    $salt = getRandomString($length);
    //echo 'salt:'.$salt;
    $password = hash_pbkdf2("sha256", $password, $salt, $iterations, 20);
    //echo 'password'.$password;
    //echo $salt;
    //echo $password;

    //用于用户信息管理的
    /**$nickName = $_POST['nickName'];
    $avataUrl = $_POST['avataUrl'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $country = $_POST['country'];
    $language = $_POST['language'];**/

    $curDateTime = date('Y-m-d H:i:s');

    /*if($obj->session_key != NULL && $obj->openid != NULL){
        $sessionKey = $obj->session_key;
        $openId = $obj->openid;
    } else {
        $errCode = $obj->errcode;
        $errMsg = $obj->errmsg;
    }*/

    /**class userStatus{
        public $isAuth;
        public $isRegister;
        public $isLogin;
    }**/

    class User{
        //用户信息
        public $userId;
        public $telephone;
        public $account;
        public $password;
        public $salt;
        public $role;
        public $online;
        public $openId;
        public $nickName;
        public $avatarUrl;
        public $gender;
        public $city;
        public $province;
        public $country;
        public $language;
        public $status;
        public $createdBy;
        public $createdAt;
        public $updatedBy;
        public $updatedAt;
        //用户状态
        public $isAuth;
        public $isRegister;
        public $isLogin;
    }

    $user = new User(); //生成一个对象实例

    $userInfo = array();
    $data = array();
    //$status = array();

    if(empty($signature) || empty($encryptedData) || empty($iv)){
        echo "传递信息不全";
    }

    //1、encryptedData和iv为前台传过来的参数(密文)；
    //2、若$errCode !=0 则验证失败，接口应该返回失败数据；
    //3、获取用户详细信息，$data为解密后的用户基本信息，json格式；
    $pc = new WXBizDataCrypt($appid, $sessionKey);
    $errCode = $pc->decryptData($encryptedData, $iv, $userInfo);

    //userStatus = new userStatus();//生成一个对象实例
    //$User = new User(); //生成一个对象实例

    if($conn && $errCode != 0){
        echo "解密数据失败";
        echo 'failed'.mysqli_error($conn);
        print($errCode . "\n");
        die('解密数据失败');
        //用户状态
        $user->userId = '';
        $user->isAuth = 0;
        $user->isRegister = 0;
        $user->isLogin = 0;

        $data = $user;

    } else{
        $userInfo = json_decode($userInfo,true); //解密用户信息，用作以下校验用
        //用户信息
        $user->userId = '';
        $user->telephone = $account;
        $user->account = $account;
        $user->password = $password;
        $user->salt = $salt;
        $user->role = 1;
        $user->openId = $userInfo['openId'];
        $user->nickName = $userInfo['nickName'];
        $user->avatarUrl = $userInfo['avatarUrl'];
        $user->gender = $userInfo['gender'];
        $user->city = $userInfo['city'];
        $user->province = $userInfo['province'];
        $user->country = $userInfo['country'];
        $user->language = $userInfo['language'];
        $user->status = 1;
        $user->createdBy = $userInfo['nickName'];
        $user->createdAt = $curDateTime;
        $user->updatedBy = $userInfo['nickName'];
        $user->updatedAt = $curDateTime;
        //用户状态
        $user->isAuth = 0;
        $user->isRegister = 0;
        $user->isLogin = 0;

        $data = $user;

        if(mysqli_select_db($conn, $dbname)){
            $sql_sel_user = "select userId,account,openId from SM_USER where status = 1 and (account='$user->account' or openId='$user->openId') limit 1";
            //echo $sql_sel_user;
            $result = mysqli_query($conn, $sql_sel_user);
            if(mysqli_num_rows($result)>0){ //如果数据库中存在此用户信息，则不需要重新获取
                //输出数据
                if($row=mysqli_fetch_assoc($result)){
                    //echo '输出数据';
                //{   
                    if($user->account == $row['account'] || $user->openId == $row['openId']){  //判断账号是否存在
                        $user->userId = $row['userId'];
                        $user->isLogin = 0;
                        $user->isAuth = 1;
                        $user->isRegister = 2;  //0, 未注册  1，已经注册

                        $data = $user;
                    }
                    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
                    //echo "姓名:".$row["firstname"]."  "."昵称:".$row["lastname"]."  "."年龄:".$row["age"]."<br>";
                }
                //echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式，微信只能对json格式的数据进行操作
            }else{//插入AUTH_USER表，针对第一次注册
                if($user->gender == 0){
                    $user->gender = 'none';
                } else{
                    $user->gender = 1 ? 'man' : 'women';
                }

                $sql_ins_user = "insert into SM_USER(userId,telephone,account,password,salt,role,openId,unionId,nickName,avatarUrl,gender,city,province,country,language,status,createdBy,createdAt,updatedBy,updatedAt) values(uuid(),'$user->telephone','$user->account','$user->password','$user->salt','$user->role','$user->openId','','$user->nickName','$user->avatarUrl','$user->gender','$user->city','$user->province','$user->country','$user->language',$user->status,'$user->createdBy','$user->createdAt','$user->updatedBy','$user->updatedAt')";

                //echo $sql_ins_user;
                $result = mysqli_query($conn, $sql_ins_user);
                //echo $result;
                if($result){
                    $sql_uuid = "select userId from SM_USER where status = 1 and (account='$user->account' or openId='$user->openId') limit 1";
                    $result_uuid = mysqli_query($conn, $sql_uuid);
                    if(mysqli_num_rows($result_uuid)>0){ //如果数据库中存在此用户信息，则不需要重新获取
                    //输出数据
                        if($rowUUID=mysqli_fetch_assoc($result_uuid)){
                            $user->userId = $rowUUID['userId'];
                            $user->isLogin = 1;
                            $user->isAuth = 1;
                            $user->isRegister = 1;  //0, 未注册  1，已经注册
                            $data = $user;
                            //echo '用户注册成功！';
                            echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式，微信只能对json格式的数据进行操作
                        }
                    }
                } else {
                    echo 'error';
                    die('failed'.mysqli_error($conn));
                }
            } 
            //生成第三方3rd_session
            /**$session3rd = null;
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
            $max = strlen($strPol) - 1;
            for($i=0;$i<16;$i++){
                $session3rd .= $strPol[rand(0,$max)];
                echo $session3rd;
            }**/
        } else {
            $user->isLogin = 0;
            $user->isAuth = 1;
            $user->isRegister = 0;  ////0, 未注册  1，已经注册
            $data = $user;
            //echo '用户注册成功！';
            echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//
        }
    }

    //关闭数据库
    if(mysqli_close($conn))
    {
        //echo 'The connect has been disconnect.'.'<br>';
    }else{
        //echo 'Fatal ERROR for database close.'.'<br>';
    }

?>
