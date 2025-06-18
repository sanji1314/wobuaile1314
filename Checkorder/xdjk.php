<?php  

function wkname()
{
	$data = array(
	    "29" => "29",
	    "xy" => "小月模板",
	    "daxiong" => "大雄",
	    "liunian" => "流年",
	      "yqsl" => "yqsl",
	    );
	return $data;
}

function addWk($oid){
	global $DB;
	global $wk;
	$d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$cid = $d["cid"];
	$school = $d["school"];
	$user = $d["user"];
	$pass = $d["pass"];
	$kcid = $d["kcid"];
	$kcname = $d["kcname"];
	$noun = $d["noun"];
	$miaoshua = $d["miaoshua"];
	$b = $DB->get_row("select * from qingka_wangke_class where cid='{$cid}' ");
	$hid = $b["docking"];
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$hid}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	
	/*****
	 自己可以根据规则增加下单接口    
	 
	//XXXX下单接口
	else if ($type == "XXXX") {
	$data = array("optoken" => $token,"type" => $noun);  请求体参数自己加
	$XXXX_ul = $a["url"];      变量XXXX自己命名    获取顶级域名
	$XXXX_dingdan = "http://$XXXX_ul/api/CourseQuery/api/";    请求接口   XXXX自己命名
	$result = get_url($XXXX_dingdan, $data, $cookie); 
	$result = json_decode($result, true);
	
	if ($result["code"] == "0") {
		$b = array("code" => 1, "msg" => $result["msg"]);
	} else {
		$b = array("code" => -1, "msg" => $result["msg"]);
	}
	return $b;
    }
	
	
	$token  传的token
	$school  传的学校
	$user    传的账号
	$pass    传的密码
	$noun    传的平台里面的接口编号 
	$kcid    传的课程id
	****/
    if ($type == "29") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=add";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
        $b = array("code" => 1, "msg" => "下单成功");
        } else {
        $b = array("code" => -1, "msg" => $result["msg"]);
        }
    return $b;
    }

//流年下单接口
else if ($type == "liunian") {
$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
$dx_rl = $a["url"];
$dx_url = "$dx_rl/api.php?act=add";
$result = get_url($dx_url, $data);
$result = json_decode($result, true);
if ($result["code"] == "0") {
$b = array("code" => 1, "msg" => "下单成功");
} else {
$b = array("code" => -1, "msg" => $result["msg"]);
}
return $b;
} 
//放在checkorder/xdjk.php内
    else if ($type == "yqsl") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=add";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
            $b = array("code" => 1, "msg" => "下单成功");
        } else {
            $b = array("code" => -1, "msg" => $result["msg"]);
        }
        return $b;
    }
        if ($type == "xy") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid, "shichang" => $shichang, "score" => $score);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=add";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "0") {
        $b = array("code" => 1, "msg" => "下单成功");
        } else {
        $b = array("code" => -1, "msg" => $result["msg"]);
        }
    return $b;
    }
    
        //大雄学习平台下单接口 放在/Checkorder/xdjk.php 文件
    else if ($type == "daxiong") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=add";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    if ($result["code"] == "0") {
    $b = array("code" => 1, "msg" => "下单成功");
    } else {
    $b = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;} 
	else{
	    print_r("没有了,文件xdjk.php,可能故障：参数缺少，比如平台名错误！！！");die;
	}
	
}


?>