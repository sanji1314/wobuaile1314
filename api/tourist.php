<?php

include('../confing/common.php');

// 安全权限控制
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    exit("你想干啥？-1");
}

$act = daddslashes($_GET['act']) ? daddslashes($_GET['act']) : null;

$aduid = empty($userrow['uid']) ? $userrow['uid'] : null;

// 验证是否是后台请求
function is_admin()
{
    global $aduid;
    if (!empty($aduid)) {
        return_403();
    }
}

$touristUID = trim(strip_tags(daddslashes($_POST['uid'])))?trim(strip_tags(daddslashes($_POST['uid']))):"";
$user = $DB->get_row("select * from qingka_wangke_user where uid = '{$touristUID}' limit 1 ");

function json_decode_fn($old_data){
    $pattern = '/\{(?:[^{}]|(?R))*\}/'; // 匹配 {...} 形式的内容，保证不会匹配到嵌套的对象
        preg_match_all($pattern, $old_data, $matches);
        $return_data = [];
        foreach ($matches[0] as $match) {
            // 修复非法的转义字符
            $match = preg_replace_callback(
                '/\\\\(?:["\\\\\/bfnrt]|u[0-9a-fA-F]{4})/',
                function($match) {
                    return stripslashes($match[0]);
                },
                $match
            );
        
            // 修复非法的数字格式
            // 移除数字中的引号，确保数字格式正确
            // $match = preg_replace('/"(\d+\.?\d*|\.\d+)"/', '$1', $match);
        
            // 修复非法的字符编码
            // 使用 mb_convert_encoding 函数将字符串转换为 UTF-8 编码
            $match = mb_convert_encoding($match, 'UTF-8', mb_detect_encoding($match));
        
            // 修复非法的结构
            // 如果 JSON 字符串结尾不是 }，则补全
            if (substr($match, -1) !== '}') {
                $match .= '}';
            }
        
            // 将空格编码成 \u0020
            $encoded_match = preg_replace('/\s/', '\u0020', $match);
        
            // 解析编码后的 JSON 字符串
            $decoded_data = json_decode($encoded_match, true);
        
            // 将解析后的数据添加到数组中
            $return_data[] = $decoded_data;
        }
        return $return_data;
}

function cldata_init(){
    global $DB;
    global $conf;
    global $touristUID;
    global $user;

    $DB->query("update qingka_wangke_user set fldata='' where uid=$touristUID");
    $DB->query("update qingka_wangke_user set cldata='' where uid=$touristUID");

    $class_result = $DB->query("select * from qingka_wangke_class order by cid");
    $class_data = [];
    while ($row = $DB->fetch($class_result)) {
        $class_data[] = $row;
    }

    foreach ($class_data as $key => $value) {
        $mall_custom = json_decode($value["mall_custom"], true);
        $has = array_filter($mall_custom, function($item) use ($touristUID) {
            return $item['uid'] == $touristUID;
        });
        $has_count = count($has);

        if ($value['yunsuan'] == "*") {
            $price = round($value['price'] * $user['addprice'], 2);
        } elseif ($value['yunsuan'] == "+") {
            $price = round($value['price'] + $user['addprice'], 2);
        } else {
            $price = round($value['price'] * $user['addprice'], 2);
        }

        $duli_config = [
            "uid" => $touristUID,
            "name" => $value["name"],
            "price" => $price,
            "status" => 0,
            "fenlei" => $value["fenlei"],
        ];

        if (empty($has_count)) {
            $mall_custom[] = $duli_config;
            $mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
            $DB->query("update qingka_wangke_class set mall_custom='$mall_custom' where cid='{$value['cid']}' ");
            continue;
        } else {
            foreach ($mall_custom as $key2 => $value2) {
                if ($value2["uid"] == $touristUID) {
                    $mall_custom[$key2]["name"] = $duli_config["name"];
                    $mall_custom[$key2]["price"] = $duli_config["price"];
                    $mall_custom[$key2]["fenlei"] = $duli_config["fenlei"];
                    $mall_custom[$key2]["status"] = 0; // 确保所有商品初始化为下架状态
                    foreach ($duli_config as $key3 => $value3) {
                        if (!array_key_exists($key3, $value2)) {
                            $mall_custom[$key2][$key3] = $value3;
                        }
                    }
                }
            }
            $mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
            $DB->query("update qingka_wangke_class set mall_custom='$mall_custom' where cid='{$value['cid']}' ");
        }
    }
    return true;
}

function fldata_init(){
    
    global $DB;
    global $touristUID;
    global $user;
    
    $DB->query("update qingka_wangke_user set fldata='' where uid=$touristUID");
    $DB->query("update qingka_wangke_user set cldata='' where uid=$touristUID");
    
    //初始化分类
        $fenlei_result =$DB->query("select * from qingka_wangke_fenlei order by id");
        $fenlei_data = [];
        while ($row = $DB->fetch($fenlei_result)) {
            $fenlei_data[]=$row;
        }
        
        foreach ($fenlei_data as $key => $value){
            $mall_custom = json_decode($value["mall_custom"],true);
            $has = array_filter($mall_custom, function($item) use ($touristUID) {
                return $item['uid'] == $touristUID;
            });
            $has_count = count($has);
            // 独立配置
            $duli_config = [
                "uid"=>$touristUID,
                "name"=>$value["name"],
                "status"=> 1,
            ];
            if(empty($has_count)){
                // 添加代理
                $mall_custom[] = $duli_config;
                $mall_custom =json_encode($mall_custom,JSON_UNESCAPED_UNICODE);
                 $DB->query("update qingka_wangke_fenlei set mall_custom='$mall_custom' where id='{$value['id']}' ");
                continue;
            }else{
                 // 如果存在
                foreach($mall_custom as $key2 => $value2){
                    // 匹配代理
                    if($value2["uid"] == $touristUID){
                        
                        foreach ($duli_config as $key3 => $value3){
                            // 如果有新键
                            if($value["status"] == 0){
                                $mall_custom[$key2]["status"] = 0;
                            }
                            if(!array_key_exists($key3, $value2)){
                                $mall_custom[$key2][$key3] = $value3;
                                continue;
                            }
                        }
                    }
                }
                
                
                
                $mall_custom =json_encode($mall_custom,JSON_UNESCAPED_UNICODE);
                 $DB->query("update qingka_wangke_fenlei set mall_custom='$mall_custom' where id='{$value['id']}' ");
            }
            
        }
    
    return $result?true:false;
}

