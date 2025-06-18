<?php
$title='查QQ绑定';
require_once('head.php');
$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
?>
<html>

<head>
    <meta charset="UTF-8">
     <meta name="robots" content="noarchive">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- import CSS -->
    <link rel="stylesheet" href="haowan/css/index.css">
    <title>查询手机号</title>
    <script type="text/javascript" src="//js.users.51.la/21562325.js"></script>
</head>

<body>
    <div id="app">
	                      <div class="col-sm-12" id="pay2" style="display: none;">
				            </li>   		          
				          </div>
				          <div class="panel panel-default" class="" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 10px;">
				             <div class="layui-card-header" >	
				             查QQ绑定手机号
				             </div>
				            	          
				              <div class="card-body">
        <div class="el-dialog" tabindex="1" style="--el-dialog-width:1580px;">
            <div style="display: flex; justify-content: column-reverse;">
               
                <el-input v-model="qq" type="qq" placeholder="请输入查询QQ"></el-input><el-button
                    @click="chaxun">查询</el-button>
            </div>

            <div id="el-id-2505-14" class="el-dialog__body">
                <div style="display: flex;justify-content: space-around;">
                    <div style=" display: flex;flex-direction: column;justify-content: center;align-items: center;">
                        <span data-v-042bec9f="">QQ</span>
                        <h1 data-v-042bec9f="">{{data.qq}}</h1>
                    </div>
                    <div style=" display: flex;flex-direction: column;justify-content: center;align-items: center;">
                        <span data-v-042bec9f="">手机号</span>
                        <h1 data-v-042bec9f="">{{data.phone}}</h1>
                    </div>
                </div>
                    <div style=" display: flex;flex-direction: column;justify-content: center;align-items: center;">
                        <span data-v-042bec9f="">归属地</span>
                        <h1 data-v-042bec9f="">{{data.phonediqu}}</h1>
                    </div>
                </div>

	    </div> 
	     
        
	   </div> 
	     
		 
       </div>
            </div>

        </div>

    </div>

</body>

<!-- import Vue before Element -->
<script src="haowan/vue.js"></script>
<!-- import JavaScript -->
<script src="haowan/index.js"></script>
<script src="haowan/axios.min.js"></script>




	<style>
		#app{
			width: 50%;
			margin: auto;
			margin-top: 10%;
		}
	</style>
	<script>
	let vue = new Vue({
		el:"#app",
		data: function() {
		        return { 
					qq:"",
					data:{},
					dialogVisible:false
				}
		},methods:{
			chaxun(){
				//开启框架加载事件
				this.$loading({
					text:"查询中"
				})
				//使用Jquery发起请求
				$.get("https://zy.xywlapi.cc/qqapi?qq="+this.qq).then(res=>{
					//校验返回状态码
					if(res.status==500){
						this.$message.warning(res.message);
					}else if(res.status==200){
						//保存相应对象
						this.data = res
						//开启弹窗
						this.dialogVisible = true
					}
					//关闭ui组件加载
					this.$loading().close()
				})
				//捕捉异常
				.catch(()=>{
					//关闭ui组件加载
					
					this.$loading().close()
					//提醒用户查询错误
					this.$message.error("请求错误！");
				})
			}
		}
	})
	</script>
</html>