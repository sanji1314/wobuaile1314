<?php
$title='站长帮助';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
?>
<link href="//unpkg.com/layui@2.8.6/dist/css/layui.css" rel="stylesheet">
<div class="app-content-body ">
    <div class="wrapper-md control">
        <div class="layui-row layui-col-space8 layui-anim layui-anim-upbit">
            <div class="layui-card" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active">
                      <a data-toggle="tab" href="#jc">基础设置</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" href="#get">自带get配置</a>
                    </li>
                </ul>
                
               <div class="tab-content">  
    <div class="tab-pane fade active in" id="jc">  
        <blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">如果你能看到这里，恭喜你已经成功了一大步，那么接下来跟着我一起进行一些基础操作吧</span><br>
            <span style="color: #6699FF;">本教程适合新入行小站长，日订单在20-200左右的新手</span><br> 
            <span style='color: #FF0033;'>基础版本配置要求服务器2H2G起步 宝塔—计划任务-访问URL 监控如下地址</span>  
        </blockquote>  
<pre class="layui-code code-demo" lay-title="提交订单，建议一分钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/cron?act=add</pre>

<pre class="layui-code code-demo" lay-title="订单更新监控，建议1秒钟一次">http://<?echo($_SERVER['SERVER_NAME']);?>/cron.php?act=auto_monitor_single</pre>
    </div>  


                    <div class="tab-pane fade" id="get">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<blockquote class="layui-elem-quote layui-quote-nm">  
            <span style="color: #6699FF;">修改get/interface/config.php</span><br> 
            <span style='color: #FF0033;'>上面修改数据库配置信息即可</span>  
        </blockquote>  
        							
                                        
        						</table>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="tab-pane fade" id="cd">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<pre class="layui-code code-demo" lay-title="补单">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=budan</pre>
        							<pre class="layui-code code-demo" lay-title="29查单">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=chadan</pre>
        							<pre class="layui-code code-demo" lay-title="进阶查单（非专业人士别动）">http://<?echo($_SERVER['SERVER_NAME']);?>/api/search?uid=</pre>
        							
                                        <table class="layui-table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="text-center" style="width:100px">请求参数</th>
                                                <th>
                                                    说明<br>
                                                </th>
                                                <th class="text-center" style="width:100px">
                                                    传输类型<br>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <tr>
                                                <th class="text-center" scope="row">uid</th>
                                                <td><code>登录验证</code></td>
                                                <td class="text-center"><code>补单必传(查单非必传)</code></td>
                                            </tr>
                                            <tr>
                                                <th class="text-center" scope="row">key</th>
                                                <td><code>登录验证</code></td>
                                                <td class="text-center"><code>补单必传(查单非必传)</code></td>
                                                </tr>
                                            <tr>
                                                <th class="text-center" scope="row">id</th>
                                                <td><code>订单账号</code></td>
                                                <td class="text-center"><code>必传</code></td>
                                            </tr>
                                            </tr>
                                            </tbody>
        						</table>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                                        <div class="tab-pane fade" id="kcid">
                        <div class="modal-content">
                            <div class="table-responsive">
                                <table class="table table-striped">
        							<thead><tr><th>对接ID</th><th>分类ID</th><th>商品名称</th><th>你的价格</th></thead>
        								<tbody>
        									<?php 
        										$a=$DB->query("select * from qingka_wangke_class where status=1 ");
        										while($rs=$DB->fetch($a)){
        										echo "<tr><td>".$rs['cid']."</td><td>".$rs['fenlei']."</td><td>".$rs['name']."</td><td>".$rs['price']*$fl."</td></tr>"; 
        										}
        									?>
                                    	</tbody>
        						</table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="xc">
                     <pre class="layui-code code-demo" lay-title="需要访问的URL地址：">http://<?echo($_SERVER['SERVER_NAME']);?>/api.php?act=add</pre>
                       <pre class="layui-code code-demo" lay-title="请求Post数据[POST]" lay-options="{}">
uid|你的对接UID
key|你的对接KEY
platform|平台课程ID
user|[input1]
pass|[input2]
school|[input3]
kcname|[input4]

输入框规则：账号|密码|学校|课程

                        </pre>
                        <blockquote class="layui-elem-quote layui-quote-nm">
							<span style='color: #FF0033;'>因为一些必须要传课程id，比如学习通，智慧树这些，其他的需要的就在本平台查一下课看看返回有没有id，有就是需要，所以对接规则需要改成如下，如果不传课程id将不走进度，课程id是查课自动返回获取的。所以有id的课程必须使用老韩的查课插件，如果实在不懂可以联系你的上级、授权商去问</span>
						</blockquote> 
                        <pre class="layui-code code-demo" lay-title="请求Post数据[POST]" lay-options="{}">

uid|你的对接UID
key|你的对接KEY
platform|平台课程ID
user|[input1]
pass|[input2]
school|[input3]
kcid|[input4]
kcname|[input5]

输入框规则：账号|密码|学校|课程ID|课程名

                        </pre>
                    </div>
                    
                    <div class="tab-pane fade" id="xx">
                    <div class="modal-content">
                        <div class="table-responsive"> 
    						<table class="table table-striped">
    							<thead><tr><th>对接ID</th><th>对接KEY</th><th>下单比限制</th><th>当前下单比</th></thead>
    								<tbody>
    									<?php 
    										$a=$DB->query("select * from qingka_wangke_user where uid='{$userrow['uid']}'");
    										
    										while($rs=$DB->fetch($a)){
    										    if($userrow['key']=="0"){
    										    $rs['key']="未开通KEY";
    										    echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>". $conf['api_proportion']."%</td><td>".$xdb."%</td></tr>"; 
    										    }else{
    										        echo "<tr><td>".$rs['uid']."</td><td>".$rs['key']."</td><td>".$conf['api_proportion']."%</td><td>".$xdb."%</td></tr>"; 
    										    }
    										}
    									?>
                                	</tbody>
    							</table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 

<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="https://cdn.staticfile.org/vue/2.6.11/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>
<script src="//unpkg.com/layui@2.8.6/dist/layui.js"></script>  
<script src="assets/js/element.js"></script>


<script>
    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
      var element = layui.element;
      
      //…
    });
</script>

<script>
new Vue({
	el:"#loglist",
	data:{
		row:null
	},
	methods:{
		get:function(page){

		}
	},
	mounted(){
		this.get(1);
	}
});
</script>
<script>
layui.use(function(){
  // code
  layui.code({
    elem: '.code-demo',
    skin: 'dark',
    about: false,
    ln: false,
    header: true,
    preview: false,
    //tools: ['full', 'copy']
  });
})
//点击复制
/*function copyToClip(content, message = null) {
        var aux = document.createElement("input");
        aux.setAttribute("value", content);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
        if (message == null) {
            layer.msg("复制成功", {icon: 1});
        } else {
            layer.msg(message, {icon: 1});
        }
    }*/
</script>

