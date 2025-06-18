<?php
include('../confing/common.php');
if($islogin!=1){exit("<script language='javascript'>window.location.href='login';</script>");}
$sj=$DB->get_row("select uid,user,yqm,money,notice from qingka_wangke_user WHERE uid='{$userrow['uuid']}'");
$spsm=$DB->get_row("select content from qingka_wangke_class where cid='$cid'");

$dd=$DB->count("select count(oid) from qingka_wangke_order WHERE uid='{$userrow['uid']}' ");
$ck=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API查课' AND uid='{$userrow['uid']}' ");
$xd=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API添加任务' AND uid='{$userrow['uid']}' ");
if($ck==0 || $xd==0){
    $xdb=100;
}else{
    $xdb=round($xd/$ck,4)*100;
}
/*$jrck=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API查课' AND uid='{$userrow['uid']}' AND addtime>'$jtdate'");
$jrxd=$DB->count("SELECT count(id) FROM `qingka_wangke_log` WHERE type='API添加任务' AND uid='{$userrow['uid']}' AND addtime>'$jtdate'");
$jrxdbxz=20;
if($jrck==0 || $jrxd==0){
    $jrxdb=100;
}else{
    $jrxdb=round($jrxd/$jrck,4)*100;
}*/

?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?=$conf['sitename']?></title>
<meta name="keywords" content="<?=$conf['keywords'];?>" />
<meta name="description" content="<?=$conf['description'];?>" />
<link rel="icon" href="../favicon.ico" type="image/ico">
<meta name="author" content=" ">
<link rel="stylesheet" href="assets/css/element.css">
<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
<link rel="stylesheet" href="assets/css/apps.css" type="text/css" />
<link rel="stylesheet" href="assets/css/app.css" type="text/css" />
<link rel="stylesheet" href="assets/layui/css/layui.css" type="text/css" />
<!--<link href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">-->
<link rel="stylesheet" href="assets/LightYear/js/bootstrap-multitabs/multitabs.min.css">
<link href="assets/LightYear/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/LightYear/css/style.min.css" rel="stylesheet">
<link href="assets/LightYear/css/materialdesignicons.min.css" rel="stylesheet">
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="layer/3.1.1/layer.js"></script>


</head>
<?php
if($userrow['active']=="0"){
alert('您的账号已被封禁！','login');
}
// if($userrow['zcz']=="0"){
// alert('账号已限制登陆！','login');
// }
?>
<body>