function paydata_init(){
    
    global $DB;
    global $touristUID;
    
    $payData = [
        "type"=>"0",
        "epay_api"=> "https://pay.69yzf.cn/",// 易支付API
        "epay_pid"=> "",// 商户ID
        "epay_key"=> "",// 商户KEY
        "is_alipay"=>"1",
        "is_wxpay"=>"0",
        "is_qqpay"=>"0",
    ];
    $updated_paydata = json_encode($payData, JSON_UNESCAPED_UNICODE);
    $result = $DB->query("UPDATE qingka_wangke_user SET paydata='{$updated_paydata}' WHERE uid='{$touristUID}'");
    return $result?true:false;
}

global $conf;

$date = (new DateTime())->setTimezone(new DateTimeZone('Asia/Shanghai'))->format("Y-m-d H:i:s");

switch ($act) {
    // 前台
    
    case 'v_ok':
        // 检测是否需要初始化
        if(empty($touristUID)){
            jsonReturn(-1,"商城不存在");
        }
        
        $user = $DB->get_row("select uid,tourist,touristData from qingka_wangke_user where uid = '{$touristUID}' limit 1 ");
        if(empty($user)){
            jsonReturn(-1,"商城不存在");
        }
        if(empty($user["tourist"])){
            exit(json_encode([ "code" => 1, "msg" => "未初始化", "ok"=>0,"uid"=>$touristUID]));
        }else{
            $touristdata = str_replace("\n", '\\n', $user["touristData"]);
            $touristdata = json_decode($touristdata, true);;
            
            exit(json_encode([ "code" => 1, "msg" => "已初始化", "ok"=>1,"uid"=>$touristUID,"webConfig"=>$touristdata] ));
        }
        
        break;
    // 进行初始化
   case "dataInit":
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    if (!$uid) {
        exit(json_encode(["code" => -1, "msg" => "参数不足"]));
    }

    // 获取当前用户的 addprice 值
    $user = $DB->get_row("SELECT addprice FROM qingka_wangke_user WHERE uid = '{$uid}' LIMIT 1");
    $addprice = $user["addprice"];

  // 初始化其他数据
    cldata_init();
    fldata_init();
    paydata_init();

    // 检查是否需要初始化 touristdata
    if (!is_array(json_decode($user["touristdata"], true))) {
        $touristdata = [
            "sitename" => ($uid == 1 ? $conf["sitename"] : $user["name"]) . '的铺子',
            "notice" => '',
            "qqkefu" => !empty($user["qq"]) ? $user["qq"] : $user["user"],
        ];
        $touristdata2 = json_encode($touristdata, JSON_UNESCAPED_UNICODE);
        $DB->query("UPDATE qingka_wangke_user SET touristdata='{$touristdata2}' WHERE uid='$uid'");
    }

    // 更新初始化状态
    $DB->query("UPDATE qingka_wangke_user SET tourist=1 WHERE uid=$uid");

    // 重置商品价格为成本价
    $class_result = $DB->query("SELECT cid, mall_custom, price, yunsuan FROM qingka_wangke_class WHERE status != 0");
    while ($row = $DB->fetch($class_result)) {
        $mall_custom = json_decode($row["mall_custom"], true);
        foreach ($mall_custom as $key => $value) {
            if ($value["uid"] == $uid) {
                // 计算成本价
                if ($row['yunsuan'] == "*") {
                    $cost_price = round($row['price'] * $addprice, 2);
                } elseif ($row['yunsuan'] == "+") {
                    $cost_price = round($row['price'] + $addprice, 2);
                } else {
                    $cost_price = round($row['price'] * $addprice, 2);
                }
                // 更新商品售价为成本价
                $mall_custom[$key]['price'] = $cost_price;
            }
        }
        $updated_mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
        $DB->query("UPDATE qingka_wangke_class SET mall_custom='$updated_mall_custom' WHERE cid='{$row['cid']}'");
    }

    exit(json_encode(["code" => 1, "msg" => "完成"]));
break;
    case "getfenlei":
        $uid = trim(strip_tags(daddslashes($_POST['uid'])))?trim(strip_tags(daddslashes($_POST['uid']))):"1";
        fldata_init();
        $count1 = $DB->count("select count(*) from qingka_wangke_fenlei where status=1 or status=2 order by time desc");
        $fenlei_result = $DB->query("select * from qingka_wangke_fenlei where status!=3 order by time desc");
        $fenlei_data = [];
        while ($row = $DB->fetch($fenlei_result)) {
            $fenlei_data[]=$row;
        }
        $data = [];
        foreach ($fenlei_data as $key => $value){
            $mall_custom = json_decode($value["mall_custom"],true);
            foreach ($mall_custom as $key2 => $value2){
                if($value2["uid"] == $touristUID){
                    // 计算价格
                    if ($value['yunsuan'] == "*") {
                        $price = round($value['price'] * $user['addprice'], 2);
                    } elseif ($value['yunsuan'] == "+") {
                        $price = round($value['price'] + $user['addprice'], 2);
                    } else {
                        $price = round($value['price'] * $user['addprice'], 2);
                    }
                    
                    if($value2["status"] == 1){
                        $data[]=[
                            "id" => $value["id"],
                            "name" => $value2["name"],
                        ];
                    }
                    
                }
            }
        }
        
        $data = array('code' => 1, 'data' => $data,'count' => $count1);
        exit(json_encode($data));
        
        break;
       case "getclass":
        $uid = trim(strip_tags(daddslashes($_POST['uid'])))?trim(strip_tags(daddslashes($_POST['uid']))):"1";
        $fenlei = trim(strip_tags(daddslashes($_POST['fenlei'])));
        
        $class_result = $DB->query("select * from qingka_wangke_class where status=1 order by cid ASC ");
        $class_data = [];
        while ($row = $DB->fetch($class_result)) {
            $class_data[]=$row;
        }
        
        $data = [];
        foreach ($class_result as $key => $value){
            $mall_custom = json_decode($value["mall_custom"],true);
            foreach ($mall_custom as $key2 => $value2){
                if($value2["uid"] == $uid){
                    if($value2["status"] == 1){
                        if(!empty($fenlei) && $fenlei == $value2["fenlei"]){
                            $data[]= [
                                "cid" => $value["cid"],
                                "name" => $value2["name"],
                                "price" => $value2["price"],
                                "getnoun" => $value["getnoun"],
                                "content" => $value["content"],
                            ];
                        }else if(empty($fenlei)){
                            $data[]= [
                                "cid" => $value["cid"],
                                "name" => $value2["name"],
                                "price" => $value2["price"],
                                "getnoun" => $value["getnoun"],
                                "content" => $value["content"],
                            ];
                        }
                    }
                }
            }
        }
        
        $count1 = count($data);
        
        $data = array('code' => 1, 'data' => $data,'count' => $count1,"a"=>$fenlei);
        exit(json_encode($data));
        

        break;
    case "get":
        $cid = trim(strip_tags(daddslashes($_POST['cid'])));
        $userinfo = daddslashes($_POST['userinfo']);

        $hash = daddslashes($_POST['hash']);

        $rs = $DB->get_row("select * from qingka_wangke_class where cid='$cid' limit 1 ");

        $kms = str_replace(array("\r\n", "\r", "\n"), "[br]", $userinfo);
        $info = explode("[br]", $kms);

        $key = 'AES_Encryptwords';
        $iv = '0123456789abcdef';
        // $hash = openssl_decrypt($hash, 'aes-128-cbc', $key, 0, $iv);
        // if ((empty($_SESSION['addsalt']) || $hash != $_SESSION['addsalt'])) {
        //     exit('{"code":-1,"msg":"验证失败，请刷新页面重试"}');
        // }

        for ($i = 0; $i < count($info); $i++) {
            $str = merge_spaces(trim($info[$i]));
            $userinfo2 = explode(" ", $str); //分
            if (count($userinfo2) > 2) {
                $result = getWk($rs['queryplat'], $rs['getnoun'], trim($userinfo2[0]), trim($userinfo2[1]), trim($userinfo2[2]), $rs['name']);
            } else {
                $result = getWk($rs['queryplat'], $rs['getnoun'], "自动识别", trim($userinfo2[0]), trim($userinfo2[1]), $rs['name']);
            }
            //$result = getWk($rs,$userinfo2);
            
            $userinfo3 = trim($userinfo2[0] . " " . $userinfo2[1] . " " . $userinfo2[2]);
            $result['userinfo'] = $userinfo3;
            wlog($userrow['uid'], "查课", "{$rs['name']}-查课信息：{$userinfo3}", 0);
        }
        exit(json_encode($result));
        break;
        case "batch_change_category":
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    $category_id = trim(strip_tags(daddslashes($_POST['category_id'])));
    $product_ids = array_filter(explode(',', daddslashes($_POST['product_ids'])));

    if (empty($product_ids)) {
        jsonReturn(-1, "请选择需要修改的商品");
    }

    $success_count = 0;
    $error_list = [];

    foreach ($product_ids as $product_id) {
        $product_id = intval($product_id);
        if ($product_id <= 0) {
            $error_list[] = ["product_id" => $product_id, "msg" => "无效的商品ID"];
            continue;
        }

        // 查询商品基础信息
        $class_result = $DB->get_row("SELECT mall_custom FROM qingka_wangke_class WHERE cid = $product_id LIMIT 1");
        if (!$class_result) {
            $error_list[] = ["product_id" => $product_id, "msg" => "商品不存在"];
            continue;
        }

        // 转换为可修改数组
        $mall_custom = json_decode($class_result["mall_custom"], true);

        foreach ($mall_custom as $key => $value) {
            if ($value["uid"] == $uid) {
                $mall_custom[$key]['fenlei'] = $category_id;
                break;
            }
        }

        $mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
        // 执行数据库更新
        $update_sql = "UPDATE qingka_wangke_class 
                       SET mall_custom = '$mall_custom'
                       WHERE cid = $product_id";

        $update_result = $DB->query($update_sql);

        if ($update_result) {
            $success_count++;
        } else {
            $error_list[] = ["product_id" => $product_id, "msg" => "数据库更新失败: " . $DB->last_error()];
        }
    }

    // 返回汇总结果
    jsonReturn(1, [
        'success' => $success_count,
        'total' => count($product_ids),
        'errors' => $error_list
    ]);
    break;
    case 'replace_keywords':
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    $oldKeyword = trim(strip_tags(daddslashes($_POST['oldKeyword'])));
    $newKeyword = trim(strip_tags(daddslashes($_POST['newKeyword'])));

    if (empty($oldKeyword) || empty($newKeyword)) {
        jsonReturn(-1, "被替换词和替换词不能为空");
    }

    // 查询当前用户的所有商品配置
    $class_result = $DB->query("SELECT cid, mall_custom FROM qingka_wangke_class WHERE mall_custom LIKE '%\"uid\":\"$uid\"%'");
    $updated = false;

    while ($row = $DB->fetch($class_result)) {
        $mall_custom = json_decode($row['mall_custom'], true);
        foreach ($mall_custom as $key => $value) {
            if ($value['uid'] == $uid) {
                // 替换商品名称中的被替换词为替换词
                if (strpos($value['name'], $oldKeyword) !== false) {
                    $value['name'] = str_replace($oldKeyword, $newKeyword, $value['name']);
                    $mall_custom[$key] = $value;
                    $updated = true;
                }
            }
        }
        if ($updated) {
            $updated_mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
            $DB->query("UPDATE qingka_wangke_class SET mall_custom='$updated_mall_custom' WHERE cid='{$row['cid']}'");
        }
    }

    if ($updated) {
        jsonReturn(1, '关键词替换成功');
    } else {
        jsonReturn(-1, '未找到需要替换的内容');
    }
    break;
    case "add":
        $type = trim(strip_tags(daddslashes($_POST['type'])));
        $cid = trim(strip_tags(daddslashes($_POST['cid'])));
        
        $uid = trim(strip_tags(daddslashes($_POST['uid'])))?trim(strip_tags(daddslashes($_POST['uid']))):"1";
        
        $data = daddslashes($_POST['data']);
        if(empty($data) || count($data) <= 0){
            exit(json_encode(["code"=>-1,"msg"=>"提交不合法！"]));
        }
        $clientip = real_ip();

        $out_trade_no = date("YmdHis") . rand(111, 999); //生成本地订单号
        
        $money = 0;// 扣除代理的钱 
        $money2 = 0;// 游客支付的钱
        
        $class_result = $DB->get_row("select * from qingka_wangke_class where cid='$cid' limit 1 ");
        $mall_custom = json_decode($class_result["mall_custom"],true);
        
        // 符合uid的商品独立配置
        $mall_custom = array_filter($mall_custom, function($item) use ($touristUID) {
            return $item['uid'] == $touristUID;
        });
        $mall_custom = array_values($mall_custom)[0];
        
        // 价格成本计算
        if ($class_result['yunsuan'] == "*") {
            $price = round($class_result['price'] * $user['addprice'], 2);
        } elseif ($class_result['yunsuan'] == "+") {
            $price = round($class_result['price'] + $user['addprice'], 2);
        } else {
            $price = round($class_result['price'] * $user['addprice'], 2);
        }
        
        // 判定代理余额是否充足
        foreach ($data as $key => $row){
            $money = $money + $price;
            if ($key === end(array_keys($data))) {
                if($user["money"] < $money){
                    exit(json_encode(["code"=>-1,"msg"=>"商家余额不足，无法下单！","need"=>$money]));
                }
            }
        }
        
        $money = 0;
        $this_user = $user;
        $payData = json_decode($this_user["paydata"],true);

        foreach ($data as $key => $row) {

            $userinfo = $row['userinfo'];
            $userName = $row['userName'];
            $userinfo = explode(" ", $userinfo); //分割账号密码
            if (count($userinfo) > 2) {
                $school = $userinfo[0];
                $user = $userinfo[1];
                $pass = $userinfo[2];
            } else {
                $school = "自动识别";
                $user = $userinfo[0];
                $pass = $userinfo[1];
            }

            $kcid = $row['data']['id'];
            $kcname = $row['data']['name'];
            $kcjs = $row['data']['kcjs'];
            
            // 价格成本计算
            if ($class_result['yunsuan'] == "*") {
                $price = round($class_result['price'] * $this_user['addprice'], 2);
            } elseif ($class_result['yunsuan'] == "+") {
                $price = round($class_result['price'] + $this_user['addprice'], 2);
            } else {
                $price = round($class_result['price'] * $this_user['addprice'], 2);
            }

            $money = $money + $price;// 扣除代理的钱 
            $money2 = $money2 + $mall_custom["price"];// 游客支付的钱
            
            $sql = "insert into qingka_wangke_order (type,status,uid,cid,hid,ptname,school,name,user,pass,kcid,kcname,courseEndTime,fees,shoujia,noun,miaoshua,addtime,ip,dockstatus,out_trade_no,payUser) values ('tourist','待支付','{$touristUID}','{$class_result['cid']}','{$class_result['docking']}','{$class_result['name']}','{$school}','$userName','$user','$pass','$kcid','$kcname','{$kcjs}','{$price}','{$mall_custom['price']}','{$class_result['noun']}','$miaoshua','{$date}','$clientip','-9','$out_trade_no','$uid') ";
             if($payData["type"] == 1){
                 $sql = "insert into qingka_wangke_order (type,status,uid,cid,hid,ptname,school,name,user,pass,kcid,kcname,courseEndTime,fees,shoujia,noun,miaoshua,addtime,ip,dockstatus,out_trade_no,payUser) values ('tourist1','待审核','{$touristUID}','{$class_result['cid']}','{$class_result['docking']}','{$class_result['name']}','{$school}','$userName','$user','$pass','$kcid','$kcname','{$kcjs}','{$price}','{$mall_custom['price']}','{$class_result['noun']}','$miaoshua','{$date}','$clientip','-9','$out_trade_no','$uid') ";
             }
            $is = $DB->query($sql); //将对应课程写入数据库
            
        }
        
        
        $name = "游客下单-" . $money2 . "";
        if (!preg_match('/^[0-9.]+$/', $money)) exit('{"code":-1,"msg":"订单金额不合法"}');

        $wz = $_SERVER['HTTP_HOST'];
        
        $sql = "insert into qingka_wangke_pay (type,out_trade_no,uid,num,name,money,money2,ip,addtime,domain,status,payUser) values ('tourist','$out_trade_no','$touristUID','$money','$name','$money2','$money','$clientip','$date','$wz','0','$touristUID') ";
        
        
        if($payData["type"] == 1){
            // 审核模式
            $sql = "insert into qingka_wangke_pay (type,out_trade_no,uid,num,name,money,money2,ip,addtime,domain,status,payUser) values ('tourist1','$out_trade_no','$touristUID','$money','$name','$money2','$money','$clientip','$date','$wz','0','$touristUID') ";
            if($DB->query($sql)){
                exit(json_encode(["code" => 2, "money" => $money]));
            }else{
                exit('{"code":-1,"msg":"生成订单失败！' . $DB->error() . '"}');
            }
        }
        
        if ($DB->query($sql)) {
            exit('{"code":1,"msg":"' . $date . '","out_trade_no":"' . $out_trade_no . '","need":"' . $money2 . '"}');
        } else {
            exit('{"code":-1,"msg":"生成订单失败！' . $DB->error() . '"}');
        }

        exit(json_encode(["code" => 1, "money" => $money]));

        break;
case "t_classlist":
    is_admin();
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    $cx = daddslashes($_POST['cx']);
    $page = trim(strip_tags(daddslashes($_POST['page'])));
    $pagesize = trim(strip_tags($cx['pagesize'])) ? trim(strip_tags($cx['pagesize'])) : 15;
    $pageu = ($page - 1) * $pagesize;

    $name = trim($cx["name"]);
    $status = isset($cx["status"]) ? trim($cx["status"]) : '';
    $fenlei = isset($cx["fenlei"]) ? trim($cx["fenlei"]) : '';

    // 查询站点中的所有商品
    $class_result = $DB->query("select * from qingka_wangke_class where status != 0 order by cid ASC");
    $class_data = [];
    while ($row = $DB->fetch($class_result)) {
        $class_data[] = $row;
    }

    // 遍历所有商品，确保每个商品的 mall_custom 字段中都有当前用户的配置
    foreach ($class_data as $key => $value) {
        $mall_custom = json_decode($value["mall_custom"], true);
        $has_user_config = array_filter($mall_custom, function($item) use ($uid) {
            return $item['uid'] == $uid;
        });

        if (empty($has_user_config)) {
            $default_config = [
                "uid" => $uid,
                "name" => $value["name"],
                "price" => $value["price"],
                "status" => 0,
                "fenlei" => $value["fenlei"],
            ];
            $mall_custom[] = $default_config;

            $updated_mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
            $DB->query("update qingka_wangke_class set mall_custom='$updated_mall_custom' where cid='{$value['cid']}'");
        }
    }

    // 筛选符合用户独立配置状态的商品
    $filtered_data = [];
    foreach ($class_data as $key => $value) {
        $mall_custom = json_decode($value["mall_custom"], true);
        $user_config = array_filter($mall_custom, function($item) use ($uid) {
            return $item['uid'] == $uid;
        });
        $user_config = array_shift($user_config);

        if (!$user_config) {
            $user_config = [
                "uid" => $uid,
                "name" => $value["name"],
                "price" => $value["price"],
                "status" => 0,
                "fenlei" => $value["fenlei"],
            ];
        }

        if ($value['yunsuan'] == "*") {
            $price2 = round($value['price'] * $userrow['addprice'], 2);
        } elseif ($value['yunsuan'] == "+") {
            $price2 = round($value['price'] + $userrow['addprice'], 2);
        } else {
            $price2 = round($value['price'] * $userrow['addprice'], 2);
        }

        if ($status == '' || ($status == '1' && $user_config["status"] == 1) || ($status == '0' && $user_config["status"] == 0)) {
            if ($fenlei == '' || $user_config["fenlei"] == $fenlei) {
                if ($name == '' || stripos($value["name"], $name) !== false) { // 使用 class 表中的 name 字段进行搜索
                    $filtered_data[] = [
                        "cid" => $value["cid"],
                        "name" => $user_config["name"],
                        "name2" => $value["name"],
                        "price2" => $price2,
                        "price" => $user_config["price"],
                        "fenlei" => $user_config["fenlei"],
                        "content" => $value["content"],
                        "status" => $user_config["status"],
                    ];
                }
            }
        }
    }

    // 计算分页总数
    $total_count = count($filtered_data);
    $last_page = ceil($total_count / $pagesize);

    // 分页逻辑
    $filtered_data = array_slice($filtered_data, $pageu, $pagesize);

    // 返回数据
    $data = array(
        'code' => 1,
        'data' => $filtered_data,
        'count' => $total_count,
        "current_page" => (int)$page,
        "last_page" => $last_page,
        "pagesize" => $pagesize
    );
    exit(json_encode($data));
    break;
    case 't_class':
    is_admin();
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    $active = trim(strip_tags(daddslashes(trim($_POST['active']))));
    $cid = trim(strip_tags(daddslashes($_POST['cid'])));
    $data = daddslashes($_POST['data']);

    if (!$userrow['uid']) {
        jsonReturn(-1, "滚！");
    }

    $class_result = $DB->get_row("SELECT mall_custom,status,price,yunsuan FROM qingka_wangke_class WHERE cid = $cid LIMIT 1");
    $mall_custom = json_decode($class_result["mall_custom"], true);

    foreach ($mall_custom as $key => $value) {
        if ($value["uid"] == $touristUID) {
            foreach ($data as $key2 => $value2) {
                if ($key2 == 'status') {
                    if ($class_result["status"] == 0) {
                        jsonReturn(-1, "管理员已下架，禁止修改");
                    }
                }
                if ($key2 == 'price') {
                    // 价格计算
                    if ($value['yunsuan'] == "*") {
                        $price2 = round($class_result['price'] * $userrow['addprice'], 2);
                    } elseif ($value['yunsuan'] == "+") {
                        $price2 = round($class_result['price'] + $userrow['addprice'], 2);
                    } else {
                        $price2 = round($class_result['price'] * $userrow['addprice'], 2);
                    }

                    if ($class_result["price"] < $price2) {
                        exit(json_encode(["cid" => $cid, "msg" => "不可低于成本！"]));
                    }
                }

                $mall_custom[$key][$key2] = $value2;
            }
        }
    }

    $mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
    $result = $DB->query("UPDATE qingka_wangke_class SET mall_custom='$mall_custom' WHERE cid = $cid");

    if ($result) {
        jsonReturn(1, '修改成功');
    } else {
        jsonReturn(-1, '修改失败');
    }
    break;
    case "batch_class_status": // 批量状态/价格更新接口
        is_admin();
        $uid = trim(strip_tags(daddslashes($_POST['uid'])));
        $ids = array_filter(explode(',', daddslashes($_POST['ids']))); // 接收逗号分隔的ID数组
        $status = daddslashes($_POST['status']); // 更新字段数据
        $pricebl = daddslashes($_POST['pricebl'])?daddslashes($_POST['pricebl']):1; // 价格倍率
    
        if (empty($ids)) {
            jsonReturn(-1, "请选择需要操作的商品");
        }
        
        if ($status === 'up') {
            $status = 1;
        }elseif($status === 'down') {
            $status = 0;
        } else {
            $status = null;
        }
        $success_count = 0;
        $error_list = [];
    
        foreach ($ids as $cid_str) {
            $cid = intval($cid_str);
            if ($cid <= 0) {
                $error_list[] = ["cid" => $cid_str, "msg" => "无效的商品ID"];
                continue;
            }
    
            // 查询商品基础信息
            $class_result = $DB->get_row("SELECT mall_custom,status,price,yunsuan FROM qingka_wangke_class WHERE cid = $cid LIMIT 1");
            if (!$class_result) {
                $error_list[] = ["cid" => $cid_str, "msg" => "商品不存在"];
                continue;
            }
    
            // 转换为可修改数组
            $mall_custom = json_decode($class_result["mall_custom"], true);
            $touristUID = $userrow['uid'];
    
            foreach ($mall_custom as $key => $value) {
                if ($value["uid"] == $touristUID) {
                    
    
                    // 状态更新逻辑（保持与单次操作完全一致）
                    if (isset($status)) {
            
                        // 状态冲突检查
                        if ($class_result["status"] == 0) {
                            exit(json_encode(["cid" => $cid_str, "msg" => "管理员已下架，禁止修改"]));
                        } else {
                            $mall_custom[$key]['status'] = $status;
                        }
                        
                    }
                    // 价格更新逻辑（保持与单次操作完全一致）
                    if (isset($pricebl)) {
                        if($pricebl<0){
                            exit(json_encode(["pricebl" => $pricebl, "msg" => "倍率不能小于0！"]));
                        }
                        // 计算成本价
                        $base_price = $class_result["price"];
                        $yunsuan = $class_result["yunsuan"];
                        
                        if ($yunsuan == "*") {
                            $cost_price = round($mall_custom[$key]['price'] * $pricebl, 2);
                            $price2 = round($base_price * $userrow['addprice'], 2);
                        } elseif ($yunsuan == "+") {
                            $cost_price = round(($mall_custom[$key]['price'] + $userrow['addprice']) * $pricebl, 2);
                            $price2 = round($base_price + $userrow['addprice'], 2);
                        } else {
                            $cost_price = round($mall_custom[$key]['price'] * $pricebl, 2);
                            $price2 = round($base_price * $userrow['addprice'], 2);
                        }
                        
                        if ($price2 > $cost_price) {
                            exit(json_encode(["cid" => $cid_str, "msg" => "不得存在售价低于成本"]));
                        } elseif($pricebl=='999') {
                            //恢复原价
                            $mall_custom[$key]['price'] = $base_price;
                        }else {
                            $mall_custom[$key]['price'] = $cost_price;
                        }
                    }
                    
                    $mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
                    // 执行数据库更新
                    $update_sql = "UPDATE qingka_wangke_class 
                        SET mall_custom = '$mall_custom'
                        WHERE cid = $cid";
            
                    $update_result = $DB->query($update_sql);
            
                    if ($update_result) {
                        $success_count++;
                        $update_sql11[$success_count]=$update_sql;
                    } else {
                        $error_list[] = ["cid" => $cid_str, "msg" => "数据库更新失败: " . $DB->last_error()];
                    }
                }
            }
    
        }
    
        // 返回汇总结果
        jsonReturn(1, [
            'success' => $success_count,
            'total' => count($ids),
            //'errors' => $update_sql11
        ]);
        break;
    case "t_fllist":
    is_admin();
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    $cx = daddslashes($_POST['cx']);
    $page = trim(strip_tags(daddslashes($_POST['page'])));
    $pagesize = trim(strip_tags($cx['pagesize'])) ? trim(strip_tags($cx['pagesize'])) : 99999;
    $pageu = ($page - 1) * $pagesize;

    // 查询站点中的所有分类
    $fenlei_result = $DB->query("select * from qingka_wangke_fenlei order by id ASC");
    $fenlei_data = [];
    while ($row = $DB->fetch($fenlei_result)) {
        $fenlei_data[] = $row;
    }

    // 遍历所有分类，确保每个分类的 mall_custom 字段中都有当前用户的配置
    foreach ($fenlei_data as $key => $value) {
        $mall_custom = json_decode($value["mall_custom"], true);
        $has_user_config = array_filter($mall_custom, function($item) use ($uid) {
            return $item['uid'] == $uid;
        });

        if (empty($has_user_config)) {
            // 如果没有当前用户的配置，添加默认配置
            $default_config = [
                "uid" => $uid,
                "name" => $value["name"],
                "status" => 0, // 默认隐藏
            ];
            $mall_custom[] = $default_config;

            // 更新 mall_custom 字段
            $updated_mall_custom = json_encode($mall_custom, JSON_UNESCAPED_UNICODE);
            $DB->query("update qingka_wangke_fenlei set mall_custom='$updated_mall_custom' where id='{$value['id']}'");
        }
    }

    // 筛选符合用户独立配置状态的分类
    $filtered_data = [];
    foreach ($fenlei_data as $key => $value) {
        $mall_custom = json_decode($value["mall_custom"], true);
        $user_config = array_filter($mall_custom, function($item) use ($uid) {
            return $item['uid'] == $uid;
        });
        $user_config = array_shift($user_config);

        if (!$user_config) {
            $user_config = [
                "uid" => $uid,
                "name" => $value["name"],
                "status" => 0,
            ];
        }

        $filtered_data[] = [
            "id" => $value["id"],
            "name" => $user_config["name"],
            "name2" => $value["name"],
            "status" => $user_config["status"],
            "content" => $value["content"],
            "time" => $value["time"],
            "cnum" => $DB->count("select count(*) from qingka_wangke_class where fenlei='{$value['id']}'"),
        ];
    }

    // 计算分页总数
    $total_count = count($filtered_data);
    $last_page = ceil($total_count / $pagesize);

    // 分页逻辑
    $filtered_data = array_slice($filtered_data, $pageu, $pagesize);

    // 返回数据
    $data = array(
        'code' => 1,
        'data' => $filtered_data,
        'count' => $total_count,
        "current_page" => (int)$page,
        "last_page" => $last_page,
        "pagesize" => $pagesize
    );
    exit(json_encode($data));
    break;
    case 't_fl':
        is_admin();
        $uid = trim(strip_tags(daddslashes($_POST['uid'])));
        $active = trim(strip_tags(daddslashes(trim($_POST['active']))));
        $id = trim(strip_tags(daddslashes($_POST['id'])));
        $data = daddslashes($_POST['data']);
        
        if (!$userrow['uid']) {
            jsonReturn(-1, "滚！");
        }
        
        $fenlei_result = $DB->get_row("select mall_custom,status from qingka_wangke_fenlei where id = $id limit 1 ");
        $mall_custom = json_decode($fenlei_result["mall_custom"],true);
            
        foreach ($mall_custom as $key => $value){
            if($value["uid"] == $touristUID){
                foreach ($data as $key2 => $value2){
                    
                    if($key2 == 'status'){
                        if($fenlei_result["status"] == 3){
                            jsonReturn(-1, "管理员已下架，禁止修改");
                        }
                    }
                    
                    $mall_custom[$key][$key2] = $value2;
                    
                }
            }
        }
        
        $mall_custom = json_encode($mall_custom,JSON_UNESCAPED_UNICODE);
        $result = $DB->query("update qingka_wangke_fenlei set mall_custom='$mall_custom' where id = $id ");
        if($result){
            jsonReturn(1, '修改成功');
        }else{
            jsonReturn(-1, '修改失败');
        }

        // 获取用户数据
        $user = $DB->get_row("SELECT fldata FROM qingka_wangke_user WHERE uid='{$uid}' LIMIT 1");
        // 将用户数据中的 fldata 转换为数组
        
        $user_fldata= json_decode_fn($user["fldata"]);
        
        $index= null;
        foreach ($user_fldata as $key => $item) {
            if ((string)$item['id'] === (string)$id) {
                $index = $key;
                break;
            }
        }
        
        
            // exit(json_encode($user_fldata));
        if ($index !== false) {
            // 更新$data中与$user_fldata[$index]相同键的值
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $user_fldata[$index])) {
                    $user_fldata[$index][$key] = $value;
                }
            }
            // 更新数据库中的fldata字段
            $updated_fldata = json_encode($user_fldata, JSON_UNESCAPED_UNICODE);
            $DB->query("UPDATE qingka_wangke_user SET fldata='{$updated_fldata}' WHERE uid='{$uid}'");
            
             // 获取用户数据
        $user = $DB->get_row("SELECT fldata FROM qingka_wangke_user WHERE uid='{$uid}' LIMIT 1");
        // 将用户数据中的 fldata 转换为数组
        
            
            jsonReturn(1, '修改成功');
        } else {
            jsonReturn(-1, '修改失败');
        }
        break;
    case "payConfig":
        is_admin();
        $uid = trim(strip_tags(daddslashes($_POST['uid'])));
        $user = $DB->get_row("select paydata from qingka_wangke_user where uid ='$uid' limit 1 ");
        if($user){
            $payData =preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', trim($user["paydata"]));
            $payData =json_decode($payData,true);
            // 若不为数组或数组长度为0，则初始化
            if(!is_array($payData) || count($payData)<=0){
                $payData = [
                    "type"=>"0",
                    "epay_api"=> "",// 易支付API
                    "epay_pid"=> "",// 商户ID
                    "epay_key"=> "",// 商户KEY
                    "is_alipay"=>"1",
                    "is_wxpay"=>"0",
                    "is_qqpay"=>"0",
                ];
                $updated_paydata = json_encode($payData, JSON_UNESCAPED_UNICODE);
                $DB->query("UPDATE qingka_wangke_user SET paydata='{$updated_paydata}' WHERE uid='{$uid}'");
                exit(json_encode(["code"=>1,"msg"=>"成功","data"=>$payData]));
            }
            exit(json_encode(["code"=>1,"msg"=>"成功2","data"=>$payData]));
        }else{
            jsonReturn(-1,"代理不存在");
        }
        
        break;
    case "payConfig_up":
        $uid = trim(strip_tags(daddslashes($_POST['uid'])));
        $data = daddslashes($_POST['data']);

        if (!$userrow['uid']) {
            jsonReturn(-1, "滚！");
        }

        // 获取用户数据
        $user = $DB->get_row("SELECT * FROM qingka_wangke_user WHERE uid='{$uid}' LIMIT 1");
        // 将用户数据中的 paydata 转换为数组
        $user_paydata = preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', trim($user["paydata"]));
        $user_paydata = json_decode($user_paydata, true);
        if (true) {
            // 更新$data中与$user_paydata[$index]相同键的值
            foreach ($data as $key => $value) {
                $user_paydata[$key] = $value;
            }
            // 更新数据库中的 paydata 字段
            $updated_paydata = json_encode($user_paydata, JSON_UNESCAPED_UNICODE);
            $DB->query("UPDATE qingka_wangke_user SET paydata='{$updated_paydata}' WHERE uid='{$uid}'");
            jsonReturn(1, '修改成功');
        } else { 
            jsonReturn(-1, '修改失败');
        }
        break;
    case "t_orderlist":
        is_admin();
        
        $cx = daddslashes($_POST['cx']);
        $page = trim(strip_tags(daddslashes($_POST['page'])));
        $pagesize = trim(strip_tags($cx['pagesize']))?trim(strip_tags($cx['pagesize'])):15;
        $pageu = ($page - 1) * $pagesize; //当前界面		
        
        $qq = trim(strip_tags($cx['qq']));
        $status_text = trim(strip_tags($cx['status_text']));
        $dock = trim(strip_tags($cx['dock']));
        $cid = trim(strip_tags($cx['cid']));
        $oid = trim(strip_tags($cx['oid']));
        $uid = trim(strip_tags($cx['uid']));
        $kcname = trim(strip_tags($cx['kcname']));
        $ptname = trim(strip_tags($cx['ptname']));
        $school = trim(strip_tags($cx['school']));
        $type = trim(strip_tags($cx['type']));
        
        if ($userrow['uid'] != '1') {
            $sql1 = "where uid='{$userrow['uid']}'";
        } else  {
            $sql1 = "where uid=1";
        }
        if ($kcname != '') {
            $sql2 = " and kcname like '%" . $kcname . "%' ";
        }
        if ($cid != '') {
            $sql3 = " and cid='{$cid}'";
        }
        if ($qq != '') {
            $sql4 = " and user='{$qq}'";
        }
        if ($oid != '') {
            $sql5 = " and oid='{$oid}'";
        }
        if ($uid != '') {
            $sql6 = " and uid='{$uid}'";
        }
        if ($status_text != '') {
            $sql7 = " and status like '%" . $status_text . "%' ";
        }
        if ($dock != '') {
            $sql8 = " and dockstatus='{$dock}'";
        }
        if ($school != '') {
            $sql9 = " and school like '%" . $school . "%' ";
        }
        if ($ptname != '') {
            $ptnameA = $DB->query("select cid from qingka_wangke_class where name like '%" . $ptname . "%'");
            while ($row = $DB->fetch($ptnameA)) {
                $ptnameB = $row['cid'] . ',' . $ptnameB;
            }
            $ptnameB = rtrim($ptnameB, ',');
            $sql3 = " and cid in ({$ptnameB})";
        }
        if($type != ''){
            $sql10 = " and type='{$type}' and status='待审核' ";
        }
        $sql = $sql1 . $sql2 . $sql3 . $sql4 . $sql5 . $sql6 . $sql7 . $sql8 . $sql9 . $sql10 . "  and (type='tourist' or type='tourist1') ";
       
        $a = $DB->query("select * from qingka_wangke_order {$sql} and out_trade_no IS NOT NULL order by oid desc limit $pageu,$pagesize ");
        
        $count1 = $DB->count("select count(*) from qingka_wangke_order {$sql} and out_trade_no IS NOT NULL ");
        $data = [];
        while ($row = $DB->fetch($a)) {
            if ($row['name'] == '' || $row['name'] == 'undefined') {
                $row['name'] = 'null';
            }
            $data[] = $row;
        }
        
        // $data2 = [];
        // foreach($data as $key => $value){
        //     $shoujia = $DB->get_row("select money from qingka_wangke_pay where out_trade_no='{$value['out_trade_no']}' limit 1 ");
        //     $value["shoujia"] = $shoujia;
        //     $data2[$key] = $value;
        // }
        
        $last_page = ceil($count1 / $pagesize); //取最大页数
        $data = array('a' => $sql, 'code' => 1, 'data' => $data, "current_page" => (int)$page, "last_page" => $last_page, "uid" => (int)$userrow['uid'], 'count' => $count1, "pagesize" => $pagesize);
        exit(json_encode($data));
        break;
    case "touristData":
        is_admin();
        if(!is_array(json_decode($user["touristdata"],true))){
            $touristdata = [
                "sitename" => ($touristUID ==1 ? $conf["sitename"] : $user["name"]) . '的铺子',
                "notice" => '',
                "qqkefu" => !empty($user["qq"]) ? $user["qq"] :$user["user"],
            ];
            $touristdata2= json_encode($touristdata,JSON_UNESCAPED_UNICODE);
            $DB->query("update qingka_wangke_user set touristdata='{$touristdata2}' where uid='$touristUID' ");
        }
        
        $touristdata_result = $DB->get_row("select touristdata from qingka_wangke_user where uid='$touristUID' limit 1 ");
        $touristdata = json_decode($touristdata_result["touristdata"],true);
        
        $type = trim($_POST["type"]);
        if($type=="save"){
            // 修改数据
            $data = daddslashes($_POST["data"]);
            foreach ($data as $key => $value){
                if(array_key_exists($key, $touristdata)){
                    $touristdata[$key] = $value;
                    continue;
                }
            }
            $touristdata = json_encode($touristdata,JSON_UNESCAPED_UNICODE);
            $result = $DB->query("update qingka_wangke_user set touristdata='{$touristdata}' where uid='$touristUID' ");
            if($result){
                exit(json_encode(["code"=>1,"data"=>json_decode($touristdata,true)]));
            }else{
                exit(json_encode(["code"=>-1,"data"=>[] ]));
            }
        }else{
            if($touristdata_result){
                exit(json_encode(["code"=>1,"data"=>$touristdata]));
            }else{
                exit(json_encode(["code"=>-1,"data"=>[] ]));
            }
        }
        
        break;
        // 审核订单
    case "shenhe_piliang":
        $sex = daddslashes($_POST['sex']);
        $type = daddslashes($_POST['type']);
        if(empty($type)){
            $money = 0;
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $order = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' limit 1 ");
                $DB->query("update qingka_wangke_order set status='待处理' , dockstatus='0' where oid='{$oid}' ");
                $DB->query("update qingka_wangke_user set money=money-'{$order['fees']}' where uid='{$touristUID}' ");
                $money = $money + $order['fees'];
                wlog($touristUID, "审核订单", "商城订单 -> ID:".$oid." -> 审核通过 | 扣除成本：".$order['fees'], -$order['fees']);
                
            }
            exit(json_encode(["code"=>1,"money"=>$money]));
        }else{
            // 取消打回
            for ($i = 0; $i < count($sex); $i++) {
                $oid = $sex[$i];
                $order = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' limit 1 ");
                $DB->query("update qingka_wangke_order set status='已取消' , dockstatus='4' where oid='{$oid}' ");
                wlog($touristUID, "审核订单", "商城订单 -> ID:".$oid." -> 打回取消", 0);
                
            }
            exit(json_encode(["code"=>1,"money"=>0]));
        }
        break;
}