<?php  
function budanWk($oid){
	global $DB;
	global $wk;
	$d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$b = $DB->get_row("select hid,yid,user from qingka_wangke_order where oid='{$oid}' ");
	$hid = $b["hid"];
	$yid = $b["yid"];
	$user = $b["user"];
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$hid}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	$cid = $d["cid"];
	$school = $d["school"];
	$user = $d["user"];
	$pass = $d["pass"];
	$kcid = $d["kcid"];
	$kcname = $d["kcname"];
	$noun = $d["noun"];
	$miaoshua = $d["miaoshua"];

    if ($type == "29") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=budan";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }
    
    if ($type == "xy") {
        $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=budan";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        return $result;
    }

//流年补刷接口
if ($type == "liunian") {
$data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
$dx_rl = $a["url"];
$dx_url = "$dx_rl/api.php?act=budan";
$result = get_url($dx_url, $data);
$result = json_decode($result, true);
return $result;
}
//放在checkorder/bsjk.php内
	else if ($type == "yqsl") {
	$data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
	$dx_rl = $a["url"];
	$dx_url = "$dx_rl/api.php?act=budan";
	$result = get_url($dx_url, $data);
	$result = json_decode($result, true);
	return $result;
	
}

         //大雄学习平台补刷 放在/Checkorder/bsjk.php 文件
    if ($type == "daxiong") {
    $data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
    $dx_rl = $a["url"];
    $dx_url = "$dx_rl/api.php?act=budan";
    $result = get_url($dx_url, $data);
    $result = json_decode($result, true);
    return $result;}
	else {
				$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
		}
}




?>