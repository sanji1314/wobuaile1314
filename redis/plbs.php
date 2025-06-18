<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");
while(true){
    $oid=$redis->lpop('plbsoid');
    if ($oid!='') {
        $a=budanWk($oid);
        $DB->query("update qingka_wangke_order set status='补刷中',`bsnum`=bsnum+1 where oid='{$oid}' ");
        if($a['code']==1){
            echo "订单id：".$oid."\r\n".$a['msg']."\r\n";
        }else{
            echo "订单id：".$oid."\r\n".$a['msg']."\r\n";
        }
        sleep(3);
    }
}
?>