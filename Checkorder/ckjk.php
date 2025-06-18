<?php 
function getMillisecond() { 

    list($t1, $t2) = explode(' ', microtime()); 
  
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000); 
  
}
// 查课接口设置
function getWk($type, $noun, $school, $user, $pass, $name = false){
	global $DB;
	global $wk;
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$type}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	
    if ($type == "29") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=get";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    
    if ($type == "xy") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=get";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    //放在checkorder/ckjk.php内
   else  if ($type == "yqsl") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=get";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
//流年查课接口
if ($type == "liunian") {
$data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
$dx_rl = $a["url"];
$dx_url = "$dx_rl/api.php?act=get";
$result = get_url($dx_url, $data);
$result = json_decode($result, true);
return $result;
}
            //大雄学习平台查课接口 放在/Checkorder/ckjk.php 文件
    if ($type == "daxiong") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun, "kcid" => $kcid);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=get";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    return $result;}
    
	else {
    print_r("没有了,文件ckjk.php,可能故障：参数缺少，比如平台名错误！！！");die;
	}
}
 

?>