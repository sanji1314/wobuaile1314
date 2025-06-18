<?php
include('../confing/common.php');
if($islogin!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$conf['sitename']?></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
</head>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin" id="userindex">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
            <?php if($conf['kf']==1){ ?>
           <li class="layui-nav-item" lay-unselect>
          <a href="https://wpa.qq.com/msgrd?v=3&uin=<?=$conf['kflj']?>&site=qq&menu=yes&jumpflag=1" target="_blank" >
          <i class="layui-icon layui-icon-login-qq"></i>&nbsp;平台客服QQ
          </a>
          </li>
          <?php } ?> 
          <?php if($conf['qun']==1){ ?>
          <li class="layui-nav-item" lay-unselect>
          <a href="<?=$conf['qunlj']?>" target="_blank" >
          <i class="layui-icon layui-icon-login-qq"></i>&nbsp;平台通知群
          </a>
          </li>
          <?php } ?> 
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:void(0)" data-toggle="dropdown">
                <img class="img-avatar img-avatar-48 m-r-10" style="border-radius: 8px;width:30px;height:30px;border:0px;" src="http://q2.qlogo.cn/headimg_dl?dst_uin=<?=$userrow['user'];?>&spec=100" alt="<?=$userrow['name'];?>" />
                <span><?=$userrow['name'];?> <span class="caret"></span></span>
              </a>
            <dl class="layui-nav-child">
              <ul class="dropdown-menu dropdown-menu-right">
                  <li> <a id="sjqy">上级迁移</a> </li>
                  <li> <a lay-href="passwd" id="passwd">修改密码</a> </li>
                  <li> <a id="szyqprice">设置邀请码</a> </li>
                <li> <a href="../apisub.php?act=logout"><i class="layui-icon layui-icon-logout"></i> 退出登录</a> </li>
              </ul>
            </dl>
          </li>
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="home.php">
            <!--<a href="home"><img src="<?=$conf['logo']?>" title="LightYear" height="50" width="190" alt="LightYear" /></a>-->
            <span><?=$conf['sitename']?></span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
              
            <li data-name="home" class="layui-nav-item layui-nav-itemed">
              <a lay-href="home.php" lay-tips="主页" lay-direction="2">
                <i class="layui-icon layui-icon-home"></i>
                <cite>主页</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" class="layui-this">
                  <i class="layui-icon layui-icon-home"></i><a lay-href="home.php">控制台</a>
                </dd>
              </dl>
            </li>
            <?php if($userrow['uid']==1){ ?>
                  <li data-name="senior" class="layui-nav-item">
              <a href="javascript:;" lay-tips="高级" lay-direction="2">
                <i class="layui-icon layui-icon-set-sm"></i>
                <cite>后台管理</cite>
              </a>
              <dl class="layui-nav-child">
                  <dd data-name="echarts">
                  <a href="javascript:;"><i class="layui-icon layui-icon-website"></i>网站管理</a>
                  <dl class="layui-nav-child">
                    
                    <dd><a lay-href="zzbz"><i class="layui-icon layui-icon-ok-circle"></i>站长帮助</a></dd>
                    <dd><a lay-href="monitor"><i class="layui-icon layui-icon-ok-circle"></i>监控订单</a></dd>
                    <dd><a lay-href="webest"><i class="layui-icon layui-icon-set"></i>网站设置</a></dd>
                    <dd><a lay-href="data"><i class="layui-icon layui-icon-chart-screen"></i>数据统计</a></dd>
                  </dl>
                </dd>
                <dd data-name="echarts">
                  <a href="javascript:;"><i class="layui-icon layui-icon-cart"></i>商品管理</a>
                  <dl class="layui-nav-child">
                    <dd><a lay-href="huoyuan"><i class="layui-icon layui-icon-group"></i>货源设置</a></dd>
                    <dd><a lay-href="yjdj"><i class="layui-icon layui-icon-group"></i>一键对接</a></dd>
                    <dd><a lay-href="fenlei"><i class="layui-icon layui-icon-note"></i>分类设置</a></dd>
                    <dd><a lay-href="class"><i class="layui-icon layui-icon-radio"></i>商品设置</a></dd>
                    
                    <dd><a lay-href="https://www.2oe.cn/wkhy.html"><i class="layui-icon layui-icon-radio"></i>货源推荐</a></dd>
                    
                  </dl>
                </dd>
                <dd data-name="echarts">
                  <a href="javascript:;"><i class="layui-icon layui-icon-user"></i>用户管理</a>
                  <dl class="layui-nav-child">
                    <dd><a lay-href="dengji"><i class="layui-icon layui-icon-diamond"></i>等级设置</a></dd>
                    <dd><a lay-href="mijia"><i class="layui-icon layui-icon-rmb"></i>密价设置</a></dd>
                  </dl>
                </dd>
                <dd data-name="echarts">
                  <a href="javascript:;"><i class="layui-icon layui-icon-dollar"></i>资金管理</a>
                  <dl class="layui-nav-child">
                    <dd><a lay-href="guanx"><i class="layui-icon layui-icon-gift"></i>卡密管理</a></dd>
                    <dd><a lay-href="paylist"><i class="layui-icon layui-icon-form"></i>充值记录</a> </dd>
                  </dl>
                </dd>                
              </dl>
            </li>
            <?php } ?> 
            <li data-name="list" class="layui-nav-item">
              <a href="javascript:;" lay-tips="订单管理" lay-direction="2">
                <i class="layui-icon layui-icon-add-circle"></i>
                <cite>订单提交</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="add">
                  <i class="layui-icon layui-icon-add-circle-fine"></i><a lay-href="add">二改提交</a>
                </dd>
                <dd data-name="add">
                  <i class="layui-icon layui-icon-add-circle-fine"></i><a lay-href="add_ll">琳琅交单页</a>
                </dd>
                <dd data-name="add">
                  <i class="layui-icon layui-icon-add-circle-fine"></i><a lay-href="add_pl">批量提交</a>
                </dd>
               
                <dd data-name="add">
                  <i class="layui-icon layui-icon-add-circle-fine"></i><a lay-href="adds">无查提交</a>
                </dd>
                <dd data-name="kcid">
                  <i class="layui-icon layui-icon-list"></i><a lay-href="kcid">课程ID对比</a>
                </dd>
                
              </dl>
            </li>
            <li class="layui-nav-item"><i class="layui-icon layui-icon-list"></i><a lay-href="list">订单列表</a></li>
            <li class="layui-nav-item"><i class="layui-icon layui-icon-list"></i><a lay-href="jdsc">接单商城</a></li>
            <li data-name="user" class="layui-nav-item">
              <a href="javascript:;" lay-tips="个人中心" lay-direction="2">
                <i class="layui-icon layui-icon-template"></i>
                <cite>个人中心</cite>
              </a>
              <dl class="layui-nav-child">
                <dd><a lay-href="userinfo"><i class="layui-icon layui-icon-about"></i>个人主页</a></dd>
                <dd><a lay-href="charge"><i class="layui-icon layui-icon-notice"></i>上级公告</a></dd>
                <dd><a lay-href="log"><i class="layui-icon layui-icon-about"></i>操作日志</a></dd>
              </dl>
            </li>
            <li class="layui-nav-item"><i class="layui-icon layui-icon-rmb"></i><a lay-href="pay">余额充值</a></li>
            <li class="layui-nav-item"><i class="layui-icon layui-icon-user"></i><a lay-href="userlist">代理管理</a></li>
            <li data-name="user" class="layui-nav-item">
            <a href="javascript:;" lay-tips="对接内容" lay-direction="2">
              <i class="layui-icon layui-icon-template"></i>
            <cite>对接本站</cite>
              </a>
              <dl class="layui-nav-child">
            <li class="layui-nav-item"><i class="layui-icon layui-icon-link"></i><a lay-href="docking">对接文档</a></li>
            <li class="layui-nav-item"><i class="layui-icon layui-icon-survey"></i><a lay-href="gongdan">订单反馈</a></li>
            <li class="layui-nav-item"><i class="layui-icon layui-icon-read"></i><a lay-href="bangzhu">帮助中心</a></li>
            </dl>
            </li>
            <li data-name="user" class="layui-nav-item">
            <a href="javascript:;" lay-tips="本站小功能" lay-direction="2">
              <i class="layui-icon layui-icon-rate-solid"></i>
            <cite>本站小功能</cite>
              </a>
              <dl class="layui-nav-child">
            <dd><i class="layui-icon layui-icon-fire"></i><a lay-href="df">巅峰排行榜</a></dd>
            <dd><i class="layui-icon layui-icon-fire"></i><a lay-href="tjb">下单推荐榜</a></dd>
            <dd><i class="layui-icon layui-icon-find-fill"></i><a lay-href="cqq">查QQ绑定</a></dd>
            <dd><i class="layui-icon layui-icon-find-fill"></i><a lay-href="1.html">流水生成器</a></dd>
            <dd><i class="layui-icon layui-icon-find-fill"></i><a lay-href="2.html">考勤生成器</a></dd>
            <dd><i class="layui-icon layui-icon-find-fill"></i><a lay-href="3.html">经纬度查询</a></dd>
            </dl>
            </li>
            
            
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="home/console.html" lay-attr="home/console.html" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="home.php" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>

  <script src="../layuiadmin/layui/layui.js"></script>
  <script>
  layui.config({
    base: '../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');
  </script>
  <script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap-multitabs/multitabs.js"></script>
<script type="text/javascript" src="assets/LightYear/js/index.min.js"></script>
<script src="assets/js/sy.js"></script>
<!--水印开关，其他页面可以复制过去-->
<?php if ($conf['sykg']==1) {?>
<script type="text/javascript">
watermark('禁止截图，截图封户','昵称 : <?=$userrow['name'];?>','账号:<?=$userrow['user'];?>');
</script>
<?}?>
       <script type="text/javascript">
        $('#sjqy').click(function() {
            layer.prompt({title: '请输入要转移的上级UID', formType: 3}, function(uid, index){
			  layer.close(index);
	           layer.prompt({title: '请输入要转移的上级邀请码', formType: 3}, function(yqm, index){
			  layer.close(index);
	           var load=layer.load(2);
	           $.ajax({
	               type: "POST",
	               url: "../apisub.php?act=sjqy",
	               data: {"uid":uid,"yqm":yqm},
	               dataType: 'json',
	               success: function(data) {
	                   layer.close(load);
	                   if (data.code == 1) {
	                       layer.msg(data.msg,{icon:1});
	                   } else {
	                       layer.msg(data.msg,{icon:2});
	                   }
	               }
	           });           
		  });           
		  });		
    });
         $('#szyqprice').click(function(){		    	    	
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
		    	    });
       layer.open({
           type: 1, 
           title:'公告',
           content: '<?=$conf['tcgonggao'];?>' ,//这里content是一个普通的String
           time: 15000, 
           btn:'好的明白',
           btnAlign: 'c', //按钮居中
           shade: 0, //不显示遮罩
           area: ['300px']
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


