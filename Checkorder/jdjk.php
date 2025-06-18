<?php

function processCx($oid)
{
	global $DB;
	$d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$b = $DB->get_row("select hid,user,pass from qingka_wangke_order where oid='{$oid}' ");
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$b["hid"]}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	$user = $b["user"];
	$pass = $b["pass"];
	$kcname = $d["kcname"];
	$school = $d["school"];
	$pt = $d["noun"];
	$kcid = $d["kcid"];
	
    if ($type == "29") {
        $data = array("username" => $user);
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api.php?act=chadan";
        $result = get_url($dx_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
        foreach ($result["data"] as $res) {
        $yid = $res["id"];
        $kcname = $res["kcname"];
        $status = $res["status"];
        $process = $res["process"];
        $remarks = $res["remarks"];
        $kcks = $res["courseStartTime"];
        $kcjs = $res["courseEndTime"];
        $ksks = $res["examStartTime"];
        $ksjs = $res["examEndTime"];
        $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
        }
        } else {
        $b[] = array("code" => -1, "msg" => $result["msg"]);
        }
        return $b;
    }
//流年进度新接口
else if ($type == "liunian") {
$dx_rl = $a["url"];
$dx_url = "$dx_rl/api/chadan?uid=".$a["user"]."&key=".$a["pass"]."&kcname=".$kcname."&username=".$user."&cid=".$d["noun"];
$result = get_url($dx_url,$data);
$result = json_decode($result, true);
if ($result["code"] == "1") {
foreach ($result["data"] as $res) {
$yid = $res["id"];
$kcname = $res["kcname"];
$status = $res["status"];
$process = $res["process"];
$remarks = $res["remarks"];
$kcks = $res["courseStartTime"];
$kcjs = $res["courseEndTime"];
$ksks = $res["examStartTime"];
$ksjs = $res["examEndTime"];
$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
}
} else {
$b[] = array("code" => -1, "msg" => $result["msg"]);
}
return $b;
}
    //放在checkorder/jdjk.php内
else if ($type == "xy") {
        $uu_rl = $a["url"]; 
        $uu_url = "$uu_rl/api/search?uid=".$a["user"]."&key=".$a["pass"]."&kcname=".$kcname."&username=".$user."&cid=".$d["noun"]; $result = get_url($uu_url,$data); $result = json_decode($result, true); if ($result["code"] == "1") { foreach ($result["data"] as $res) { $yid = $res["id"]; $kcname = $res["kcname"]; $status = $res["status"]; $process = $res["process"]; $remarks = $res["remarks"]; $kcks = $res["courseStartTime"]; $kcjs = $res["courseEndTime"]; $ksks = $res["examStartTime"]; $ksjs = $res["examEndTime"]; $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks); } } else { $b[] = array("code" => -1, "msg" => $result["msg"]); } return $b; }
    if ($type == "cy") {
        $data = array("username" => $user);
        $ace_rl = $a["url"];
        $ace_url = "$ace_rl/api.php?act=chadan";
        $result = get_url($ace_url, $data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
        foreach ($result["data"] as $res) {
        $yid = $res["id"];
        $kcname = $res["kcname"];
        $status = $res["status"];
        $res1 = explode(':', $res["remarks"]);
        $s = explode('/', $res1[1]);
        $bfb =round($s[0]/$s[1],4)*100;
        $process = $bfb."%";
        $remarks = '当前进度：'.$res["process"];
        
        $kcks = $res["courseStartTime"];
        $kcjs = $res["courseEndTime"];
        $ksks = $res["examStartTime"];
        $ksjs = $res["examEndTime"];
        $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
    }
    } else {
    $b[] = array("code" => -1, "msg" => $result["msg"]);
    }
    return $b;
    }
    //放在checkorder/jdjk.php内
else if ($type == "yqsl") { 
$uu_rl = $a["url"]; 
$uu_url = "$uu_rl/api/search?uid=".$a["user"]."&key=".$a["pass"]."&kcname=".$kcname."&username=".$user."&cid=".$d["noun"]; 
$result = get_url($uu_url,$data); 
$result = json_decode($result, true); if ($result["code"] == "1") { 
foreach ($result["data"] as $res) { 
$yid = $res["id"]; 
$kcname = $res["kcname"]; 
$status = $res["status"]; 
$process = $res["process"]; 
$remarks = $res["remarks"]; 
$kcks = $res["courseStartTime"]; 
$kcjs = $res["courseEndTime"]; 
$ksks = $res["examStartTime"]; 
$ksjs = $res["examEndTime"];
 $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks); } 
} else { 
$b[] = array("code" => -1, "msg" => $result["msg"]); } 
return $b;
}
        //大雄学习平台进度新接口 放在/Checkorder/jdjk.php 文件
        else if ($type == "daxiong") {
        $dx_rl = $a["url"];
        $dx_url = "$dx_rl/api/search?uid=".$a["user"]."&key=".$a["pass"]."&kcname=".$kcname."&username=".$user."&cid=".$d["noun"];
        $result = get_url($dx_url,$data);
        $result = json_decode($result, true);
        if ($result["code"] == "1") {
        foreach ($result["data"] as $res) {
        $yid = $res["id"];
        $kcname = $res["kcname"];
        $status = $res["status"];
        $process = $res["process"];
        $remarks = $res["remarks"];
        $kcks = $res["courseStartTime"];
        $kcjs = $res["courseEndTime"];
        $ksks = $res["examStartTime"];
        $ksjs = $res["examEndTime"];
        $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
        }
        } else {
        $b[] = array("code" => -1, "msg" => $result["msg"]);
        }
        return $b;}
	else {
       $b[] = array("code" => -1, "msg" => "查询失败,请联系管理员"); 
	}
	
	
	  
	
}

?>