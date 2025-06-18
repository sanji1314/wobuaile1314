<?php
include('head.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="../../layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="../../layuiadmin/style/admin.css" media="all">
</head>
<body>
<div id="userinfo">
  <div class="layui-bg-gray" style="padding: 15px;">
  <div class="layui-row layui-col-space15">
     <div class="layui-col-xs12 layui-col-md12">
<div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
<div class="layui-card-header">
全站通知：
<span class="layui-badge layui-btn layui-btn-primary layuiadmin-badge"><a href="<?=$conf['tongzhidizhi']?>"  target="_blank">订阅本站通知</a></span>
</div>
<span style='height:20px'><?=$conf['notice'];?></span>
<span class="layuiadmin-span-color"></span>
</p>
</div>
</div>
</div>
    <div class="layui-col-sm6 layui-col-md3">
        <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
          <div class="layui-card-header">
            账户积分
            <span class="layui-badge layui-bg-gray layuiadmin-badge"><a lay-href="pay">积分充值</a></span>
          </div>
          <div class="layui-card-body layuiadmin-card-list">
            <p class="layuiadmin-big-font" style="color: #6699FF;"><?php echo $userrow['money']."积分"; ?></p>
            <p>
              总充值 
              <span class="layuiadmin-span-color"><?php echo $userrow['zcz']."积分"; ?><i class="layui-inline layui-icon layui-icon-rmb"></i></span>
            </p>
          </div>
        </div>
      </div>
      <div class="layui-col-sm6 layui-col-md3">
        <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
          <div class="layui-card-header">
            今日订单
            <span class="layui-badge layui-bg-gray layuiadmin-badge"><a lay-href="add">订单提交</a></span>
          </div>
          <div class="layui-card-body layuiadmin-card-list">
            <p class="layuiadmin-big-font" style="color: #6699FF;">
            <?php
                if($userrow['uid']!="1"){
                    $a=$DB->count("select count(*) from qingka_wangke_order where addtime>'$jtdate' and uid='{$userrow['uid']}'");
		            echo $a."条";
                }else{
                    $a=$DB->count("select count(*) from qingka_wangke_order where addtime>'$jtdate'");
		            echo $a."条";
                }
            ?>
            </p>
            <p>
              总订单 
              <span class="layuiadmin-span-color"><?php
                                if($userrow['uid']!="1"){
                                    $a=$DB->count("select count(*) from qingka_wangke_order where uid='{$userrow['uid']}'");
            			            echo $a."条";
                                }else{
                                    $a=$DB->count("select count(*) from qingka_wangke_order");
            			            echo $a."条";
                                }
    			            ?><i class="layui-inline layui-icon layui-icon-list"></i></span>
            </p>
          </div>
        </div>
      </div>
      <div class="layui-col-sm6 layui-col-md3">
        <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
          <div class="layui-card-header">
            新增代理
            <span class="layui-badge layui-bg-gray layuiadmin-badge"><a lay-href="userlist">开通代理</a></span>
          </div>
          <div class="layui-card-body layuiadmin-card-list">

            <p class="layuiadmin-big-font" style="color: #6699FF;">
            <?php
                if($userrow['uid']!="1"){
                    $a=$DB->count("select count(*) from qingka_wangke_user where addtime>'$jtdate' and uid='{$userrow['uid']}'");
		            echo $a."位";
                }else{
                    $a=$DB->count("select count(*) from qingka_wangke_user where addtime>'$jtdate'");
		            echo $a."位";
                }
    		?>
    		</p>
            <p>
              总代理
              <span class="layuiadmin-span-color"><?php
                                if($userrow['uid']!="1"){
                                    $a=$DB->count("select count(*) from qingka_wangke_user where uid='{$userrow['uid']}'");
            			            echo $a."位";
                                }else{
                                    $a=$DB->count("select count(*) from qingka_wangke_user");
            			            echo $a."位";
                                }
    			?><i class="layui-inline layui-icon layui-icon-user"></i></span>
            </p>
          </div>
        </div>
      </div>
      <div class="layui-col-sm6 layui-col-md3">
        <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
          <div class="layui-card-header">
            总下单率
            <span class="layui-badge layui-bg-gray layuiadmin-badge"><a lay-href="log">查看日志</a></span>
          </div>
          <div class="layui-card-body layuiadmin-card-list">
            <p class="layuiadmin-big-font" style="color: #6699FF;"><?php echo $xdb."%";?></p>
            <p>
              api调用扣费限制
              <span class="layuiadmin-span-color"><?php echo $conf['api_proportion']."%"; ?><i class="layui-inline layui-icon layui-icon-chart"></i></span>
            </p>
          </div>
        </div>
      </div>
  </div>
</div> 
  <div class="layui-fluid">
      
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md6">
            <div class="layui-card"  style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">
                
                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs3">
                        <a lay-href="add">
                          <i class="layui-icon layui-icon-release"></i>
                          <cite>使用积分</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="list">
                          <i class="layui-icon layui-icon-list"></i>
                          <cite>使用记录</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="pay">
                          <i class="layui-icon layui-icon-rmb"></i>
                          <cite>积分充值</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="userlist">
                          <i class="layui-icon layui-icon-user"></i>
                          <cite>下级管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="log">
                          <i class="layui-icon layui-icon-find-fill"></i>
                          <cite>操作日志</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="docking">
                          <i class="layui-icon layui-icon-link"></i>
                          <cite>对接文档</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="help">
                          <i class="layui-icon layui-icon-tips"></i>
                          <cite>商品说明</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="userinfo">
                          <i class="layui-icon layui-icon-username"></i>
                          <cite>我的资料</cite>
                        </a>
                      </li>
                    </ul>
                    
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="layui-col-md6">
            <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
              <div class="layui-card-header">订单数据</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a lay-href="list" class="layadmin-backlog-body">
                          <h3>已下单</h3>
                            <p><cite style="color: #000000;"><?php
                                if($userrow['uid']!="1"){
                                    //$a=$DB->count("select count(*) from qingka_wangke_order where addtime>'$jtdate' and uid='{$userrow['uid']}'");
                                    $a=$DB->count("select count(*) from qingka_wangke_order where uid='{$userrow['uid']}'");
                                        echo $a."条";
                                    }else{
                                        $a=$DB->count("select count(*) from qingka_wangke_order");
                                        echo $a."条";
                                                         }
                                ?>
                              </cite>
                            </p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="list" class="layadmin-backlog-body">
                          <h3>进行中</h3>
                          <p><cite style="color: #6699FF;"><?php
                                        if($userrow['uid']!="1"){
                                            $jxz=$DB->count("select count(*) from qingka_wangke_order where status!='已完成' AND status!='已取消' AND uid='{$userrow['uid']}' ");
                                            echo $jxz."条";
                                        }else{
                                            $a=$DB->count("select count(*) from qingka_wangke_order where status!='已完成' AND status!='已取消'");
                                            echo $a."条";
                                        }
                                    ?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="list" class="layadmin-backlog-body">
                          <h3>已完成</h3>
                          <p><cite style="color: #99CC66;"><?php
                                                            if($userrow['uid']!="1"){
                                                                $a=$DB->count("select count(*) from qingka_wangke_order where status='已完成' AND uid='{$userrow['uid']}' ");
                                        			            echo $a."条";
                                                            }else{
                                                                $a=$DB->count("select count(*) from qingka_wangke_order where status='已完成'");
                                        			            echo $a."条";
                                                            }
                                			            ?></cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <!--<a href="list" onclick="layer.tips('不跳转', this, {tips: 3});" class="layadmin-backlog-body">-->
                        <a href="list" class="layadmin-backlog-body">
                          <h3>异常订单</h3>
                          <p><cite style="color: #FF5722;"><?php
                                    if($userrow['uid']!="1"){
                                        $yc=$DB->count("select count(*) from qingka_wangke_order where status='异常' AND uid='{$userrow['uid']}'");
                                        echo $yc."条";
                                    }else{
                                        $a=$DB->count("select count(*) from qingka_wangke_order where status='异常'");
                                        echo $a."条";
                                    }
                                   ?></cite></p>
                        </a>
                      </li>
                    </ul>
                    <!--<ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a href="javascript:;" class="layadmin-backlog-body">
                          <h3>异常订单</h3>
                          <p><cite style="color: #FF5722;"><?php
                                    if($userrow['uid']!="1"){
                                        
                                        echo $ycdd."条";
                                    }else{
                                        $a=$DB->count("select count(*) from qingka_wangke_order where status='异常'");
                                        echo $a."条";
                                    }
                                   ?></cite></p>
                        </a>
                      </li>
                    </ul>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="layui-col-md4">
        <div class="layui-card"  style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
          <div class="layui-card-header">查看公告</div>
          <div class="layui-card-body layui-text layadmin-version">
            <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a data-toggle="tab" href="#user-basic">我的资料</a>
            </li>
            <li class="nav-item">
              <a data-toggle="tab" href="#profile-basic">上级公告</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade" id="user-basic">
              <span>
                  <ul class="layadmin-homepage-list-group">
                            <li class="list-group-item"><i class="layui-icon layui-icon-username" style="
                                color: #8bc34a;
                            "></i> UID: <span class="layui-badge layui-bg-blue"><?php echo $userrow['uid']; ?></span></li>
                            <li class="list-group-item"><i class="layui-icon layui-icon-username" style="
                                color: #8bc34a;
                            "></i> 费率: <span class="layui-badge layui-bg-blue"><?php echo $userrow['addprice']; ?><span/></li>
                            <li class="list-group-item"><i class="layui-icon layui-icon-vercode" style="
                                color: #8bc34a;
                            "></i>  Key:<span class="layui-badge layui-bg-blue"><?php 
                                                  if($userrow['key']=="0"){
                                                      echo "未开通KEY"; 
                                                  }else{
                                                      echo $userrow['key']; 
                                                  }
                                                  ?></span></li>
                            
                        </ul>
              </span>
            </div>
            <div class="tab-pane fade" id="profile-basic">
              <span><?php echo $userrow['notice'];?></span>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <script src="../../layuiadmin/layui/layui.js?t=1"></script>  
  <script>
  layui.config({
    base: '../../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'console']);
  </script>
  <script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/Chart.js"></script>
<script src="assets/js/aes.js"></script>
<script src="https://cdn.staticfile.org/vue/2.6.11/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>
</html>
<script type="text/javascript">
		    var vm=new Vue({
		     	el: "#userindex",
		     	layer = layui.layer,
		    	data: {
		      		row:null,
		      		inte:'',
		        },
		      	methods:{
		    		userinfo:function(){
		    			var load=layer.load(2);
		     			this.$http.post("/apisub.php?act=userinfo")
				          .then(function(data){	
				          	   	layer.close(load);
				          	if(data.data.code==1){			                     	
				          		this.row=data.data			             			                     
				          	}else{
				                layer.alert(data.data.msg,{icon:2});
				          	}
				          });	
		    		},yecz:function(){
		    			layer.alert('请联系您的上级QQ：'+this.row.sjuser+'，进行充值。（好友点充值，此处将显示您的QQ）',{icon:1,title:"温馨提示"});
		    		},
		    		ktapi:function(){
		    			layer.confirm('后台余额满300可免费开通，反之需花费10余额开通', {title:'温馨提示',icon:1,
							  btn: ['确定','取消'] //按钮
							}, function(){
							  		var load=layer.load();
					     			axios.get("/apisub.php?act=ktapi&type=1")
							          .then(function(data){	
							          	   	layer.close(load);
							          	if(data.data.code==1){			                     	
	    			                        layer.alert(data.data.msg,{icon:1,title:"温馨提示"},function(){setTimeout(function(){window.location.href=""});});							          				             			                     
							          	}else{
							                layer.msg(data.data.msg,{icon:2});
							          	}
							        });	
							
						    });
		    	    },
		    	    szyqprice:function(){		    	    	
						layer.prompt({title: '设置好友默认等级，首次自动生成邀请码', formType: 3}, function(yqprice, index){
						  layer.close(index);
						  var load=layer.load();
			              $.post("/apisub.php?act=yqprice",{yqprice},function (data) {
					 	     layer.close(load);
				             if (data.code==1){
				             	vm.userinfo();  
				                layer.alert(data.msg,{icon:1});
				             }else{
				                layer.msg(data.msg,{icon:2});
				             }
			              });		    		    
					  });
		    	    },
		    	    connect_qq:function(){
		    	    	    var ii = layer.load(0, {shade:[0.1,'#fff']});
							$.ajax({
								type : "POST",
								url : "../apisub.php?act=connect",
								data : {},
								dataType : 'json',
								success : function(data) {
									layer.close(ii);
									if(data.code == 0){
										window.location.href = data.url;
									}else{
										layer.alert(data.msg, {icon: 7});
									}
								} 
							});	
		    	  },szgg:function(){
		    	  		layer.prompt({title: '设置代理公告，您的代理可看到', formType: 2}, function(notice, index){
						  layer.close(index);
						  var load=layer.load();
			              $.post("/apisub.php?act=user_notice",{notice},function (data) {
					 	     layer.close(load);
				             if (data.code==1){
				             	vm.userinfo();  
				                layer.msg(data.msg,{icon:1});
				             }else{
				                layer.msg(data.msg,{icon:2});
				             }
			              });		    		    
					  });   	  	
		    	  }
		    	
		     	},
		     	mounted(){
		     		this.userinfo();
		     		
		     	}
		      });
		  
       </script>
       
<script>
    layui.use(['layer', 'miniTab','echarts'], function () {
        var $ = layui.jquery,
            layer = layui.layer,
            miniTab = layui.miniTab,
            echarts = layui.echarts;

        miniTab.listen();

        /**
         * 查看公告信息
         **/
        $('body').on('click', '.layuimini-notice', function () {
            var title = $(this).children('.layuimini-notice-title').text(),
                noticeTime = $(this).children('.layuimini-notice-extra').text(),
                content = $(this).children('.layuimini-notice-content').html();
            var html = '<div style="padding:15px 20px; text-align:justify; line-height: 22px;border-bottom:1px solid #e2e2e2;background-color: #2f4056;color: #ffffff">\n' +
                '<div style="text-align: center;margin-bottom: 20px;font-weight: bold;border-bottom:1px solid #718fb5;padding-bottom: 5px"><h4 class="text-danger">' + title + '</h4></div>\n' +
                '<div style="font-size: 12px">' + content + '</div>\n' +
                '</div>\n';
            parent.layer.open({
                type: 1,
                title: '系统公告'+'<span style="float: right;right: 1px;font-size: 12px;color: #b1b3b9;margin-top: 1px">'+noticeTime+'</span>',
                area: '300px;',
                shade: 0.8,
                id: 'layuimini-notice',
                btn: ['关闭'],
                btnAlign: 'c',
                moveType: 1,
                content:html,
                success: function (layero) {
                    var btn = layero.find('.layui-layer-btn');
                    btn.find('.layui-layer-btn1').attr({
                        href: '',
                        target: ''
                    });
                }
            });
        });
        layer.open({
           type: 1, 
           title:'公告[请仔细阅读]',
           content: '<?=$conf['tcgonggao'];?>' ,//这里content是一个普通的String
           time: 20000, 
           btn:'好的我知道了',
           btnAlign: 'c', //按钮居中
           shade: 0, //不显示遮罩
           area: ['300px']
           });
        window.onresize = function(){
            echartsRecords.resize();
        }

    });
</script>
<script>
             //禁止鼠标右击
      document.oncontextmenu = function() {
        event.returnValue = false;
      };
      //禁用开发者工具F12
      document.onkeydown = document.onkeyup = document.onkeypress = function(event) {
        let e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 123) {
          e.returnValue = false;
          return false;
        }
      };
      let userAgent = navigator.userAgent;
      if (userAgent.indexOf("Firefox") > -1) {
        let checkStatus;
        let devtools = /./;
        devtools.toString = function() {
          checkStatus = "on";
        };
        setInterval(function() {
          checkStatus = "off";
          console.log(devtools);
          console.log(checkStatus);
          console.clear();
          if (checkStatus === "on") {
            let target = "";
            try {
              window.open("about:blank", (target = "_self"));
            } catch (err) {
              let a = document.createElement("button");
              a.onclick = function() {
                window.open("about:blank", (target = "_self"));
              };
              a.click();
            }
          }
        }, 200);
      } else {
        //禁用控制台
        let ConsoleManager = {
          onOpen: function() {
            alert("Console is opened");
          },
          onClose: function() {
            alert("Console is closed");
          },
          init: function() {
            let self = this;
            let x = document.createElement("div");
            let isOpening = false,
              isOpened = false;
            Object.defineProperty(x, "id", {
              get: function() {
                if (!isOpening) {
                  self.onOpen();
                  isOpening = true;
                }
                isOpened = true;
                return true;
              }
            });
            setInterval(function() {
              isOpened = false;
              console.info(x);
              console.clear();
              if (!isOpened && isOpening) {
                self.onClose();
                isOpening = false;
              }
            }, 200);
          }
        };
        ConsoleManager.onOpen = function() {
          //打开控制台，跳转
          let target = "";
          try {
            window.open("about:blank", (target = "_self"));
          } catch (err) {
            let a = document.createElement("button");
            a.onclick = function() {
              window.open("about:blank", (target = "_self"));
            };
            a.click();
          }
        };
        ConsoleManager.onClose = function() {
          alert("Console is closed!!!!!");
        };
        ConsoleManager.init();
      }
        </script>
</body>
</html>

