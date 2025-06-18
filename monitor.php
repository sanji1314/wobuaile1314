<?php
include('../confing/common.php');
// 简化登录验证
if(!isset($_COOKIE["admin_token"])) {
    exit("<script language='javascript'>window.location.href='./login.php';</script>");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>订单监控中心</title>
    <link rel="stylesheet" href="../assets/layui/css/layui.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/layui/layui.js"></script>
    <style>
        .monitor-container {
            padding: 20px;
        }
        .monitor-header {
            margin-bottom: 20px;
        }
        .monitor-actions {
            margin-bottom: 20px;
        }
        .monitor-log {
            height: 400px;
            overflow-y: auto;
            background-color: #f9f9f9;
            border: 1px solid #e6e6e6;
            padding: 10px;
            border-radius: 2px;
            font-family: Consolas, Monaco, monospace;
            margin-bottom: 20px;
        }
        .log-success {
            color: #5FB878;
        }
        .log-error {
            color: #FF5722;
        }
        .log-info {
            color: #1E9FFF;
        }
        .log-warning {
            color: #FFB800;
        }
        .action-buttons {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">订单监控系统</div>
        </div>
        
        <div class="layui-body" style="left: 0;">
            <div class="monitor-container">
                <div class="monitor-header">
                    <h2>订单监控中心</h2>
                    <p>通过此页面可以对未完成的订单进行监控和更新</p>
                </div>
                
                <div class="monitor-actions">
                    <div class="layui-card">
                        <div class="layui-card-header">监控控制</div>
                        <div class="layui-card-body">
                            <div class="layui-form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">监控模式</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="monitorMode" value="all" title="监控所有未完成订单" checked>
                                        <input type="radio" name="monitorMode" value="uid" title="指定UID监控">
                                        <input type="radio" name="monitorMode" value="oid" title="指定订单ID监控">
                                    </div>
                                </div>
                                
                                <div class="layui-form-item" id="uidInput" style="display:none;">
                                    <label class="layui-form-label">UID</label>
                                    <div class="layui-input-inline">
                                        <input type="number" class="layui-input" id="uid" placeholder="请输入用户UID">
                                    </div>
                                </div>
                                
                                <div class="layui-form-item" id="oidInput" style="display:none;">
                                    <label class="layui-form-label">订单ID</label>
                                    <div class="layui-input-inline">
                                        <input type="number" class="layui-input" id="oid" placeholder="请输入订单ID">
                                    </div>
                                </div>
                                
                                <div class="layui-form-item">
                                    <label class="layui-form-label">批处理数量</label>
                                    <div class="layui-input-inline">
                                        <input type="number" class="layui-input" id="batchSize" value="5" min="1" max="20">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">每批处理的订单数量（建议5-10个）</div>
                                </div>
                                
                                <div class="action-buttons">
                                    <button type="button" class="layui-btn layui-btn-normal" id="startMonitor">开始监控</button>
                                    <button type="button" class="layui-btn layui-btn-danger" id="stopMonitor" disabled>停止监控</button>
                                    <button type="button" class="layui-btn layui-btn-primary" id="clearLog">清空日志</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="layui-card">
                    <div class="layui-card-header">监控日志</div>
                    <div class="layui-card-body">
                        <div class="monitor-log" id="monitorLog"></div>
                        <div class="layui-progress" lay-filter="progress" style="margin-bottom: 10px;">
                            <div class="layui-progress-bar" lay-percent="0%"></div>
                        </div>
                        <div id="progressInfo">未开始监控</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    layui.use(['form', 'layer', 'element'], function(){
        var form = layui.form;
        var layer = layui.layer;
        var element = layui.element;
        var $ = layui.jquery;
        
        // 监听单选按钮切换
        form.on('radio(monitorMode)', function(data){
            if(data.value === 'uid') {
                $('#uidInput').show();
                $('#oidInput').hide();
            } else if(data.value === 'oid') {
                $('#oidInput').show();
                $('#uidInput').hide();
            } else {
                $('#uidInput').hide();
                $('#oidInput').hide();
            }
        });
        
        // 点击单选按钮事件
        $('input[name="monitorMode"]').click(function(){
            var value = $(this).val();
            if(value === 'uid') {
                $('#uidInput').show();
                $('#oidInput').hide();
            } else if(value === 'oid') {
                $('#oidInput').show();
                $('#uidInput').hide();
            } else {
                $('#uidInput').hide();
                $('#oidInput').hide();
            }
        });
        
        // 清空日志
        $('#clearLog').click(function(){
            $('#monitorLog').empty();
            element.progress('progress', '0%');
            $('#progressInfo').text('已清空日志');
        });
        
        var isMonitoring = false;
        var currentBatch = 0;
        var totalOrders = 0;
        var processedOrders = 0;
        var orderIds = [];
        
        // 开始监控
        $('#startMonitor').click(function(){
            if(isMonitoring) return;
            
            var mode = $('input[name="monitorMode"]:checked').val();
            var batchSize = parseInt($('#batchSize').val()) || 5;
            
            if(batchSize < 1 || batchSize > 20) {
                layer.msg('批处理数量必须在1-20之间', {icon: 2});
                return;
            }
            
            if(mode === 'uid') {
                var uid = parseInt($('#uid').val());
                if(!uid || uid <= 0) {
                    layer.msg('请输入有效的UID', {icon: 2});
                    return;
                }
                startUidMonitor(uid, batchSize);
            } else if(mode === 'oid') {
                var oid = parseInt($('#oid').val());
                if(!oid || oid <= 0) {
                    layer.msg('请输入有效的订单ID', {icon: 2});
                    return;
                }
                startOidMonitor(oid);
            } else {
                startAllMonitor(batchSize);
            }
        });
        
        // 停止监控
        $('#stopMonitor').click(function(){
            isMonitoring = false;
            $(this).attr('disabled', true);
            $('#startMonitor').attr('disabled', false);
            addLog('监控已停止', 'warning');
        });
        
        // 添加日志
        function addLog(message, type) {
            var logClass = '';
            switch(type) {
                case 'success': logClass = 'log-success'; break;
                case 'error': logClass = 'log-error'; break;
                case 'warning': logClass = 'log-warning'; break;
                default: logClass = 'log-info';
            }
            
            var time = new Date().toLocaleTimeString();
            var logItem = $('<div class="' + logClass + '">[' + time + '] ' + message + '</div>');
            $('#monitorLog').append(logItem);
            $('#monitorLog').scrollTop($('#monitorLog')[0].scrollHeight);
        }
        
        // 更新进度
        function updateProgress(current, total) {
            var percent = Math.floor((current / total) * 100) + '%';
            element.progress('progress', percent);
            $('#progressInfo').text('进度: ' + current + '/' + total + ' (' + percent + ')');
        }
        
        // 监控所有未完成订单
        function startAllMonitor(batchSize) {
            addLog('开始获取所有未完成订单...', 'info');
            
            $.ajax({
                url: '../apisub.php?act=get_orders',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if(res.code !== 1) {
                        addLog('获取订单失败: ' + res.msg, 'error');
                        return;
                    }
                    
                    orderIds = res.data.orders;
                    totalOrders = orderIds.length;
                    
                    if(totalOrders === 0) {
                        addLog('没有需要监控的订单', 'warning');
                        return;
                    }
                    
                    addLog('共获取到 ' + totalOrders + ' 个未完成订单', 'success');
                    processedOrders = 0;
                    currentBatch = 0;
                    
                    isMonitoring = true;
                    $('#startMonitor').attr('disabled', true);
                    $('#stopMonitor').attr('disabled', false);
                    
                    processBatch(orderIds, batchSize);
                },
                error: function(xhr) {
                    addLog('获取订单失败: ' + xhr.status, 'error');
                }
            });
        }
        
        // 监控指定UID的未完成订单
        function startUidMonitor(uid, batchSize) {
            addLog('开始获取UID为 ' + uid + ' 的未完成订单...', 'info');
            
            $.ajax({
                url: '../apisub.php?act=get_user_orders&uid=' + uid,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if(res.code !== 1) {
                        addLog('获取订单失败: ' + res.msg, 'error');
                        return;
                    }
                    
                    orderIds = res.data.orders;
                    totalOrders = orderIds.length;
                    
                    if(totalOrders === 0) {
                        addLog('该用户没有需要监控的订单', 'warning');
                        return;
                    }
                    
                    addLog('共获取到 ' + totalOrders + ' 个未完成订单', 'success');
                    processedOrders = 0;
                    currentBatch = 0;
                    
                    isMonitoring = true;
                    $('#startMonitor').attr('disabled', true);
                    $('#stopMonitor').attr('disabled', false);
                    
                    processBatch(orderIds, batchSize);
                },
                error: function(xhr) {
                    addLog('获取订单失败: ' + xhr.status, 'error');
                }
            });
        }
        
        // 监控指定订单ID
        function startOidMonitor(oid) {
            addLog('开始监控订单ID: ' + oid, 'info');
            
            $.ajax({
                url: '../apisub.php?act=get_order_info&oid=' + oid,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if(res.code !== 1) {
                        addLog('获取订单信息失败: ' + res.msg, 'error');
                        return;
                    }
                    
                    var order = res.data;
                    addLog('获取到订单信息: 用户UID=' + order.uid + ', 课程=' + order.kcname + ', 状态=' + order.status, 'success');
                    
                    isMonitoring = true;
                    $('#startMonitor').attr('disabled', true);
                    $('#stopMonitor').attr('disabled', false);
                    
                    // 更新单个订单
                    updateOrder(oid, function() {
                        isMonitoring = false;
                        $('#startMonitor').attr('disabled', false);
                        $('#stopMonitor').attr('disabled', true);
                        addLog('订单监控完成', 'success');
                    });
                },
                error: function(xhr) {
                    addLog('获取订单信息失败: ' + xhr.status, 'error');
                }
            });
        }
        
        // 处理一批订单
        function processBatch(orderIds, batchSize) {
            if(!isMonitoring) return;
            
            var start = currentBatch * batchSize;
            var end = Math.min(start + batchSize, totalOrders);
            
            if(start >= totalOrders) {
                isMonitoring = false;
                $('#startMonitor').attr('disabled', false);
                $('#stopMonitor').attr('disabled', true);
                addLog('所有订单监控完成', 'success');
                return;
            }
            
            var currentOrderIds = orderIds.slice(start, end);
            addLog('开始处理第 ' + (currentBatch+1) + ' 批订单，本批 ' + currentOrderIds.length + ' 个订单', 'info');
            
            var processed = 0;
            
            // 依次处理每个订单
            function processNext(index) {
                if(!isMonitoring || index >= currentOrderIds.length) {
                    // 当前批次处理完毕，进入下一批
                    currentBatch++;
                    setTimeout(function() {
                        processBatch(orderIds, batchSize);
                    }, 1000);
                    return;
                }
                
                var oid = currentOrderIds[index];
                updateOrder(oid, function() {
                    processed++;
                    processedOrders++;
                    updateProgress(processedOrders, totalOrders);
                    
                    // 处理下一个订单
                    setTimeout(function() {
                        processNext(index + 1);
                    }, 500);
                });
            }
            
            // 开始处理第一个订单
            processNext(0);
        }
        
        // 更新单个订单
        function updateOrder(oid, callback) {
            addLog('正在更新订单 #' + oid + '...', 'info');
            
            $.ajax({
                url: '../apisub.php?act=wkupdate',
                type: 'POST',
                data: {oid: oid},
                dataType: 'json',
                success: function(res) {
                    if(res.code === 1) {
                        addLog('订单 #' + oid + ' 更新成功: ' + res.msg, 'success');
                    } else {
                        addLog('订单 #' + oid + ' 更新失败: ' + res.msg, 'error');
                    }
                    
                    if(callback) callback();
                },
                error: function(xhr) {
                    addLog('订单 #' + oid + ' 更新请求失败: ' + xhr.status, 'error');
                    if(callback) callback();
                }
            });
        }
    });
    </script>
</body>
</html> 