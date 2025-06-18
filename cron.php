<?php
include('confing/common.php');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
if($act=='cookie'){
    qcookie();
}elseif($act=='add'){//执行对接     
	$a=$DB->query("select * from qingka_wangke_order where dockstatus='0' and status!='已取消' ");
	while($b=$DB->fetch($a)){
		if($b['user']=="1"){
			 $DB->query("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}elseif($b['school']==""){
			 $DB->query("update qingka_wangke_order set `status`='请检查学校名字',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}elseif($b['user']==""){
			 $DB->query("update qingka_wangke_order set `status`='请检查账号',`dockstatus`=2 where oid='{$b['oid']}' ");//对接成功       
		}else{
	 	     $result=addWk($b['oid']);
	    }
		$d=$DB->get_row("select * from qingka_wangke_class where cid='{$b['cid']}' ");   	 	           
	  	if($result['code']=='1'){
       	    echo 'ok';
       	    $DB->query("update qingka_wangke_order set `hid`='{$d['docking']}',`status`='进行中',`dockstatus`=1,`yid`='{$result['yid']}' where oid='{$b['oid']}' ");//对接成功
        }else{
        	$DB->query("update qingka_wangke_order set `dockstatus`=2 where oid='{$b['oid']}' ");
        }
	}
		
}elseif($act=='add2'){//执行对接2号
	$b=$DB->get_row("select * from qingka_wangke_order where dockstatus='2' and status!='已取消' limit 1 ");
	$result=addWk($b['oid']);
	    $d=$DB->get_row("select * from qingka_wangke_class where cid='{$b['cid']}' ");   	 
	  	if($result['code']=='1'){
       	    echo 'ok';
       	    $DB->query("update qingka_wangke_order set `hid`='{$d['docking']}',`status`='进行中',`dockstatus`=1,`yid`='{$result['yid']}' where oid='{$b['oid']}' ");//对接成功
        }else{
        	echo 'no';
        	$DB->query("update qingka_wangke_order set `dockstatus`=2 where oid='{$b['oid']}' ");
        }
	
}elseif($act=='ziying'){//自营订单处理
	$b=$DB->get_row("select * from qingka_wangke_order where dockstatus='99' and status='待处理' limit 1 ");
	$result=addWk($oid);  	 
	  	if($result['code']=='1'){
       	    echo 'ok';
       	    $DB->query("update qingka_wangke_order set `hid`='0',`status`='进行中' where oid='{$b['oid']}' ");//对接成功
        }else{
        	echo 'no';
        }
	
}elseif($act=='update'){//同步进行中	
	$a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status='进行中'  order by oid desc");//所有非已完成订单
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
           $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update2'){//同步补刷中		
	$a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status='补刷中' order by oid desc");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
            $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update3'){//获取源ID		
	$a=$DB->query("select * from qingka_wangke_order where oid>'30000' and dockstatus='1' and yid='' order by oid desc ");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
            $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update4'){//同步进行中		
	$a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status='进行中' ");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
           $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='update5'){//同步待处理	
	$a=$DB->query("select * from qingka_wangke_order where dockstatus='1' and status='待处理' order by oid desc");
	while($b=$DB->fetch($a)){     
       $result=processCx($b['oid']);
       for($i=0;$i<count($result);$i++){
            $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
       }
       echo "ok</br>";
	}
}elseif($act=='monitor_update'){//监控所有非已完成订单
    // 监控所有非已完成订单
    header('Content-Type: text/html; charset=utf-8');
    
    // 分页参数
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    if($page < 1) $page = 1;
    if($limit < 1 || $limit > 50) $limit = 10;
    
    // 计算分页
    $offset = ($page - 1) * $limit;
    
    // 获取订单总数
    $total_query = $DB->query("SELECT COUNT(oid) as total FROM qingka_wangke_order WHERE status!='已完成' AND status!='已取消'");
    $total_row = $DB->fetch($total_query);
    $total_orders = $total_row['total'];
    $total_pages = ceil($total_orders / $limit);
    
    // 输出HTML页面
    echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>订单监控系统 - 异步处理</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header { margin-bottom: 20px; }
        .progress-bar { 
            width: 100%; 
            background-color: #f3f3f3; 
            border-radius: 5px; 
            margin-bottom: 10px;
        }
        .progress-bar-inner { 
            height: 24px; 
            background-color: #4CAF50; 
            border-radius: 5px; 
            text-align: center;
            color: white;
            line-height: 24px;
        }
        .order-list { margin-top: 20px; }
        .order-item { 
            padding: 10px; 
            border: 1px solid #ddd; 
            margin-bottom: 10px; 
            border-radius: 5px;
        }
        .order-item.processing { background-color: #fffde7; }
        .order-item.success { background-color: #e8f5e9; }
        .order-item.failed { background-color: #ffebee; }
        .pagination { margin-top: 20px; }
        .pagination a { 
            display: inline-block; 
            padding: 5px 10px; 
            margin-right: 5px; 
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            margin-left: 5px;
        }
        .status-waiting { background-color: #e0e0e0; }
        .status-processing { background-color: #ffecb3; }
        .status-success { background-color: #c8e6c9; }
        .status-failed { background-color: #ffcdd2; }
        .control-panel {
            margin: 15px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        button {
            padding: 8px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
        }
        .primary-btn { background-color: #2196F3; color: white; }
        .success-btn { background-color: #4CAF50; color: white; }
        .danger-btn { background-color: #F44336; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>订单监控系统 - 异步处理</h1>
            <p>总共 <span id="total-orders">'.$total_orders.'</span> 个未完成订单，共 '.$total_pages.' 页，当前第 '.$page.' 页</p>
            <p>每页 '.$limit.' 个订单</p>
        </div>
        
        <div class="control-panel">
            <button id="start-btn" class="primary-btn">开始处理</button>
            <button id="pause-btn" class="danger-btn" disabled>暂停</button>
            <button id="resume-btn" class="success-btn" disabled>继续</button>
            <span id="status-text">准备就绪</span>
        </div>
        
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-bar-inner" id="progress-bar" style="width: 0%">0%</div>
            </div>
            <p>已处理: <span id="processed-count">0</span>/<span id="total-count">0</span> | 成功: <span id="success-count">0</span> | 失败: <span id="fail-count">0</span></p>
        </div>
        
        <div class="order-list" id="order-list">
            <!-- 订单列表将通过AJAX加载 -->
            <p>正在加载订单列表...</p>
        </div>
        
        <div class="pagination">';
    
    if($page > 1) {
        echo '<a href="cron.php?act=monitor_update&page='.($page-1).'&limit='.$limit.'">上一页</a>';
    }
    if($page < $total_pages) {
        echo '<a href="cron.php?act=monitor_update&page='.($page+1).'&limit='.$limit.'">下一页</a>';
    }
    
    echo '</div>
    </div>
    
    <script>
        // 订单处理相关变量
        let orderList = [];
        let isProcessing = false;
        let isPaused = false;
        let currentIndex = 0;
        let successCount = 0;
        let failCount = 0;
        
        // 页面加载完成后获取订单列表
        document.addEventListener("DOMContentLoaded", function() {
            fetchOrderList();
            
            // 绑定按钮事件
            document.getElementById("start-btn").addEventListener("click", startProcessing);
            document.getElementById("pause-btn").addEventListener("click", pauseProcessing);
            document.getElementById("resume-btn").addEventListener("click", resumeProcessing);
        });
        
        // 获取订单列表
        function fetchOrderList() {
            fetch("cron.php?act=get_order_list&page='.$page.'&limit='.$limit.'")
                .then(response => response.json())
                .then(data => {
                    orderList = data.orders;
                    document.getElementById("total-count").textContent = orderList.length;
                    renderOrderList();
                })
                .catch(error => {
                    console.error("获取订单列表失败:", error);
                    document.getElementById("order-list").innerHTML = "<p>获取订单列表失败，请刷新页面重试</p>";
                });
        }
        
        // 渲染订单列表
        function renderOrderList() {
            const orderListElement = document.getElementById("order-list");
            orderListElement.innerHTML = "";
            
            if(orderList.length === 0) {
                orderListElement.innerHTML = "<p>没有待处理的订单</p>";
                return;
            }
            
            orderList.forEach((order, index) => {
                const orderElement = document.createElement("div");
                orderElement.className = "order-item";
                orderElement.id = "order-" + order.oid;
                
                const statusBadge = document.createElement("span");
                statusBadge.className = "status-badge status-waiting";
                statusBadge.textContent = "等待处理";
                
                orderElement.innerHTML = `
                    <div>
                        <strong>订单 #${order.oid}</strong> 
                        <span class="status-badge status-waiting">等待处理</span>
                    </div>
                    <div>学校: ${order.school} | 账号: ${order.user} | 课程: ${order.kcname}</div>
                    <div>当前状态: ${order.status} | 提交时间: ${order.addtime}</div>
                    <div class="result" id="result-${order.oid}"></div>
                `;
                
                orderListElement.appendChild(orderElement);
            });
        }
        
        // 开始处理
        function startProcessing() {
            if(isProcessing || orderList.length === 0) return;
            
            isProcessing = true;
            isPaused = false;
            currentIndex = 0;
            successCount = 0;
            failCount = 0;
            
            document.getElementById("start-btn").disabled = true;
            document.getElementById("pause-btn").disabled = false;
            document.getElementById("resume-btn").disabled = true;
            document.getElementById("status-text").textContent = "正在处理...";
            
            // 重置所有订单状态
            orderList.forEach((order, index) => {
                const orderElement = document.getElementById("order-" + order.oid);
                orderElement.className = "order-item";
                const statusBadge = orderElement.querySelector(".status-badge");
                statusBadge.className = "status-badge status-waiting";
                statusBadge.textContent = "等待处理";
                document.getElementById("result-" + order.oid).innerHTML = "";
            });
            
            // 更新统计信息
            updateStats();
            
            // 开始处理第一个订单
            processNextOrder();
        }
        
        // 暂停处理
        function pauseProcessing() {
            isPaused = true;
            document.getElementById("pause-btn").disabled = true;
            document.getElementById("resume-btn").disabled = false;
            document.getElementById("status-text").textContent = "已暂停";
        }
        
        // 继续处理
        function resumeProcessing() {
            isPaused = false;
            document.getElementById("pause-btn").disabled = false;
            document.getElementById("resume-btn").disabled = true;
            document.getElementById("status-text").textContent = "正在处理...";
            
            // 继续处理下一个订单
            processNextOrder();
        }
        
        // 处理下一个订单
        function processNextOrder() {
            if(!isProcessing || isPaused || currentIndex >= orderList.length) {
                if(currentIndex >= orderList.length) {
                    finishProcessing();
                }
                return;
            }
            
            const order = orderList[currentIndex];
            const orderElement = document.getElementById("order-" + order.oid);
            const statusBadge = orderElement.querySelector(".status-badge");
            
            // 更新订单状态为进行中
            orderElement.className = "order-item processing";
            statusBadge.className = "status-badge status-processing";
            statusBadge.textContent = "进行中";
            
            // 调用API处理订单
            fetch("cron.php?act=process_single_order&oid=" + order.oid)
                .then(response => response.json())
                .then(data => {
                    // 更新处理结果
                    const resultElement = document.getElementById("result-" + order.oid);
                    
                    if(data.success) {
                        // 处理成功
                        orderElement.className = "order-item success";
                        statusBadge.className = "status-badge status-success";
                        statusBadge.textContent = "成功";
                        
                        resultElement.innerHTML = `
                            <div style="margin-top: 5px; color: green;">
                                状态: ${data.original_status} -> ${data.new_status}<br>
                                进度: ${data.process || "N/A"}<br>
                                ${data.remarks ? "备注: " + data.remarks : ""}
                            </div>
                        `;
                        
                        successCount++;
        } else {
                        // 处理失败
                        orderElement.className = "order-item failed";
                        statusBadge.className = "status-badge status-failed";
                        statusBadge.textContent = "失败";
                        
                        resultElement.innerHTML = `
                            <div style="margin-top: 5px; color: red;">
                                失败原因: ${data.error || "未知错误"}
                            </div>
                        `;
                        
                        failCount++;
                    }
                    
                    // 更新进度和统计信息
                    currentIndex++;
                    updateStats();
                    
                    // 处理下一个订单（添加小延迟避免服务器过载）
                    setTimeout(processNextOrder, 300);
                })
                .catch(error => {
                    console.error("处理订单失败:", error);
                    
                    // 更新失败状态
                    orderElement.className = "order-item failed";
                    statusBadge.className = "status-badge status-failed";
                    statusBadge.textContent = "失败";
                    
                    document.getElementById("result-" + order.oid).innerHTML = `
                        <div style="margin-top: 5px; color: red;">
                            失败原因: 网络错误或服务器异常
                        </div>
                    `;
                    
                    failCount++;
                    currentIndex++;
                    updateStats();
                    
                    // 继续处理下一个
                    setTimeout(processNextOrder, 300);
                });
        }
        
        // 完成所有处理
        function finishProcessing() {
            isProcessing = false;
            document.getElementById("start-btn").disabled = false;
            document.getElementById("pause-btn").disabled = true;
            document.getElementById("resume-btn").disabled = true;
            document.getElementById("status-text").textContent = "处理完成";
        }
        
        // 更新统计信息
        function updateStats() {
            const processed = currentIndex;
            const total = orderList.length;
            const percent = total > 0 ? Math.round((processed / total) * 100) : 0;
            
            document.getElementById("processed-count").textContent = processed;
            document.getElementById("success-count").textContent = successCount;
            document.getElementById("fail-count").textContent = failCount;
            
            const progressBar = document.getElementById("progress-bar");
            progressBar.style.width = percent + "%";
            progressBar.textContent = percent + "%";
        }
    </script>
</body>
</html>';
}elseif($act=='get_order_list'){//获取待处理订单列表API
    // 设置返回JSON格式
    header('Content-Type: application/json');
    
    // 分页参数
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    if($page < 1) $page = 1;
    if($limit < 1 || $limit > 50) $limit = 10;
    
    // 计算分页
    $offset = ($page - 1) * $limit;
    
    // 获取订单
    $orders_query = $DB->query("SELECT oid, uid, user, pass, school, kcname, status, hid, dockstatus, addtime FROM qingka_wangke_order WHERE status!='已完成' AND status!='已取消' ORDER BY oid ASC LIMIT {$offset}, {$limit}");
    
    $orders = array();
    while($row = $DB->fetch($orders_query)) {
        $orders[] = $row;
    }
    
    // 返回JSON
    echo json_encode(array(
        'success' => true,
        'page' => $page,
        'limit' => $limit,
        'orders' => $orders
    ));
}elseif($act=='process_single_order'){//处理单个订单API
    // 设置返回JSON格式
    header('Content-Type: application/json');
    
    // 获取订单ID
    $oid = isset($_GET['oid']) ? intval($_GET['oid']) : 0;
    if($oid <= 0) {
        echo json_encode(array(
            'success' => false,
            'error' => '无效的订单ID'
        ));
        exit;
    }
    
    // 获取订单信息
    $order = $DB->get_row("SELECT * FROM qingka_wangke_order WHERE oid='{$oid}'");
    if(!$order) {
        echo json_encode(array(
            'success' => false,
            'error' => '订单不存在'
        ));
        exit;
    }
    
    $original_status = $order['status'];
    
    // 处理特殊情况
    if($order['hid'] == 'ximeng') {
        echo json_encode(array(
            'success' => false,
            'error' => '接口异常',
            'original_status' => $original_status
        ));
        exit;
    }
    
    if($order['dockstatus'] == '99') {
        echo json_encode(array(
            'success' => true,
            'message' => '实时进度无需更新',
            'original_status' => $original_status,
            'new_status' => $original_status
        ));
        exit;
    }
    
        // 更新订单
        $result = processCx($oid);
        if(is_array($result) && count($result) > 0) {
            for($i=0; $i<count($result); $i++) {
                $DB->query("UPDATE qingka_wangke_order SET 
                    `name`='{$result[$i]['name']}',
                    `yid`='{$result[$i]['yid']}',
                    `status`='{$result[$i]['status_text']}',
                    `courseStartTime`='{$result[$i]['kcks']}',
                    `courseEndTime`='{$result[$i]['kcjs']}',
                    `examStartTime`='{$result[$i]['ksks']}',
                    `examEndTime`='{$result[$i]['ksjs']}',
                    `process`='{$result[$i]['process']}',
                    `remarks`='{$result[$i]['remarks']}' 
                    WHERE `user`='{$result[$i]['user']}' AND `kcname`='{$result[$i]['kcname']}' AND `oid`='{$oid}'");
            }
            
        // 获取更新后的状态
            $updated_order = $DB->get_row("SELECT * FROM qingka_wangke_order WHERE oid='{$oid}'");
            
        echo json_encode(array(
            'success' => true,
            'original_status' => $original_status,
            'new_status' => $updated_order['status'],
            'process' => $updated_order['process'],
            'remarks' => $updated_order['remarks']
        ));
        } else {
        echo json_encode(array(
            'success' => false,
            'error' => '更新失败',
            'original_status' => $original_status
        ));
    }
}elseif($act=='monitor_uid'){//根据指定用户UID监控订单
// ... existing code ...
}elseif($act=='auto_monitor'){//自动监控API，可被定时任务调用
    // 设置内容类型为JSON
    header('Content-Type: application/json');
    
    // 防止超时
    set_time_limit(300); // 设置最大执行时间为5分钟
    
    // 获取参数
    $batch_size = isset($_GET['batch_size']) ? intval($_GET['batch_size']) : 20; // 每批处理数量
    $batch_num = isset($_GET['batch_num']) ? intval($_GET['batch_num']) : 1;    // 批次编号
    $status_filter = isset($_GET['status']) ? daddslashes($_GET['status']) : ''; // 状态过滤
    
    // 验证参数
    if($batch_size < 1 || $batch_size > 100) $batch_size = 20;
    if($batch_num < 1) $batch_num = 1;
    
    // 计算偏移量
    $offset = ($batch_num - 1) * $batch_size;
    
    // 构建查询条件
    $where_clause = "status!='已完成' AND status!='已取消'";
    if(!empty($status_filter)) {
        $where_clause .= " AND status='$status_filter'";
    }
    
    // 获取总订单数
    $total_query = $DB->query("SELECT COUNT(oid) as total FROM qingka_wangke_order WHERE $where_clause");
    $total_row = $DB->fetch($total_query);
    $total_orders = $total_row['total'];
    $total_batches = ceil($total_orders / $batch_size);
    
    // 如果请求的批次超出范围，返回错误
    if($batch_num > $total_batches && $total_batches > 0) {
        echo json_encode([
            'success' => false,
            'error' => '批次编号超出范围',
            'total_orders' => $total_orders,
            'total_batches' => $total_batches
        ]);
        exit;
    }
    
    // 获取当前批次的订单
    $orders_query = $DB->query("SELECT oid FROM qingka_wangke_order WHERE $where_clause ORDER BY oid ASC LIMIT $offset, $batch_size");
    
    $results = [];
    $success_count = 0;
    $fail_count = 0;
    
    // 处理每个订单
    while($row = $DB->fetch($orders_query)) {
        $oid = $row['oid'];
        
        // 获取订单详细信息
        $order = $DB->get_row("SELECT * FROM qingka_wangke_order WHERE oid='$oid'");
        $original_status = $order['status'];
        
        $order_result = [
            'oid' => $oid,
            'original_status' => $original_status,
            'success' => false
        ];
        
        // 处理特殊情况
        if($order['hid'] == 'ximeng') {
            $order_result['error'] = '接口异常';
            $results[] = $order_result;
            $fail_count++;
            continue;
        }
        
        if($order['dockstatus'] == '99') {
            $order_result['success'] = true;
            $order_result['message'] = '实时进度无需更新';
            $order_result['new_status'] = $original_status;
            $results[] = $order_result;
            $success_count++;
            continue;
        }
        
        // 更新订单
        $result = processCx($oid);
        if(is_array($result) && count($result) > 0) {
            for($i=0; $i<count($result); $i++) {
                $DB->query("UPDATE qingka_wangke_order SET 
                    `name`='{$result[$i]['name']}',
                    `yid`='{$result[$i]['yid']}',
                    `status`='{$result[$i]['status_text']}',
                    `courseStartTime`='{$result[$i]['kcks']}',
                    `courseEndTime`='{$result[$i]['kcjs']}',
                    `examStartTime`='{$result[$i]['ksks']}',
                    `examEndTime`='{$result[$i]['ksjs']}',
                    `process`='{$result[$i]['process']}',
                    `remarks`='{$result[$i]['remarks']}' 
                    WHERE `user`='{$result[$i]['user']}' AND `kcname`='{$result[$i]['kcname']}' AND `oid`='{$oid}'");
            }
            
            // 获取更新后的状态
            $updated_order = $DB->get_row("SELECT status, process, remarks FROM qingka_wangke_order WHERE oid='$oid'");
            
            $order_result['success'] = true;
            $order_result['new_status'] = $updated_order['status'];
            $order_result['process'] = $updated_order['process'];
            $order_result['remarks'] = $updated_order['remarks'];
            
            $results[] = $order_result;
            $success_count++;
        } else {
            $order_result['error'] = '更新失败';
            $results[] = $order_result;
            $fail_count++;
        }
        
        // 小延迟，避免服务器过载
        usleep(200000); // 延迟0.2秒
    }
    
    // 返回结果
    echo json_encode([
        'success' => true,
        'batch' => $batch_num,
        'total_batches' => $total_batches,
        'batch_size' => $batch_size,
        'total_orders' => $total_orders,
        'processed' => count($results),
        'success_count' => $success_count,
        'fail_count' => $fail_count,
        'next_batch' => ($batch_num < $total_batches) ? $batch_num + 1 : null,
        'results' => $results
    ]);
}elseif($act=='auto_monitor_all'){//自动监控所有批次，无需手动循环
    // 设置内容类型为JSON
    header('Content-Type: application/json');
    
    // 防止超时
    set_time_limit(600); // 设置最大执行时间为10分钟
    
    // 获取参数
    $batch_size = isset($_GET['batch_size']) ? intval($_GET['batch_size']) : 10; // 每批处理数量
    $max_batches = isset($_GET['max_batches']) ? intval($_GET['max_batches']) : 10; // 最大批次数量
    $status_filter = isset($_GET['status']) ? daddslashes($_GET['status']) : ''; // 状态过滤
    
    // 验证参数
    if($batch_size < 1 || $batch_size > 50) $batch_size = 10;
    if($max_batches < 1) $max_batches = 10;
    if($max_batches > 50) $max_batches = 50; // 限制最大批次，避免过载
    
    // 构建查询条件
    $where_clause = "status!='已完成' AND status!='已取消'";
    if(!empty($status_filter)) {
        $where_clause .= " AND status='$status_filter'";
    }
    
    // 获取总订单数
    $total_query = $DB->query("SELECT COUNT(oid) as total FROM qingka_wangke_order WHERE $where_clause");
    $total_row = $DB->fetch($total_query);
    $total_orders = $total_row['total'];
    $total_batches = ceil($total_orders / $batch_size);
    
    // 如果批次数量超过最大值，限制批次数量
    $batches_to_process = min($total_batches, $max_batches);
    
    $all_results = [];
    $total_success = 0;
    $total_fail = 0;
    
    // 处理每个批次
    for($batch_num = 1; $batch_num <= $batches_to_process; $batch_num++) {
        // 计算偏移量
        $offset = ($batch_num - 1) * $batch_size;
        
        // 获取当前批次的订单
        $orders_query = $DB->query("SELECT oid FROM qingka_wangke_order WHERE $where_clause ORDER BY oid ASC LIMIT $offset, $batch_size");
        
        $batch_results = [];
        $batch_success = 0;
        $batch_fail = 0;
        
        // 处理每个订单
        while($row = $DB->fetch($orders_query)) {
            $oid = $row['oid'];
            
            // 获取订单详细信息
            $order = $DB->get_row("SELECT * FROM qingka_wangke_order WHERE oid='$oid'");
            $original_status = $order['status'];
            
            $order_result = [
                'oid' => $oid,
                'original_status' => $original_status,
                'success' => false
            ];
            
            // 处理特殊情况
            if($order['hid'] == 'ximeng') {
                $order_result['error'] = '接口异常';
                $batch_results[] = $order_result;
                $batch_fail++;
                continue;
            }
            
            if($order['dockstatus'] == '99') {
                $order_result['success'] = true;
                $order_result['message'] = '实时进度无需更新';
                $order_result['new_status'] = $original_status;
                $batch_results[] = $order_result;
                $batch_success++;
                continue;
            }
            
            // 更新订单
            $result = processCx($oid);
            if(is_array($result) && count($result) > 0) {
                for($i=0; $i<count($result); $i++) {
                    $DB->query("UPDATE qingka_wangke_order SET 
                        `name`='{$result[$i]['name']}',
                        `yid`='{$result[$i]['yid']}',
                        `status`='{$result[$i]['status_text']}',
                        `courseStartTime`='{$result[$i]['kcks']}',
                        `courseEndTime`='{$result[$i]['kcjs']}',
                        `examStartTime`='{$result[$i]['ksks']}',
                        `examEndTime`='{$result[$i]['ksjs']}',
                        `process`='{$result[$i]['process']}',
                        `remarks`='{$result[$i]['remarks']}' 
                        WHERE `user`='{$result[$i]['user']}' AND `kcname`='{$result[$i]['kcname']}' AND `oid`='{$oid}'");
                }
                
                // 获取更新后的状态
                $updated_order = $DB->get_row("SELECT status, process, remarks FROM qingka_wangke_order WHERE oid='$oid'");
                
                $order_result['success'] = true;
                $order_result['new_status'] = $updated_order['status'];
                $order_result['process'] = $updated_order['process'];
                $order_result['remarks'] = $updated_order['remarks'];
                
                $batch_results[] = $order_result;
                $batch_success++;
            } else {
                $order_result['error'] = '更新失败';
                $batch_results[] = $order_result;
                $batch_fail++;
            }
            
            // 小延迟，避免服务器过载
            usleep(200000); // 延迟0.2秒
        }
        
        // 汇总批次结果
        $all_results[] = [
            'batch' => $batch_num,
            'processed' => count($batch_results),
            'success' => $batch_success,
            'fail' => $batch_fail
        ];
        
        $total_success += $batch_success;
        $total_fail += $batch_fail;
        
        // 输出进度（可选）
        ob_flush();
        flush();
    }
    
    // 返回最终结果
    echo json_encode([
        'success' => true,
        'total_orders' => $total_orders,
        'total_batches' => $total_batches,
        'batches_processed' => $batches_to_process,
        'total_processed' => $total_success + $total_fail,
        'total_success' => $total_success,
        'total_fail' => $total_fail,
        'remaining_batches' => $total_batches - $batches_to_process,
        'batch_results' => $all_results
    ]);
}elseif($act=='auto_monitor_single'){//自动监控单个订单，每次API调用处理一个
    // 设置内容类型为JSON
    header('Content-Type: application/json');
    
    // 防止超时
    set_time_limit(60); // 设置最大执行时间为1分钟
    
    // 获取参数
    $status_filter = isset($_GET['status']) ? daddslashes($_GET['status']) : ''; // 状态过滤
    $force_next = isset($_GET['force_next']) ? intval($_GET['force_next']) : 0; // 强制处理下一个
    
    // 构建查询条件
    $where_clause = "status!='已完成' AND status!='已取消'";
    if(!empty($status_filter)) {
        $where_clause .= " AND status='$status_filter'";
    }
    
    // 获取总订单数
    $total_query = $DB->query("SELECT COUNT(oid) as total FROM qingka_wangke_order WHERE $where_clause");
    $total_row = $DB->fetch($total_query);
    $total_orders = $total_row['total'];
    
    if($total_orders == 0) {
        echo json_encode([
            'success' => true,
            'message' => '没有需要处理的订单',
            'total_orders' => 0
        ]);
        exit;
    }
    
    // 获取所有未完成订单的ID列表
    $all_oids = [];
    $oids_query = $DB->query("SELECT oid FROM qingka_wangke_order WHERE $where_clause ORDER BY oid ASC");
    while($oid_row = $DB->fetch($oids_query)) {
        $all_oids[] = $oid_row['oid'];
    }
    
    // 使用备用方式：临时文件来存储位置
    $position_file = 'data/order_position.txt';
    $dir = dirname($position_file);
    if(!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    // 确定当前处理位置
    $current_position = 0;
    
    // 1. 尝试从数据库读取
    $db_position_ok = false;
    $check_table = $DB->query("SHOW TABLES LIKE 'qingka_wangke_config'");
    if($DB->fetch($check_table)) {
        // 表存在，获取配置
        $config = $DB->get_row("SELECT * FROM qingka_wangke_config WHERE `key`='last_single_position'");
        if($config) {
            $config_data = json_decode($config['value'], true);
            if(isset($config_data['status']) && $config_data['status'] == $status_filter) {
                $current_position = intval($config_data['position']);
                $db_position_ok = true;
            }
        }
    } else {
        // 表不存在，创建表
        $create_result = $DB->query("CREATE TABLE IF NOT EXISTS `qingka_wangke_config` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `key` varchar(64) NOT NULL,
            `value` text NOT NULL,
            `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `key` (`key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
    
    // 2. 如果数据库读取失败，尝试从文件读取
    if(!$db_position_ok && file_exists($position_file)) {
        $position_data = file_get_contents($position_file);
        if($position_data) {
            $position_info = json_decode($position_data, true);
            if(isset($position_info['status']) && $position_info['status'] == $status_filter) {
                $current_position = intval($position_info['position']);
            }
        }
    }
    
    // 强制处理下一个
    if($force_next) {
        $current_position++;
        if($current_position >= count($all_oids)) {
            $current_position = 0;
        }
    }
    
    // 确保位置在有效范围内
    if($current_position < 0 || $current_position >= count($all_oids)) {
        $current_position = 0;
    }
    
    // 获取当前位置的订单ID
    $oid = isset($all_oids[$current_position]) ? $all_oids[$current_position] : 0;
    
    if(!$oid) {
        echo json_encode([
            'success' => false,
            'message' => '获取订单失败',
            'total_orders' => $total_orders
        ]);
        exit;
    }
    
    // 获取订单详细信息
    $order = $DB->get_row("SELECT * FROM qingka_wangke_order WHERE oid='$oid'");
    $original_status = $order['status'];
    
    $result_data = [
        'oid' => $oid,
        'original_status' => $original_status,
        'success' => false
    ];
    
    // 处理特殊情况
    if($order['hid'] == 'ximeng') {
        $result_data['error'] = '接口异常';
    } elseif($order['dockstatus'] == '99') {
        $result_data['success'] = true;
        $result_data['message'] = '实时进度无需更新';
        $result_data['new_status'] = $original_status;
    } else {
        // 更新订单
        $result = processCx($oid);
        if(is_array($result) && count($result) > 0) {
            for($i=0; $i<count($result); $i++) {
                $DB->query("UPDATE qingka_wangke_order SET 
                    `name`='{$result[$i]['name']}',
                    `yid`='{$result[$i]['yid']}',
                    `status`='{$result[$i]['status_text']}',
                    `courseStartTime`='{$result[$i]['kcks']}',
                    `courseEndTime`='{$result[$i]['kcjs']}',
                    `examStartTime`='{$result[$i]['ksks']}',
                    `examEndTime`='{$result[$i]['ksjs']}',
                    `process`='{$result[$i]['process']}',
                    `remarks`='{$result[$i]['remarks']}' 
                    WHERE `user`='{$result[$i]['user']}' AND `kcname`='{$result[$i]['kcname']}' AND `oid`='{$oid}'");
            }
            
            // 获取更新后的状态
            $updated_order = $DB->get_row("SELECT status, process, remarks FROM qingka_wangke_order WHERE oid='$oid'");
            
            $result_data['success'] = true;
            $result_data['new_status'] = $updated_order['status'];
            $result_data['process'] = $updated_order['process'];
            $result_data['remarks'] = $updated_order['remarks'];
        } else {
            $result_data['error'] = '更新失败';
        }
    }
    
    // 计算下一个位置
    $next_position = $current_position + 1;
    if($next_position >= count($all_oids)) {
        $next_position = 0; // 循环回到开始
    }
    
    // 获取下一个订单ID
    $next_oid = isset($all_oids[$next_position]) ? $all_oids[$next_position] : 0;
    
    // 保存处理位置（多种方式同时保存）
    $position_data = [
        'position' => $next_position,
        'status' => $status_filter,
        'timestamp' => time(),
        'last_oid' => $oid
    ];
    
    // 1. 保存到数据库
    $db_save_success = false;
    $config_data = json_encode($position_data);
    if($DB->get_row("SELECT * FROM qingka_wangke_config WHERE `key`='last_single_position'")) {
        $update_result = $DB->query("UPDATE qingka_wangke_config SET `value`='$config_data' WHERE `key`='last_single_position'");
        $db_save_success = ($update_result !== false);
    } else {
        $insert_result = $DB->query("INSERT INTO qingka_wangke_config (`key`, `value`) VALUES ('last_single_position', '$config_data')");
        $db_save_success = ($insert_result !== false);
    }
    
    // 2. 备份保存到文件
    $file_save_success = false;
    try {
        if(file_put_contents($position_file, $config_data)) {
            $file_save_success = true;
        }
    } catch(Exception $e) {
        // 保存失败
    }
    
    // 设置一个cookie作为第三种备份方式
    setcookie('last_order_position', $config_data, time() + 86400, '/');
    
    // 返回处理结果
    echo json_encode([
        'success' => true,
        'total_orders' => $total_orders,
        'current_position' => $current_position,
        'next_position' => $next_position,
        'order_processed' => $result_data,
        'current_oid' => $oid,
        'next_oid' => $next_oid,
        'db_save' => $db_save_success,
        'file_save' => $file_save_success,
        'all_oids_count' => count($all_oids),
        'message' => '每次调用处理一个订单，每次都会处理不同的订单',
        'next_url' => "cron.php?act=auto_monitor_single" . ($status_filter ? "&status=" . urlencode($status_filter) : "") . "&force_next=1"
    ]);
}


?>

