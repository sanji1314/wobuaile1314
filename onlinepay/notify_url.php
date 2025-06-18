<?php
@header('Content-Type: text/html; charset=UTF-8');
include("../confing/common.php");
require_once("epay/notify.class.php");
$out_trade_no = trim(strip_tags(daddslashes($_GET['out_trade_no']))) ? trim(strip_tags(daddslashes($_GET['out_trade_no']))) : '';

$date = DateTime::createFromFormat('U.u', microtime(true))->setTimezone(new DateTimeZone('Asia/Shanghai'))->format("Y-m-d H:i:s--u");
$type0 = isset($_GET['type0']) ? $_GET['type0'] : '';

$uid = $DB->get_row("select *  from qingka_wangke_pay where out_trade_no = '{$out_trade_no}' ");
$uid = $uid["uid"];
if($uid && $uid !== '1' && $type0 === 'tourist'){
    $user_result = $DB->get_row("select payData from qingka_wangke_user where uid = '{$uid}' ");
    $user_payData = json_decode($user_result["payData"],true);
    $alipay_config['apiurl'] = $user_payData['epay_api'];
    $alipay_config['partner'] = $user_payData['epay_pid'];
    $alipay_config['key'] = $user_payData['epay_key'];
    $alipay_config['sign_type'] = 'MD5';
    $alipay_config['input_charset'] = 'utf-8';
    $alipay_config['transport'] = 'http';
}

$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if ($verify_result) {
    $out_trade_no = isset($_GET['out_trade_no']) ? $_GET['out_trade_no'] : ''; // 商户单号
    $trade_no = isset($_GET['trade_no']) ? $_GET['trade_no'] : ''; // 支付宝交易号
    $trade_status = isset($_GET['trade_status']) ? $_GET['trade_status'] : ''; // 交易状态
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $money = isset($_GET['money']) ? $_GET['money'] : 0; // 金额
    $pid = isset($_GET['pid']) ? $_GET['pid'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    sleep(5);

    // 查询支付信息
	$srow = $DB->get_row("SELECT * FROM qingka_wangke_pay WHERE `out_trade_no`='$out_trade_no' LIMIT 1 FOR UPDATE");
	$userrow = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE uid='{$srow['uid']}'");
    
    // 顾客下单
    if($type0 === 'tourist'){
        if ($trade_status == 'TRADE_SUCCESS' && $srow && $srow['status'] == 0 && $srow['money'] == $money) {
            // 付款完成后，支付宝系统发送该交易状态通知
				// 更新支付状态
			$DB->query("UPDATE `qingka_wangke_pay` SET `status` ='1', `endtime` ='$date', `trade_no`='$trade_no' WHERE `out_trade_no`='$out_trade_no'");
				// 更新订单状态
			$DB->query("UPDATE `qingka_wangke_order` SET `status` ='待处理', `dockstatus` ='0',`paytime` = '$date' WHERE `out_trade_no`='$out_trade_no'");
			// 更新代理余额
			$DB->query("UPDATE `qingka_wangke_user` SET `money`=`money`-'{$srow['money2']}' WHERE `uid`='{$uid}'");
				// 记录日志
			wlog($uid, "顾客下单", "商铺 ".$uid." | 顾客成功下单,售价：{$money}，扣除店铺成本：{$srow['money2']}", -$srow['money2']);
			
            echo "success";
        }else{
            $DB->query("UPDATE `qingka_wangke_pay` SET `endtime` ='$date', `trade_no`='$trade_no' WHERE `out_trade_no`='$out_trade_no'");
                $DB->query("UPDATE `qingka_wangke_order` SET `status` ='待处理', `paytime` = '$date' WHERE `out_trade_no`='$out_trade_no'");
            echo "success";
        }
        exit();
    }
} else {
    echo "fail";
}

?>